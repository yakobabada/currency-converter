<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlElement;

/**
 * @Serializer\ExclusionPolicy("all")
 */
class Order
{
    /**
     * @Serializer\Type("integer")
     * @Serializer\Expose
     * @XmlElement(cdata=false)
     */
    private $id;

    /**
     * @Serializer\Type("string")
     * @Serializer\Expose
     * @XmlElement(cdata=false)
     */
    private $currency;

    /**
     * @Serializer\Type("datetime")
     *
     * @Serializer\Expose
     * @Serializer\Type("DateTime<'d/m/Y'>")
     * @XmlElement(cdata=false)
     */
    private $date;

    /**
     * @Serializer\Type("ArrayCollection<App\Model\Product>")
     * @Serializer\Expose
     * @XmlList(entry = "product")
     */
    private $products;

    /**
     * @Serializer\Type("float")
     * @Serializer\Expose
     * @XmlElement(cdata=false)
     */
    private $total;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }
}
