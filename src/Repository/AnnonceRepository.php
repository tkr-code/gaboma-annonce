<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    public function etat(string $etat, User $user = null ){
       $query = $this->query()
        ->andWhere('o.etat = :etat');
        if($user){

            $query->andWhere('o.user = :user ')
            ->setParameter('user',$user->getId());
        }
      return $query
        ->setParameter('etat',$etat)
        ->getQuery()
        ->getResult()
        ;
    }
        /**
     * Recheche les articles en fonctions du formulaire
     *
     * @param  mixed $var
     * @return void
     */
    public function search($mots=null, $category=null, $min=null, $max= null)
    {
        $query = $this->query()
        ->AndWhere('o.is_active = true')
        ->AndWhere("o.etat = 'En ligne' ");
        if($mots != null){
            $query->andWhere('MATCH_AGAINST(o.title, o.content) AGAINST(:mots boolean) > 0')
            ->setParameter('mots',$mots);
        }
        // if($min != null){
        //     $query
        //     ->andWhere("p.price >= :minprix ")
        //     ->setParameter("minprix",$min);
        //     }
        // if($max != null){
        //     $query
        //         ->andWhere("p.price <= :maxprix ")
        //         ->setParameter("maxprix",$max);
        // }
        // if($category != null){
        //     $query->leftJoin('p.category', 'c');
        //     $query->andWhere('c.id = :id')
        //     ->setParameter('id',$category);
        // } 
        return $query->getQuery();
    }
    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Annonce
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    public function query(){
        return $this->createQueryBuilder('o');
    }
}
