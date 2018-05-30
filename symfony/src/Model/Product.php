<?php

namespace App\Model;

use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\XmlAttribute;


/**
 * @Serializer\ExclusionPolicy("all")
 */
class Product
{
    /**
     * @Serializer\Type("integer")
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @XmlAttribute
     */
    private $title;

    /**
     * @Serializer\Type("float")
     * @Serializer\Expose
     * @XmlAttribute
     */
    private $price;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }
}
