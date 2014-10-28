<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class FamilleRepository
 * @package Horus\BackendBundle\Repository
 */
class FamilleRepository extends EntityRepository
{

    /**
     * Get Active Familles
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveFamilleQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Famille', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }



    /**
     * Get articles by Category
     * @param Category $category
     * @return mixed
     */
    public function getFamilleIsProductNull()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Famille a  WHERE a.produits IS EMPTY");
        return $query->getSingleScalarResult();
    }

    /**
     * Get articles by Category
     * @param Category $category
     * @return mixed
     */
    public function getFamilleIsDesactive()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Famille a WHERE a.visible = :visible")
            ->setParameter('visible', false);
        return $query->getSingleScalarResult();
    }



}