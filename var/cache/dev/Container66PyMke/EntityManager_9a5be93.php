<?php

namespace Container66PyMke;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder4c763 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializereb5c9 = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicPropertiesa59db = [
        
    ];

    public function getConnection()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getConnection', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getMetadataFactory', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getExpressionBuilder', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'beginTransaction', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->beginTransaction();
    }

    public function getCache()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getCache', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getCache();
    }

    public function transactional($func)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'transactional', array('func' => $func), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->transactional($func);
    }

    public function wrapInTransaction(callable $func)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'wrapInTransaction', array('func' => $func), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->wrapInTransaction($func);
    }

    public function commit()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'commit', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->commit();
    }

    public function rollback()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'rollback', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getClassMetadata', array('className' => $className), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'createQuery', array('dql' => $dql), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'createNamedQuery', array('name' => $name), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'createQueryBuilder', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'flush', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'clear', array('entityName' => $entityName), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->clear($entityName);
    }

    public function close()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'close', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->close();
    }

    public function persist($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'persist', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'remove', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'refresh', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'detach', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'merge', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getRepository', array('entityName' => $entityName), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'contains', array('entity' => $entity), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getEventManager', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getConfiguration', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'isOpen', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getUnitOfWork', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getProxyFactory', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'initializeObject', array('obj' => $obj), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'getFilters', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'isFiltersStateClean', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'hasFilters', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return $this->valueHolder4c763->hasFilters();
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

        $instance->initializereb5c9 = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder4c763) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder4c763 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder4c763->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__get', ['name' => $name], $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        if (isset(self::$publicPropertiesa59db[$name])) {
            return $this->valueHolder4c763->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder4c763;

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

        $targetObject = $this->valueHolder4c763;
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
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__set', array('name' => $name, 'value' => $value), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder4c763;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder4c763;
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
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__isset', array('name' => $name), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder4c763;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder4c763;
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
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__unset', array('name' => $name), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder4c763;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder4c763;
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
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__clone', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        $this->valueHolder4c763 = clone $this->valueHolder4c763;
    }

    public function __sleep()
    {
        $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, '__sleep', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;

        return array('valueHolder4c763');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializereb5c9 = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializereb5c9;
    }

    public function initializeProxy() : bool
    {
        return $this->initializereb5c9 && ($this->initializereb5c9->__invoke($valueHolder4c763, $this, 'initializeProxy', array(), $this->initializereb5c9) || 1) && $this->valueHolder4c763 = $valueHolder4c763;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder4c763;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder4c763;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}
