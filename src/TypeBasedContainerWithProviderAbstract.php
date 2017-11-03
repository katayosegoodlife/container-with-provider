<?php

namespace Bellisq\ContainerWithProvider;

use Bellisq\TypeBasedContainer\TypeBasedContainerInterface;
use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\Validator\{
    ValidatorInterface,
    General\BasicIdentifierValidator
};
use Bellisq\ContainerWithProvider\{
    Com\ProviderTransport,
    ProviderAbstract,
    ProviderClassValidator,
    ProviderRegister,
    // Object Definition Registration
    Com\ObjectDefinitionTransport,
    ObjectDefinitionRegister
};
use Bellisq\ContainerWithProvider\Exceptions\{
    InvalidProviderException,
    DuplicateProviderException,
    InvalidObjectNameException,
    ObjectNameConflictionException,
    NotFoundException,
    TooManyCandidatesException
};


/**
 * [ Provider ] Abstract Provider
 * 
 * To deny multi-purpose classes, abstract class is provided instead of interface.
 *
 * @author 4kizuki <akizuki.c10.l65@gmail.com>
 * @copyright 2017 4kizuki. All Rights Reserved.
 * @package bellisq/container-with-provider
 * @since 1.0.0
 */
abstract class TypeBasedContainerWithProviderAbstract implements TypeBasedContainerInterface
{

    /** @var InstantiatorInterface */
    private $instantiator;

    /**
     * [ providerName => null | provider ]
     * @var ProviderAbstract[]
     */
    private $providers = [];

    /**
     * [ objectName => isSingleton ]
     * 
     * @var bool[]
     */
    private $isSingleton = [];

    /**
     * [ objectName => object ]
     * 
     * @var array
     */
    private $singletonObjects = [];

    /**
     * [ objectName => providerName ]
     * 
     * @var string[]
     */
    private $objectProvider = [];

    /**
     * [ type => [ objectName => objectName ] ]
     * 
     * @var array[]
     */
    private $typeObjectName = [];

    /** @var ValidatorInterface */
    private $providerNameValidator;

    /** @var ValidatorInterface */
    private $objectNameValidator;

    final public function __construct(ProviderClassValidator $providerNameValidator, InstantiatorInterface $instantiator)
    {
        $this->instantiator = $instantiator;
        $this->providers    = [];

        $this->providerNameValidator = $providerNameValidator;
        $this->objectNameValidator   = new BasicIdentifierValidator(1, 63);

        $quickLoads = [];

        $pt = new ProviderTransport;
        static::registerProviders(new ProviderRegister($pt));
        foreach ($pt->get() as list($providerName, $quickLoad)) {
            $this->registerProvider($providerName);
            if ($quickLoad) {
                $quickLoads[] = $providerName;
            }
        }
        foreach ($quickLoads as $qlProviderName) {
            $this->providers[$qlProviderName] = $this->instantiator->instantiate($qlProviderName);
        }
    }

    private function registerProvider(string $providerName): void
    {
        if (!$this->providerNameValidator->validate($providerName)) {
            throw new InvalidProviderException;
        }
        if (isset($this->providers[$providerName])) {
            throw new DuplicateProviderException;
        }

        $ot = new ObjectDefinitionTransport;
        [$providerName, 'register'](new ObjectDefinitionRegister($ot));
        foreach ($ot->get() as list($name, $type, $isSingleton)) {
            $this->registerObject($providerName, $name, $type, $isSingleton);
        }

        $this->providers[$providerName] = null;
    }

    private function registerObject(string $providerName, string $name, string $type, bool $isSingleton): void
    {
        if (!$this->objectNameValidator->validate($name)) {
            throw new InvalidObjectNameException;
        }
        if (isset($this->objectProvider[$name])) {
            throw new ObjectNameConflictionException;
        }
        $this->objectProvider[$name]   = $providerName;
        $this->isSingleton[$name]      = $isSingleton;
        $this->typeObjectName[$type][] = $name;
    }

    abstract static protected function registerProviders(ProviderRegister $pr): void;

    private function getInstance(string $validatedObjectName)
    {
        $providerName = $this->objectProvider[$validatedObjectName];
        if (is_null($this->providers[$providerName])) {
            $this->loadProvider($providerName);
        }
        
        if ($this->isSingleton[$validatedObjectName]) {
            if (isset($this->singletonObjects[$validatedObjectName])) {
                return $this->singletonObjects[$validatedObjectName];
            }
            $this->singletonObjects[$validatedObjectName] = $this->providers[$providerName]->getInstance($validatedObjectName);
        } else {
            return $this->providers[$providerName]->getInstance($validatedObjectName);
        }
    }

    private function loadProvider(string $providerName)
    {
        $this->providers[$providerName] = $this->instantiator->instantiate($providerName);
    }

    public function get($name, ?string $type = null)
    {
        switch ($this->solveName($name, $type)) {
            case self::SOLVE_FOUND:
                $uName = ($this->objectNameValidator->validate($name)) ? $name : null;
                $sig   = "{$uName}:{$type}";
                return $this->getInstance($this->cache[$sig]);
            case self::SOLVE_NOT_FOUND:
                throw new NotFoundException;
            case self::SOLVE_TOOMANY:
                throw new TooManyCandidatesException;
        }
        return null;
    }

    public function has($name, ?string $type = null): bool
    {
        return self::SOLVE_FOUND === $this->solveName($name, $type);
    }

    private const SOLVE_FOUND     = 1;
    private const SOLVE_TOOMANY   = 100;
    private const SOLVE_NOT_FOUND = 10000;

    private $cache = [];

    private function solveName($name, ?string $type): int
    {
        $uName = ($this->objectNameValidator->validate($name)) ? $name : null;
        $sig   = "{$uName}:{$type}";
        if (is_null($type)) {
            if (is_null($uName)) {
                return $this->cache[$sig] = self::SOLVE_NOT_FOUND;
            }
            if (isset($this->objectProvider[$uName])) {
                $this->cache[$sig] = $uName;
                return self::SOLVE_FOUND;
            }
            return $this->cache[$sig] = self::SOLVE_NOT_FOUND;
        }

        if (isset($this->typeObjectName[$type])) {
            if (count($this->typeObjectName[$type]) === 1) {
                $this->cache[$sig] = $this->typeObjectName[$type][0];
                return self::SOLVE_FOUND;
            }
            return $this->cache[$sig] = self::SOLVE_TOOMANY;
        }

        $candidates = [];
        foreach ($this->typeObjectName as $candidateType => $cand) {
            if (is_subclass_of($candidateType, $type, true)) {
                $candidates[] = $cand;
            }
        }

        $c = count($candidates);
        if ($c === 0) {
            return $this->cache[$sig] = self::SOLVE_NOT_FOUND;
        }
        if ($c === 1 && count($candidates[0]) === 1) {
            $this->cache[$sig] = $candidates[0][0];
            return self::SOLVE_FOUND;
        }
        return $this->cache[$sig] = self::SOLVE_TOOMANY;
    }

}
