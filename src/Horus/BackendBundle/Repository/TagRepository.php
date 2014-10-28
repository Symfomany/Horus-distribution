<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class TagRepository
 * @package Horus\BackendBundle\Repository
 */
class TagRepository extends EntityRepository
{
    /**
     * Get Tags
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getTags()
    {
        $queryBuilder = $this->getEntityManager()
            ->createQueryBuilder()
            ->select('m')
            ->from('Horus\BackendBundle\Entity\Tag', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }

}