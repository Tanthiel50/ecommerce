<?php

namespace App\Entity;

use App\Repository\OrderDetailsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderDetailsRepository::class)]
class OrderDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'orderDetails')]
    private ?Orders $id_order = null;

    #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'orderDetails')]
    private Collection $id_product;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0', nullable: true)]
    private ?string $price = null;

    public function __construct()
    {
        $this->id_product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdOrder(): ?Orders
    {
        return $this->id_order;
    }

    public function setIdOrder(?Orders $id_order): static
    {
        $this->id_order = $id_order;

        return $this;
    }

    /**
     * @return Collection<int, Products>
     */
    public function getIdProduct(): Collection
    {
        return $this->id_product;
    }

    public function addIdProduct(Products $idProduct): static
    {
        if (!$this->id_product->contains($idProduct)) {
            $this->id_product->add($idProduct);
        }

        return $this;
    }

    public function removeIdProduct(Products $idProduct): static
    {
        $this->id_product->removeElement($idProduct);

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(?float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
