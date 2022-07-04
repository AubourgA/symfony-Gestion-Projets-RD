<?php

namespace App\Repository;

use App\Entity\Projects;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projects|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projects|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projects[]    findAll()
 * @method Projects[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projects::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Projects $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Projects $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * get all project where status on parameter
     *
     * @param [type] $value
     * @return void
     */
    public function getInProgress($value)
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->andwhere('p.status = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getSingleResult();
    }
    /**
     * get Nb of project of user with parameter
     *
     * @param [type] $val1
     * @param [type] $val2
     * @return void
     */
    public function getMyProjectInProgress($val1, $val2)
    {
        return $this->createQueryBuilder('p')
        ->select('count(p)')
        ->andwhere('p.status = :val1')
        ->andwhere('p.User = :val2')
        ->setParameter('val1', $val1)
        ->setParameter('val2', $val2)
        ->getQuery()
        ->getSingleScalarResult();
    }

    /**
     * get all projects of current user and all project visible for all
     *
     * @param [type] $user
     * @param [type] $visible
     * @return void
     */
    public function getCustomProject($user, $visible) 
    {
        return $this->createQueryBuilder('p')
        ->select('p')
        ->andwhere('p.User = :user')
        ->orWhere('p.isVisible = :visible')
        ->setParameter('user', $user)
        ->setParameter('visible', $visible)
        ->getQuery()
        ->getResult();
    }

    // /**
    //  * @return Projects[] Returns an array of Projects objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Projects
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
