<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderItemRepository")
 */
class OrderItem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="orderItem")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumberOfProducts;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="orderItem")
     */
    private $price;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order", inversedBy="orderItem", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderSum;

    public function __construct()
    {
        $this->name = new ArrayCollection();
        $this->price = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|Product[]
     */
    public function getName(): Collection
    {
        return $this->name;
    }

    public function addName(Product $name): self
    {
        if (!$this->name->contains($name)) {
            $this->name[] = $name;
            $name->setOrderItem($this);
        }

        return $this;
    }

    public function removeName(Product $name): self
    {
        if ($this->name->contains($name)) {
            $this->name->removeElement($name);
            // set the owning side to null (unless already changed)
            if ($name->getOrderItem() === $this) {
                $name->setOrderItem(null);
            }
        }

        return $this;
    }

    public function getNumberOfProducts(): ?int
    {
        return $this->NumberOfProducts;
    }

    public function setNumberOfProducts(int $NumberOfProducts): self
    {
        $this->NumberOfProducts = $NumberOfProducts;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getPrice(): Collection
    {
        return $this->price;
    }

    public function addPrice(Product $price): self
    {
        if (!$this->price->contains($price)) {
            $this->price[] = $price;
            $price->setOrderItem($this);
        }

        return $this;
    }

    public function removePrice(Product $price): self
    {
        if ($this->price->contains($price)) {
            $this->price->removeElement($price);
            // set the owning side to null (unless already changed)
            if ($price->getOrderItem() === $this) {
                $price->setOrderItem(null);
            }
        }

        return $this;
    }

    public function getOrderSum(): ?Order
    {
        return $this->OrderSum;
    }

    public function setOrderSum(Order $OrderSum): self
    {
        $this->OrderSum = $OrderSum;

        return $this;
    }
}
