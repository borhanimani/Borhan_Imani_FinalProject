<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    /**
     * @var Collection<int, SystemInformation>
     */
    #[ORM\ManyToMany(targetEntity: SystemInformation::class)]
    private Collection $systeminformation;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $moredetails = null;

    #[ORM\Column]
    #[Assert\PositiveOrZero]
    private ?float $price = null;

    public function __construct()
    {
        $this->systeminformation = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, SystemInformation>
     */
    public function getSysteminformation(): Collection
    {
        return $this->systeminformation;
    }

    public function addSysteminformation(SystemInformation $systeminformation): static
    {
        if (!$this->systeminformation->contains($systeminformation)) {
            $this->systeminformation->add($systeminformation);
        }

        return $this;
    }

    public function removeSysteminformation(SystemInformation $systeminformation): static
    {
        $this->systeminformation->removeElement($systeminformation);

        return $this;
    }

    public function getMoredetails(): ?string
    {
        return $this->moredetails;
    }

    public function setMoredetails(?string $moredetails): static
    {
        $this->moredetails = $moredetails;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

}
