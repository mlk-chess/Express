<?php

namespace Container406d25b;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getReservationControllerService extends App_KernelDevDebugContainer
{
    /**
     * Gets the public 'App\Controller\Back\ReservationController' shared autowired service.
     *
     * @return \App\Controller\Back\ReservationController
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/framework-bundle/Controller/AbstractController.php';
        include_once \dirname(__DIR__, 4).'/src/Controller/Back/ReservationController.php';

        $container->services['App\\Controller\\Back\\ReservationController'] = $instance = new \App\Controller\Back\ReservationController();

        $instance->setContainer(($container->privates['.service_locator.W9y3dzm'] ?? $container->load('get_ServiceLocator_W9y3dzmService'))->withContext('App\\Controller\\Back\\ReservationController', $container));

        return $instance;
    }
}
