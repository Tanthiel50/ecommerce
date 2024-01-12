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

    #[ORM\ManyToOne(targetEntity: Products::class, inversedBy: 'orderDetails')]
    #[ORM\JoinColumn(name: "product_id", referencedColumnName: "id")]
    private ?Products $product = null;

    #[ORM\Column(nullable: true)]
    private ?float $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: '0', nullable: true)]
    private ?string $price = null;

    public function __construct()
    {
        
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): self
    {
        $this->product = $product;

        return $this;
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
