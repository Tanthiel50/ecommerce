<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: products::class)]
    private Collection $product_id;

    public function __construct()
    {
        $this->product_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Collection<int, products>
     */
    public function getProductId(): Collection
    {
        return $this->product_id;
    }

    public function addProductId(products $productId): static
    {
        if (!$this->product_id->contains($productId)) {
            $this->product_id->add($productId);
            $productId->setCategories($this);
        }

        return $this;
    }

    public function removeProductId(products $productId): static
    {
        if ($this->product_id->removeElement($productId)) {
            // set the owning side to null (unless already changed)
            if ($productId->getCategories() === $this) {
                $productId->setCategories(null);
            }
        }

        return $this;
    }
}
