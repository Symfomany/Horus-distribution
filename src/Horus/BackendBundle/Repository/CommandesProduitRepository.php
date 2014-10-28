<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class CommandesProduitRepository
 * @package Horus\BackendBundle\Repository
 */
class CommandesProduitRepository extends EntityRepository
{

    public function getCommandesReapro()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Commandes a WHERE a.etat = :etat")
            ->setParameter('etat', 2);
        return $query->getSingleScalarResult();
    }

    public function getCommandesVirr()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Commandes a WHERE a.etat = :etat")
            ->setParameter('etat', 3);
        return $query->getSingleScalarResult();
    }

    public function getCommandesLiv()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Commandes a WHERE a.etat = :etat")
            ->setParameter('etat', 4);
        return $query->getSingleScalarResult();
    }

    public function getCommandesErreur()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Commandes a WHERE a.etat = :etat")
            ->setParameter('etat', 5);
        return $query->getSingleScalarResult();
    }

    public function getCommandesPrepa()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Commandes a WHERE a.etat = :etat")
            ->setParameter('etat', 8);
        return $query->getSingleScalarResult();
    }


}