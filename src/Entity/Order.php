<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name = "orders")
 * */
class Order
{
    const STATUS_NEW = 1;
    const STATUS_ORDERED = 2;
    const STATUS_SENT=3;
    const STATUS_RECEIVED = 4;
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="boolean", options={"default":false})
     */

    private $isPaid;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="orders")
     */
    private $user;

    /**
     * @ORM\Column(type="integer", options={"default":0})
     */
    private $amount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderItem", mappedBy="order", orphanRemoval=true,
     *     indexBy="product_id", cascade={"persist"})
     */
    private $items;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->status = self::STATUS_NEW;
        $this->isPaid=false;
        $this->amount = 0 ;
        $this->items = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIsPaid(): ?int
    {
        return $this->isPaid;
    }

    public function setIsPaid(int $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;

    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return Collection|OrderItem[]
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(OrderItem $orderItem): self
    {
        if (!$this->items->contains($orderItem)) {
            $this->items[] = $orderItem;
            $orderItem->setOrder($this);
        }

        return $this;
    }

    public function removeItem(OrderItem $orderItem): self
    {
        if ($this->items->contains($orderItem)) {
            $this->items->removeElement($orderItem);
            // set the owning side to null (unless already changed)
            if ($orderItem->getOrder() === $this) {
                $orderItem->setOrder(null);
            }
            $this->updateAmount();
            return $this;
        }

        return $this;
    }
    public function updateAmount()
    {
        $amount = 0;
        foreach ($this->getItems()as $item){
        $amount += $item->getCost();
    }
        $this->setAmount($amount);
    }
}
