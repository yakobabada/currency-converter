<?php

namespace App\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\XmlList;
use JMS\Serializer\Annotation\XmlRoot;

/**
 *
 * @Serializer\ExclusionPolicy("all")
 * @XmlRoot("orders")
 */
class Orders
{
    /**
     * @Serializer\Expose
     * @Serializer\Type("ArrayCollection<App\Model\Order>")
     * @XmlList(entry = "order", inline=true)
     */
    private $orderList;

    public function __construct()
    {
        $this->orderList = new ArrayCollection();
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderList(): Collection
    {
        return $this->orderList;
    }

    public function addOrderList(Order $orderList): self
    {
        if (!$this->orderList->contains($orderList)) {
            $this->orderList[] = $orderList;
            $orderList->setOrders($this);
        }

        return $this;
    }

    public function removeOrderList(Order $orderList): self
    {
        if ($this->orderList->contains($orderList)) {
            $this->orderList->removeElement($orderList);
            // set the owning side to null (unless already changed)
            if ($orderList->getOrders() === $this) {
                $orderList->setOrders(null);
            }
        }

        return $this;
    }
}
