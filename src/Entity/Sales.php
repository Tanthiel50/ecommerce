<?php

namespace App\Entity;

use App\Repository\SalesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SalesRepository::class)]
class Sales
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $discount = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_begin = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date_end = null;

    #[ORM\OneToMany(mappedBy: 'sales', targetEntity: products::class)]
    private Collection $id_product;

    public function __construct()
    {
        $this->id_product = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getDiscount(): ?string
    {
        return $this->discount;
    }

    public function setDiscount(?string $discount): static
    {
        $this->discount = $discount;

        return $this;
    }

    public function getDateBegin(): ?\DateTimeInterface
    {
        return $this->date_begin;
    }

    public function setDateBegin(?\DateTimeInterface $date_begin): static
    {
        $this->date_begin = $date_begin;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->date_end;
    }

    public function setDateEnd(?\DateTimeInterface $date_end): static
    {
        $this->date_end = $date_end;

        return $this;
    }

    /**
     * @return Collection<int, products>
     */
    public function getIdProduct(): Collection
    {
        return $this->id_product;
    }

    public function addIdProduct(products $idProduct): static
    {
        if (!$this->id_product->contains($idProduct)) {
            $this->id_product->add($idProduct);
            $idProduct->setSales($this);
        }

        return $this;
    }

    public function removeIdProduct(products $idProduct): static
    {
        if ($this->id_product->removeElement($idProduct)) {
            // set the owning side to null (unless already changed)
            if ($idProduct->getSales() === $this) {
                $idProduct->setSales(null);
            }
        }

        return $this;
    }
}
