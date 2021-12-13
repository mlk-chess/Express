<?php

namespace ContainerEJyMJ39;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolderdd005 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializer1fc5a = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesf1ac2 = [
        
    ];

    public function getConnection()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getConnection', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getMetadataFactory', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getExpressionBuilder', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'beginTransaction', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->beginTransaction();
    }

    public function getCache()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getCache', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getCache();
    }

    public function transactional($func)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'transactional', array('func' => $func), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'wrapInTransaction', array('func' => $func), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'commit', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->commit();
    }

    public function rollback()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'rollback', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getClassMetadata', array('className' => $className), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'createQuery', array('dql' => $dql), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'createNamedQuery', array('name' => $name), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'createQueryBuilder', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'flush', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'clear', array('entityName' => $entityName), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->clear($entityName);
    }

    public function close()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'close', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->close();
    }

    public function persist($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'persist', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'remove', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'refresh', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'detach', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'merge', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getRepository', array('entityName' => $entityName), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'contains', array('entity' => $entity), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getEventManager', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getConfiguration', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'isOpen', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getUnitOfWork', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getProxyFactory', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'initializeObject', array('obj' => $obj), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'getFilters', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'isFiltersStateClean', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'hasFilters', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return $this->valueHolderdd005->hasFilters();
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

        $instance->initializer1fc5a = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolderdd005) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolderdd005 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolderdd005->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__get', ['name' => $name], $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        if (isset(self::$publicPropertiesf1ac2[$name])) {
            return $this->valueHolderdd005->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderdd005;

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

        $targetObject = $this->valueHolderdd005;
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
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__set', array('name' => $name, 'value' => $value), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderdd005;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolderdd005;
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
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__isset', array('name' => $name), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderdd005;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolderdd005;
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
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__unset', array('name' => $name), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolderdd005;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolderdd005;
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
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__clone', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        $this->valueHolderdd005 = clone $this->valueHolderdd005;
    }

    public function __sleep()
    {
        $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, '__sleep', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;

        return array('valueHolderdd005');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializer1fc5a = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializer1fc5a;
    }

    public function initializeProxy() : bool
    {
        return $this->initializer1fc5a && ($this->initializer1fc5a->__invoke($valueHolderdd005, $this, 'initializeProxy', array(), $this->initializer1fc5a) || 1) && $this->valueHolderdd005 = $valueHolderdd005;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolderdd005;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolderdd005;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
