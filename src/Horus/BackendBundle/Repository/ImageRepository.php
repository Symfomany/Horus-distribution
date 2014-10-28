<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ImageRepository
 * @package Horus\BackendBundle\Repository
 */
class ImageRepository extends EntityRepository
{

    /**
     * Get Active Image
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActiveImageQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Image', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }


    /**
     * If on category
     * @return mixed
     */
    public function isFirstImage($id = null)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a) nombre FROM HorusBackendBundle:Image a WHERE a.produit = :produit")->setParameter('produit', $id);
        return $query->getOneOrNullResult();
    }

}