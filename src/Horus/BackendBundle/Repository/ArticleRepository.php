<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ArticleRepository
 * @package Horus\BackendBundle\Repository
 */
class ArticleRepository extends EntityRepository
{


    /**
     * Get Active Page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getCountValidArticles($state = 3)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Article a WHERE a.nature = :state")
            ->setParameter('state', $state);
        return $query->getSingleScalarResult();
    }


    /**
     * @return QueryBuilder
     */
    public function createIsActiveQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Article', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }

    /**
     * Is Page
     * @return mixed
     */
    public function isPage()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a) nombre FROM HorusBackendBundle:Page a");
        return $query->getOneOrNullResult();
    }


    public function getArticlesIsDesactive()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Article a WHERE a.nature = :visible")
            ->setParameter('visible', 1);
        return $query->getSingleScalarResult();
    }


    public function getArticlesWait()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Article a WHERE a.nature = :visible")
            ->setParameter('visible', 2);
        return $query->getSingleScalarResult();
    }

}