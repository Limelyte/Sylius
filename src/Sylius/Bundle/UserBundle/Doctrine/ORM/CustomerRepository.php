<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\UserBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepository;
use Sylius\Component\Core\Model\UserInterface;

/**
 * @author Michał Marcinkowski <michal.marcinkowski@lakion.com>
 */
class CustomerRepository extends ResourceRepository
{
    /**
     * Get the customer's data for the details page.
     *
     * @param integer $id
     *
     * @return null|UserInterface
     */
    public function findForDetailsPage($id)
    {
        $this->objectManager->getFilters()->disable('softdeleteable');

        $queryBuilder = $this->objectRepository->createQueryBuilder('o');
        $queryBuilder
            ->andWhere($queryBuilder->expr()->eq('o.id', ':id'))
            ->setParameter('id', $id)
        ;

        $result = $queryBuilder
            ->getQuery()
            ->getOneOrNullResult()
        ;
        $this->objectManager->getFilters()->enable('softdeleteable');

        return $result;
    }

    /**
     * @param array $criteria
     * @param array $sorting
     * @param bool  $deleted
     *
     * @return Pagerfanta
     */
    public function createFilterPaginator($criteria = array(), $sorting = array(), $deleted = false)
    {
        $queryBuilder = $this->objectRepository->createQueryBuilder('o')
            ->leftJoin($this->getPropertyName('user'), 'user');

        if ($deleted) {
            $this->objectRepository->getFilters()->disable('softdeleteable');
        }

        if (isset($criteria['query'])) {
            $queryBuilder
                ->where($queryBuilder->expr()->like($this->getPropertyName('emailCanonical'), ':query'))
                ->orWhere($queryBuilder->expr()->like($this->getPropertyName('firstName'), ':query'))
                ->orWhere($queryBuilder->expr()->like($this->getPropertyName('lastName'), ':query'))
                ->orWhere($queryBuilder->expr()->like('user.username', ':query'))
                ->setParameter('query', '%'.$criteria['query'].'%')
            ;
        }
        if (isset($criteria['enabled'])) {
            $queryBuilder
                ->andWhere($queryBuilder->expr()->eq('user.enabled', ':enabled'))
                ->setParameter('enabled', $criteria['enabled'])
            ;
        }

        if (empty($sorting)) {
            if (!is_array($sorting)) {
                $sorting = array();
            }
            $sorting['updatedAt'] = 'desc';
        }

        $this->applySorting($queryBuilder, $sorting);

        return $this->getPaginator($queryBuilder);
    }
}
