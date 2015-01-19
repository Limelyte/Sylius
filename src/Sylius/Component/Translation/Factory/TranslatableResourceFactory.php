<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Translation\Factory;

use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Exception\UnexpectedTypeException;
use Sylius\Component\Resource\Factory\ResourceFactory;
use Sylius\Component\Translation\Model\TranslatableInterface;

/**
 * Translatable resource factory class.
 *
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
class TranslatableResourceFactory extends ResourceFactory
{
    /**
     * @var LocaleContextInterface
     */
    private $localeContext;

    /**
     * @param string $class
     * @param LocaleContextInterface $localeContext
     */
    public function __construct($class, LocaleContextInterface $localeContext)
    {
        parent::__construct($class);

        $this->localeContext = $localeContext;
    }

    /**
     * {@inheritdoc}
     */
    public function createNew()
    {
        $resource = parent::createNew();

        if (!$resource instanceof TranslatableInterface) {
            throw new UnexpectedTypeException($resource, 'Sylius\Component\\TranslatableInterface');
        }

        $resource->setCurrentLocale($this->localeContext->getLocale());

        return $resource;
    }
}
