<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $authorFullname = null;

    #[ORM\Column(length: 255)]
    private ?string $authorEmail = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'authorFullname')]
    private Collection $products;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $authorBio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authorImage = null;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorFullname(): ?string
    {
        return $this->authorFullname;
    }

    public function setAuthorFullname(string $authorFullname): self
    {
        $this->authorFullname = $authorFullname;

        return $this;
    }

    public function getAuthorEmail(): ?string
    {
        return $this->authorEmail;
    }

    public function setAuthorEmail(string $authorEmail): self
    {
        $this->authorEmail = $authorEmail;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->addAuthorFullname($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removeAuthorFullname($this);
        }

        return $this;
    }

    public function getAuthorBio(): ?string
    {
        return $this->authorBio;
    }

    public function setAuthorBio(?string $authorBio): self
    {
        $this->authorBio = $authorBio;

        return $this;
    }

    public function getAuthorImage(): ?string
    {
        return $this->authorImage;
    }

    public function setAuthorImage(?string $authorImage): self
    {
        $this->authorImage = $authorImage;

        return $this;
    }
}
