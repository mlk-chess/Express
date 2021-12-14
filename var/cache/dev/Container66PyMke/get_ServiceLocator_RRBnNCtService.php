<?php

namespace Container66PyMke;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class get_ServiceLocator_RRBnNCtService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private '.service_locator.RRBnNCt' shared service.
     *
     * @return \Symfony\Component\DependencyInjection\ServiceLocator
     */
    public static function do($container, $lazyLoad = true)
    {
        return $container->privates['.service_locator.RRBnNCt'] = new \Symfony\Component\DependencyInjection\Argument\ServiceLocator($container->getService, [
            'offerRepository' => ['privates', 'App\\Repository\\OfferRepository', 'getOfferRepositoryService', true],
        ], [
            'offerRepository' => 'App\\Repository\\OfferRepository',
        ]);
    }
}
