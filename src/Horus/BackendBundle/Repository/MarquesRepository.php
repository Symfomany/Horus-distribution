<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class MarquesRepository
 * @package Horus\BackendBundle\Repository
 */
class MarquesRepository extends EntityRepository
{


    /**
     * Get Active Page
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getActivePageQueryBuilder()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Marques', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }
}