<?php

namespace App\Repository;

use App\Entity\Formulas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formulas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formulas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formulas[]    findAll()
 * @method Formulas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormulasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formulas::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Formulas $entity, bool $flush = true): void
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
    public function remove(Formulas $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Get number of formulas by project
     *
     * @param [type] $value
     * @return array
     */
    public function getNbFormulaByProjet($value):array {

        return $this->createQueryBuilder('f')
                        ->select('count(f.id)')
                        ->andWhere('f.projects = :val')
                        ->setParameter('val', $value)
                        ->getQuery()
                        ->getSingleResult()
                    ;
    }

    // /**
    //  * @return Formulas[] Returns an array of Formulas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Formulas
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
