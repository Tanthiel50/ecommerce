<?php

namespace App\Entity;

use App\Repository\StarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StarsRepository::class)]
class Stars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rating = null;

    #[ORM\OneToMany(mappedBy: 'stars', targetEntity: reviews::class)]
    private Collection $id_review;

    public function __construct()
    {
        $this->id_review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?string
    {
        return $this->rating;
    }

    public function setRating(?string $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @return Collection<int, reviews>
     */
    public function getIdReview(): Collection
    {
        return $this->id_review;
    }

    public function addIdReview(reviews $idReview): static
    {
        if (!$this->id_review->contains($idReview)) {
            $this->id_review->add($idReview);
            $idReview->setStars($this);
        }

        return $this;
    }

    public function removeIdReview(reviews $idReview): static
    {
        if ($this->id_review->removeElement($idReview)) {
            // set the owning side to null (unless already changed)
            if ($idReview->getStars() === $this) {
                $idReview->setStars(null);
            }
        }

        return $this;
    }
}
