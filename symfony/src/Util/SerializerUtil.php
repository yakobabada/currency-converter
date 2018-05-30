<?php

namespace App\Util;

use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class SerializerUtil
{
    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @param array $data
     * @param string $format
     *
     * @return mixed
     */
    public function serialize($data, $format = 'xml')
    {
        $context = new SerializationContext();
        $context->setSerializeNull(true);

        return $this->serializer
            ->serialize($data, $format, $context);
    }

    /**
     * @param string $data
     * @param mixed $target
     *
     * @return mixed
     */
    public function deserialize($data, $target)
    {
        $className = get_class($target);

        $context = new DeserializationContext();
        $context->attributes->set('target', $target);

        return $this->serializer
            ->deserialize($data, $className, 'xml', $context);
    }
}