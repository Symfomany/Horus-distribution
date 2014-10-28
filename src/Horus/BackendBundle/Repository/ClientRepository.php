<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class ClientRepository
 * @package Horus\BackendBundle\Repository
 */
class ClientRepository extends EntityRepository
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
            ->from('Horus\BackendBundle\Entity\Client', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }
}