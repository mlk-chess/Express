<?php

namespace Container66PyMke;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getDefaultController2Service extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\Front\DefaultController' shared autowired service.
     *
     * @return \App\Controller\Front\DefaultController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/Front/DefaultController.php';

        $container->services['App\\Controller\\Front\\DefaultController'] = $instance = new \App\Controller\Front\DefaultController();

        $instance->setContainer(($container->privates['.service_locator.W9y3dzm'] ?? $container->load('get_ServiceLocator_W9y3dzmService'))->withContext('App\\Controller\\Front\\DefaultController', $container));

        return $instance;
    }
}
