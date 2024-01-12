<?php

namespace App\Entity;

use App\Entity\Images;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stock = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $color = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $size = null;

    #[ORM\OneToMany(mappedBy: 'id_product', targetEntity: Reviews::class)]
    private Collection $reviews;

    #[ORM\ManyToOne(inversedBy: 'id_product')]
    #[ORM\JoinColumn(name: "sales_id", referencedColumnName: "id", onDelete: "SET NULL")]
    private ?Sales $sales = null;

    #[ORM\ManyToOne(inversedBy: 'product_id')]
    private ?Categories $categories = null;

    #[ORM\OneToMany(mappedBy: 'products', targetEntity: Images::class, cascade: ['persist', 'remove'])]
    private Collection $image;

    #[ORM\ManyToMany(targetEntity: OrderDetails::class, mappedBy: 'id_product')]
    private Collection $orderDetails;

    public function __construct()
    {
        $this->reviews = new ArrayCollection();
        $this->image = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
    }

    public function getEffectivePrice(): float
{
    $price = (float) $this->price;
    $sales = $this->getSales();
    $currentDate = new \DateTime();

    if ($sales && $sales->getDateBegin() && $sales->getDateEnd() &&
        $sales->getDateBegin() <= $currentDate && $sales->getDateEnd() >= $currentDate) {
        $discount = (float) $sales->getDiscount();

        // Applique la remise seulement si elle est valide
        return $price * (1 - $discount / 100);
    }

    return $price;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

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

    public function getStock(): ?string
    {
        return $this->stock;
    }

    public function setStock(?string $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): static
    {
        $this->color = $color;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): static
    {
        $this->size = $size;

        return $this;
    }

    /**
     * @return Collection<int, Reviews>
     */
    public function getReviews(): Collection
    {
        return $this->reviews;
    }

    public function addReview(Reviews $review): static
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews->add($review);
            $review->setIdProduct($this);
        }

        return $this;
    }

    public function removeReview(Reviews $review): static
    {
        if ($this->reviews->removeElement($review)) {
            if ($review->getIdProduct() === $this) {
                $review->setIdProduct(null);
            }
        }

        return $this;
    }

    public function getSales(): ?Sales
    {
        return $this->sales;
    }

    public function setSales(?Sales $sales): static
    {
        $this->sales = $sales;

        return $this;
    }

    public function getCategories(): ?Categories
    {
        return $this->categories;
    }

    public function setCategories(?Categories $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, images>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(images $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setProducts($this);
        }

        return $this;
    }

    public function removeImage(images $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProducts() === $this) {
                $image->setProducts(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): static
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->addIdProduct($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): static
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            $orderDetail->removeIdProduct($this);
        }

        return $this;
    }
}
