<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(name="categories")
 * @Vich\Uploadable()
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;

    /**
     * @var File
     * @Vich\UploadableField(mapping="category", fileNameProperty="imageFileName" )
     */
    private  $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private  $imageFileName;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true))
     */
    private $updateAt;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attribute", inversedBy="categories")
     */
    private $attributes;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->attributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
     return (string)$this -> name;
    }


    public function getImage(): ?File
    {
        return $this->image;
    }


    public function setImage(?File $image): self
    {
        $this->image = $image;
        if ($image !== null)
        {
            $this->updateAt = new \DateTime();
        }
        return $this;
    }


    public function getImageFileName()
    {
        return $this->imageFileName;
    }


    public function setImageFileName($imageFileName): self
    {
        $this->imageFileName = $imageFileName;
        return $this;

    }


    public function getUpdateAt(): \DateTime
    {
        return $this->updateAt;

    }


    public function setUpdateAt(\DateTime $updateAt): self
    {
        $this->updateAt = $updateAt;
        return $this;
    }

    /**
     * @return Collection|Attribute[]
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes[] = $attribute;
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        if ($this->attributes->contains($attribute)) {
            $this->attributes->removeElement($attribute);
        }

        return $this;
    }


}
