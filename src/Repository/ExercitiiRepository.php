<?php

namespace App\Repository;

use App\Entity\Exercitii;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Exercitii>
 */
class ExercitiiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exercitii::class);
    }

    public function findAllExercises(): array
    {
        return $this->createQueryBuilder('exercitii')
            ->select('exercitii', 'tip')
            ->join('exercitii.tip_id', 'tip')
            ->getQuery()
            ->getResult();
    }

    public function deleteExercise($exercise_id) {
        return $this->createQueryBuilder('exercitii')
            ->delete()
            ->where('exercitii.id = :id')
            ->setParameter('id', $exercise_id)
            ->getQuery()
            ->execute();
    }
    //    /**
    //     * @return Exercitii[] Returns an array of Exercitii objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Exercitii
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
