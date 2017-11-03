<?php

namespace Bellisq\ContainerWithProvider;

use Throwable;
use Bellisq\TypeBasedContainer\TypeBasedContainerInterface;
use Bellisq\Instantiator\InstantiatorInterface;
use Bellisq\Validator\{
    ValidatorInterface,
    PassValidator,
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
    InvalidObjectTypeException,
    ObjectNameConflictionException,
    NotFoundException,
    TooManyCandidatesException,
    ObjectTypeErrorException
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

    abstract static protected function registerProviders(ProviderRegister $pr): void;

    public function get($name, ?string $type = null)
    {
        $solveResult = $this->solveName($name, $type);

        if (self::SOLVE_FOUND === $solveResult) {
            $uName = ($this->objectNameValidator->validate($name)) ? $name : null;
            $sig   = self::generateSignature($uName, $type);
            return $this->getInstance($this->nameCache[$sig]);
        }

        throw self::exceptionThrow($solveResult);
    }

    public function has($name, ?string $type = null): bool
    {
        return self::SOLVE_FOUND === $this->solveName($name, $type);
    }

    final public function __construct(InstantiatorInterface $instantiator, ?ProviderClassValidator $providerTypeNameValidator = null, ?ValidatorInterface $objectTypeValidator = null)
    {
        $this->instantiator = $instantiator;
        $this->providers    = [];

        $this->providerTypeNameValidator = $providerTypeNameValidator ?? new ProviderClassValidator(ProviderAbstract::class);
        $this->objectNameValidator       = new BasicIdentifierValidator(1, 63);
        $this->objectTypeValidator       = $objectTypeValidator ?? new PassValidator;

        $providerTransport = new ProviderTransport;
        static::registerProviders(new ProviderRegister($providerTransport));

        foreach ($providerTransport->get() as list($providerName, $quickLoad)) {
            $this->registerProvider($providerName);
            if ($quickLoad) {
                $this->registerQuickLoad($providerName);
            }
        }

        $this->executeQuickLoad();
    }

    /* -------------------------------------------------------------------------
     * 
     * Registeration
     * 
     * ---------------------------------------------------------------------- */

    private function registerProvider(string $providerName): void
    {
        if (!$this->providerTypeNameValidator->validate($providerName)) {
            throw new InvalidProviderException;
        }
        if (array_key_exists($providerName, $this->providers)) {
            throw new DuplicateProviderException;
        }

        $ot = new ObjectDefinitionTransport;
        [$providerName, 'register'](new ObjectDefinitionRegister($ot));
        foreach ($ot->get() as list($name, $type, $isSingleton)) {
            $this->registerObject($providerName, $name, $type, $isSingleton);
        }

        $this->providers[$providerName] = null;
    }

    private function registerObject(string $providerName, string $objectName, string $objectType, bool $isSingleton): void
    {
        if (!$this->objectNameValidator->validate($objectName)) {
            throw new InvalidObjectNameException;
        }
        if (!$this->objectTypeValidator->validate($objectType)) {
            throw new InvalidObjectTypeException;
        }
        if (isset($this->objectProvider[$objectName])) {
            throw new ObjectNameConflictionException;
        }
        $this->objectProvider[$objectName]   = $providerName;
        $this->isSingleton[$objectName]      = $isSingleton;
        $this->objectType[$objectName]       = $objectType;
        $this->typeObjectName[$objectType][] = $objectName;
    }

    private function registerQuickLoad(string $providerName)
    {
        $this->quickLoads[] = $providerName;
    }

    /* -------------------------------------------------------------------------
     * 
     * Instantiation
     * 
     * ---------------------------------------------------------------------- */

    private function executeQuickLoad()
    {
        foreach ($this->quickLoads as $qlProviderName) {
            $this->providers[$qlProviderName] = $this->instantiator->instantiate($qlProviderName);
        }
    }

    private function getInstance(string $validatedObjectName)
    {
        $providerName = $this->objectProvider[$validatedObjectName];

        $this->loadProviderLazy($providerName);

        if ($this->isSingleton[$validatedObjectName]) {
            $rv = $this->getSingleton($providerName, $validatedObjectName);
        } else {
            $rv = $this->providers[$providerName]->getInstance($validatedObjectName);
        }

        if (!is_a($rv, $this->objectType[$validatedObjectName])) {
            throw new ObjectTypeErrorException;
        }
        return $rv;
    }

    private function getSingleton(string $providerName, string $validatedObjectName)
    {
        if (!isset($this->singletonObjects[$validatedObjectName])) {
            $this->singletonObjects[$validatedObjectName] = $this->providers[$providerName]->getInstance($validatedObjectName);
        }
        return $this->singletonObjects[$validatedObjectName];
    }

    private function loadProviderLazy(string $providerName)
    {
        if (is_null($this->providers[$providerName])) {
            $this->loadProvider($providerName);
        }
    }

    private function loadProvider(string $providerName)
    {
        $this->providers[$providerName] = $this->instantiator->instantiate($providerName);
    }

    private static function generateSignature(?string $uName, ?string $type): string
    {
        return "{$uName}:{$type}";
    }

    private function solveName($name, ?string $type): int
    {
        $uName = ($this->objectNameValidator->validate($name)) ? $name : null;
        $sig   = self::generateSignature($uName, $type);

        if (isset($this->cache[$sig])) {
            return $this->cache[$sig];
        }

        if (is_null($type)) {
            return $this->solveWithoutType($uName, $sig);
        }

        if (isset($this->typeObjectName[$type])) {
            $typeBaseCandidates = $this->typeObjectName[$type];
            return $this->solveWithExactType($typeBasedCandidates, $sig, $uName);
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
            return $this->foundReturn($sig, $candidates[0][0]);
        }
        return $this->cache[$sig] = self::SOLVE_TOOMANY;
    }

    private function solveWithExactType(array $typeBasedCandidates, string $sig, string $uName)
    {
        if (count($typeBaseCandidates) === 1) {
            return $this->foundReturn($sig, $typeBaseCandidates[0]);
        }
        foreach ($typeBaseCandidates as $candidateName) {
            if ($candidateName === $uName) {
                return $this->foundReturn($sig, $uName);
            }
        }
        return $this->cache[$sig] = self::SOLVE_TOOMANY;
    }

    private function solveWithoutType(?string $uName, string $sig)
    {
        if (!is_null($uName) && isset($this->objectProvider[$uName])) {
            return $this->foundReturn($sig, $uName);
        }
        return $this->cache[$sig] = self::SOLVE_NOT_FOUND;
    }

    private function foundReturn(string $sig, string $objectName)
    {
        $this->nameCache[$sig] = $objectName;

        return $this->cache[$sig] = self::SOLVE_FOUND;
    }

    private static function exceptionThrow(int $result): Throwable
    {
        if ($result === self::SOLVE_TOOMANY) {
            return new TooManyCandidatesException;
        }
        return new NotFoundException;
    }

    private const SOLVE_FOUND     = 1;
    private const SOLVE_TOOMANY   = 100;
    private const SOLVE_NOT_FOUND = 10000;

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
     * [ objectName => typeName ]
     * 
     * @var string[]
     */
    private $objectType = [];

    /**
     * [ type => [ objectName => objectName ] ]
     * 
     * @var array[]
     */
    private $typeObjectName = [];

    /** @var ValidatorInterface */
    private $providerTypeNameValidator;

    /** @var ValidatorInterface */
    private $objectNameValidator;

    /** @var ValidatorInterface */
    private $objectTypeValidator;

    /**
     * [ quickLoadProviderName ]
     * @var string[]
     */
    private $quickLoads = [];

    /**
     * [ signature => SOLVE_CONSTANTS ]
     * 
     * @var int[]
     */
    private $cache = [];

    /**
     * [ signature => objectName ]
     * 
     * @var string[]
     */
    private $nameCache = [];

}
