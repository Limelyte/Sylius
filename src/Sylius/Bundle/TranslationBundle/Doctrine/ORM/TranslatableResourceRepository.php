<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\TranslationBundle\Doctrine\ORM;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\ResourceRepository;
use Sylius\Component\Translation\Model\TranslatableInterface;
use Sylius\Component\Translation\Provider\LocaleProviderInterface;
use Sylius\Component\Translation\Repository\TranslatableResourceRepositoryInterface;

/**
 * Doctrine ORM driver translatable entity repository.
 *
 * @author Gonzalo Vilaseca <gvilaseca@reiss.co.uk>
 */
class TranslatableResourceRepository extends ResourceRepository implements TranslatableResourceRepositoryInterface
{
    /**
     * @var LocaleProviderInterface
     */
    protected $localeProvider;

    /**
     * @var array
     */
    protected $translatableFields = array();

    /**
     * {@inheritdoc}
     */
    public function setLocaleProvider(LocaleProviderInterface $provider)
    {
        $this->localeProvider = $provider;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTranslatableFields(array $translatableFields)
    {
        $this->translatableFields = $translatableFields;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function getPropertyName($name)
    {
        if (in_array($name, $this->translatableFields)) {
            return 'translation.'.$name;
        }

        return parent::getPropertyName($name);
    }
}
