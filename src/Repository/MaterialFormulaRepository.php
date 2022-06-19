<?php

namespace App\Repository;

use App\Entity\MaterialFormula;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MaterialFormula|null find($id, $lockMode = null, $lockVersion = null)
 * @method MaterialFormula|null findOneBy(array $criteria, array $orderBy = null)
 * @method MaterialFormula[]    findAll()
 * @method MaterialFormula[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MaterialFormulaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MaterialFormula::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(MaterialFormula $entity, bool $flush = true): void
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
    public function remove(MaterialFormula $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return MaterialFormula[] Returns an array of MaterialFormula objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MaterialFormula
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
