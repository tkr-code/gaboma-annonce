<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\AnnonceSearch;
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

    public function User(User $user){
       return $this->query()
        ->andWhere('o.user = :user ')
        ->setParameter('user',$user->getId())
        ->getQuery()->getResult();

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
    public function search(AnnonceSearch $search)
    {
        $query = $this->query()
        ->AndWhere('o.is_active = true')
        ->AndWhere("o.etat = 'En ligne' ");
        if($search->getMots()){
            $query->andWhere('MATCH_AGAINST(o.title, o.content) AGAINST(:mots boolean) > 0')
            ->setParameter('mots',$search->getMots());
        }
        if($search->getMinPrice()){
            $query
            ->andWhere("o.price >= :minprix ")
            ->setParameter("minprix",$search->getMinPrice());
            }
        if($search->getMaxPrice()){
            $query
                ->andWhere("o.price <= :maxprix ")
                ->setParameter("maxprix",$search->getMaxPrice());
        }
        if($search->getCategory()){
            $query->leftJoin('o.category', 'c');
            $query->andWhere('c.id = :id')
            ->setParameter('id',$search->getCategory());
        } 
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
