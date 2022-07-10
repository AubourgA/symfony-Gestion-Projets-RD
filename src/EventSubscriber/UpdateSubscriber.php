<?php

namespace App\EventSubscriber;

use DateTimeZone;
use App\Entity\User;
use App\Entity\Tests;
use App\Entity\Results;
use App\Entity\Comments;
use App\Entity\Formulas;
use Doctrine\ORM\Events;
use App\Entity\Materials;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;


class UpdateSubscriber implements EventSubscriberInterface 
{

    private $entityManager;
 
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
 
    
    public  function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postUpdate,
            Events::postRemove

        ];
    }

    public function postPersist(LifecycleEventArgs $args)
    {
      $this->updateProject($args);
    }
    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->updateProject($args);
    }
    public function postRemove(LifecycleEventArgs $args)
    {
        $this->updateProject($args);
    }


    private function updateProject(LifecycleEventArgs $args):void
    {
       $entity = $args->getObject();

      if($entity instanceof User || $entity instanceof Materials || $entity instanceof Tests) {
        return;
      }

    if($entity instanceof Results) {
         $project = $entity->getFormula()->getProjects()->setUpdatedAt(new \DateTimeImmutable('now', new DateTimeZone('+0200')));
        $this->entityManager->persist($project);
        $this->entityManager->flush();
        
    }

    if($entity instanceof Comments) {
        $project = $entity->getFormula()->getProjects()->setUpdatedAt(new \DateTimeImmutable('now', new DateTimeZone('+0200')));
       $this->entityManager->persist($project);
       $this->entityManager->flush();
       
   }
 }
}