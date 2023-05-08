<?php

namespace App\Repository;

use App\Entity\Personne;
use App\Model\FiltrePersonne;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Personne>
 *
 * @method Personne|null find($id, $lockMode = null, $lockVersion = null)
 * @method Personne|null findOneBy(array $criteria, array $orderBy = null)
 * @method Personne[]    findAll()
 * @method Personne[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PersonneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Personne::class);
    }

    public function add(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Personne $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Query Returns an array of Personne objects
    */
   public function listePersonnesCompletePaginee(FiltrePersonne $filtre=null): ?Query
   {
       $query =  $this->createQueryBuilder('p');
           if(!empty($filtre->nom)){
            $query->andWhere('p.nom like :nomcherche')
            ->setParameter('nomcherche',"%{$filtre->nom}%");
           }
           if(!empty($filtre->coach)){
            $query->andWhere('p.coach = :coachcherche')
            ->setParameter('coachcherche',$filtre->coach);
           }
           if(!empty($filtre->joueur)){
            $query->andWhere('p.joueur = :joueurcherche')
            ->setParameter('joueurcherche',$filtre->joueur);
           }
           // Permet de filtrer sans additionner les catégories (Tout les jeux Football et tout les jeux FPS)
           if(!empty($filtre->lesEquipes) && ($filtre->lesEquipes->count()>0)) {
               $query->join('p.coach', 'c')
                   ->andWhere('c.id IN (:lesEquipes)')
                   ->setParameter('lesEquipes', $filtre->lesEquipes);
                   // dd($filtre->lesEquipes);
           }
        //    // Les coachs s'additionne pour le filtrage (A la fois equipe 1 et 2)
        //     if (!empty($filtre->lesEquipes)) {
        //         foreach ($filtre->lesEquipes as $key => $value) {
        //             $query->join('p.coach', 'c'.$key)
        //                 ->andWhere('c'.$key.'.id = :equipe'.$key)
        //                 ->setParameter('equipe'.$key, $value);
        //         }
        //     }
            // if(!empty($filtre->lesEquipes) && $filtre->lesEquipes->count()>0){
            //     $conditions=[];
            //     foreach ($filtre->styles as $key => $style) {
            //         $conditions[]= $query->expr()->isMemberOf(":styleRecherche$key","a.styles");
            //         $query->setParameter("styleRecherche$key", $style);      
            //     }
            //     $blocConditionsOr=$query->expr()->orX()->addMultiple($conditions);
            //     $query->andWhere($blocConditionsOr);
            // }
           $query->orderBy('p.prenom')
       ;
       return $query->getQuery();
   }

//    public function findOneBySomeField($value): ?Personne
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
