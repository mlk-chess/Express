<?php

namespace ContainerHDQbAhq;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHoldera17a3 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerabd16 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesb74a0 = [
        
    ];

    public function getConnection()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getConnection', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getMetadataFactory', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getExpressionBuilder', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'beginTransaction', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getCache', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getCache();
    }

    public function transactional($func)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'transactional', array('func' => $func), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'wrapInTransaction', array('func' => $func), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'commit', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->commit();
    }

    public function rollback()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'rollback', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getClassMetadata', array('className' => $className), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'createQuery', array('dql' => $dql), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'createNamedQuery', array('name' => $name), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'createQueryBuilder', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'flush', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'clear', array('entityName' => $entityName), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->clear($entityName);
    }

    public function close()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'close', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->close();
    }

    public function persist($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'persist', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'remove', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'refresh', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'detach', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'merge', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getRepository', array('entityName' => $entityName), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'contains', array('entity' => $entity), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getEventManager', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getConfiguration', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'isOpen', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getUnitOfWork', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getProxyFactory', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'initializeObject', array('obj' => $obj), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'getFilters', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'isFiltersStateClean', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'hasFilters', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return $this->valueHoldera17a3->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerabd16 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHoldera17a3) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHoldera17a3 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHoldera17a3->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__get', ['name' => $name], $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        if (isset(self::$publicPropertiesb74a0[$name])) {
            return $this->valueHoldera17a3->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera17a3;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldera17a3;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera17a3;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHoldera17a3;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__isset', array('name' => $name), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera17a3;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHoldera17a3;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__unset', array('name' => $name), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHoldera17a3;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHoldera17a3;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__clone', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        $this->valueHoldera17a3 = clone $this->valueHoldera17a3;
    }

    public function __sleep()
    {
        $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, '__sleep', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;

        return array('valueHoldera17a3');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerabd16 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerabd16;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerabd16 && ($this->initializerabd16->__invoke($valueHoldera17a3, $this, 'initializeProxy', array(), $this->initializerabd16) || 1) && $this->valueHoldera17a3 = $valueHoldera17a3;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHoldera17a3;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHoldera17a3;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
