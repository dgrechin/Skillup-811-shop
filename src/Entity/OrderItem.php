<?php

namespace App\Entity;

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
     * @ORM\OneToOne(targetEntity="App\Entity\Product", inversedBy="name" cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $OrderProduct;

    /**
     * @ORM\Column(type="integer")
     */
    private $NumberOfProducts;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Product", inversedBy="price" cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Price;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order", inversedBy="orderSum", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $SumOfOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderProduct(): ?Product
    {
        return $this->OrderProduct;
    }

    public function setOrderProduct(Product $name): self
    {
        $this->OrderProduct = $name;

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

    public function getPrice(): ?Product
    {
        return $this->Price;
    }

    public function setPrice(Product $price): self
    {
        $this->Price = $price;

        return $this;
    }

    public function getSumOfOrder(): ?Order
    {
        return $this->SumOfOrder;
    }

    public function setSumOfOrder(Order $orderSum): self
    {
        $this->SumOfOrder = $orderSum;

        return $this;
    }
}
