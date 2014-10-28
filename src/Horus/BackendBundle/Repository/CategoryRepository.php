<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Horus\BackendBundle\Entity\Category;

/**
 * Class CategoryRepository
 * @package Horus\BackendBundle\Repository
 */
class CategoryRepository extends EntityRepository
{
    /**
     * Get articles by Category
     * @param Category $category
     * @return mixed
     */
    public function getArticlesByCategory(Category $category = null)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT a FROM HorusBackendBundle:Article a WHERE a.category = :category")
            ->setParameter('category', $category)
            ->setMaxResults(15);


        return $query->getResult();
    }

    /**
     * Get Active Category
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveCategoryQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Category', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }

    /**
     * If on category
     * @return mixed
     */
    public function isCategory()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a) nombre FROM HorusBackendBundle:Category a");
        return $query->getOneOrNullResult();
    }


    /**
     * Get articles by Category
     * @param Category $category
     * @return mixed
     */
    public function getCategoryIsProductNull()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Category a  WHERE a.produits IS EMPTY");
        return $query->getSingleScalarResult();
    }

    /**
     * Get articles by Category
     * @param Category $category
     * @return mixed
     */
    public function getCategoryIsDesactive()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a.id) FROM HorusBackendBundle:Category a WHERE a.visible = :visible")
            ->setParameter('visible', false);
        return $query->getSingleScalarResult();
    }




}