<?php

namespace App\Repository;

use App\Entity\Program;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Program>
 *
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function save(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findLikeName(string $value): array
    {
        return $this->createQueryBuilder('p')
            ->Where('p.title LIKE :name')
            ->join('p.actors', 'a')
            ->orWhere('a.name LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->getResult()
        ;

        /*
        $em = $this->getEntityManager();
        $query = $em->createQuery(
            'SELECT p, a 
            FROM App\Entity\Program p
            LEFT JOIN p.actors a 
            WHERE (p.title LIKE :name OR a.name LIKE :name)'
        );
        $query->setParameter('name', '%' . $value . '%');
        return $query->getResult();


        $em = $this->getEntityManager();
        $query = $em->createQuery('SELECT p FROM App\Entity\Program p WHERE p.title LIKE :name');
        $query->setParameter('name', '%' . $value . '%');
        return $query->getResult();


        return $this->createQueryBuilder('p')
            ->Where('p.title LIKE :name')
            ->setParameter('name', '%' . $value . '%')
            ->getQuery()
            ->getResult()
        ;
*/
    }

    //    /**
    //     * @return Program[] Returns an array of Program objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Program
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
