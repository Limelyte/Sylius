<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Resource\Metadata;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class ResourceRegistry implements ResourceRegistryInterface
{
    /**
     * @var array
     */
    private $resources = array();

    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->resources;
    }

    /**
     * {@inheritdoc}
     */
    public function get($alias)
    {
        if (!array_key_exists($alias, $this->resources)) {
            throw new \InvalidArgumentException(sprintf('Resource "%s" does not exist.', $alias));
        }

        return $this->resources[$alias];
    }

    /**
     * {@inheritdoc}
     */
    public function add($alias, array $configuration)
    {
        $this->resources[$alias] = ResourceMetadata::fromConfigurationArray($alias, $configuration);
    }
}
