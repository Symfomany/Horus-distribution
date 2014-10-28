<?php
namespace Horus\BackendBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class FournisseursRepository
 * @package Horus\BackendBundle\Repository
 */
class FournisseursRepository extends EntityRepository
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
            ->from('Horus\BackendBundle\Entity\Fournisseurs', 'm')
            ->orderBy('m.id', 'DESC');
        return $queryBuilder;
    }

}