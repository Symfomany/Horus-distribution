<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ImageRepository
 * @package Horus\BackendBundle\Repository
 */
class ImageMarquesRepository extends EntityRepository
{


    /**
     * If on category
     * @return mixed
     */
    public function isFirstImage($id = null)
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(a) nombre FROM HorusBackendBundle:ImageMarques a WHERE a.marque = :marque")->setParameter('marque', $id);
        return $query->getOneOrNullResult();
    }

}