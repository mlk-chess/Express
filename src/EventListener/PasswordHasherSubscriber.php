<?php
// src/EventListener/DatabaseActivitySubscriber.php
namespace App\EventListener;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PreFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHasherSubscriber implements EventSubscriberInterface
{
    /** @var UserPasswordHasherInterface $userPasswordHasher */
    private $userPasswordHasher;
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
      $this->userPasswordHasher = $userPasswordHasher;
    }

// this method can only return the event names; you cannot define a
// custom method name to execute when each event triggers
    public function getSubscribedEvents(): array
    {
        return [
            Events::preFlush,
        ];
    }

// callback methods must be called exactly like the events they listen to;
// they receive an argument of type LifecycleEventArgs, which gives you access
// to both the entity object of the event and the entity manager itself
    public function preFlush(PreFlushEventArgs $args): void
    {
        $em = $args->getEntityManager();
        $unitOfWork = $em->getUnitOfWork();
        foreach ($unitOfWork->getScheduledEntityInsertions() as $obj){

            if ($obj instanceof User && $obj->getPlainPassword()){
                $obj->setPassword($this->userPasswordHasher->hashPassword($obj, $obj->getPlainPassword()));
            }
        }
    }
}