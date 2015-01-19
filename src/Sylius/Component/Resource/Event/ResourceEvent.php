<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Component\Resource\Event;

use Sylius\Component\Resource\Model\ResourceInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Resource event.
 *
 * @param Paweł Jędrzejewski <pawel@sylius.org>
 */
class ResourceEvent extends Event
{
    const TYPE_ERROR   = 'error';
    const TYPE_INFO    = 'info';
    const TYPE_WARNING = 'warning';

    /**
     * @var ResourceInterface
     */
    protected $resource;

    /**
     * @param ResourceInterface $resource
     */
    protected $messageParameters = array();

    /**
     * Response code.
     *
     * @var integer
     */
    protected $responseCode = 500;

    /**
     * @param $message
     * @param string $type
     * @param array $parameters
     * @param int $responseCode
     */
    public function stop($message, $type = self::TYPE_ERROR, $parameters = array(), $responseCode = 500)
    {
        $this->messageType = $type;
        $this->message = $message;
        $this->messageParameters = $parameters;
        $this->responseCode = $responseCode;

        $this->stopPropagation();
    }

    /**
     * @param ResourceInterface $resource
     */
    public function __construct(ResourceInterface $resource)
    {
        $this->resource = $resource;
    }

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get responseCode property
     *
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * Sets responseCode property
     *
     * @param int $responseCode
     *
     * @return $this
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;

        return $this;
    }
}
