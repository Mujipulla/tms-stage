<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $illustration = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isBest = null;

    #[ORM\Column(nullable: true)]
    private ?bool $isStock = null;

    #[ORM\ManyToMany(targetEntity: SupportPDF::class, inversedBy: 'products')]
    private Collection $pdfname;

    #[ORM\Column(nullable: true)]
    private ?bool $isChoix = null;

    #[ORM\ManyToMany(targetEntity: Author::class, inversedBy: 'products')]
    private Collection $authorFullname;


    public function __construct()
    {
        $this->pdfname = new ArrayCollection();
        $this->authorFullname = new ArrayCollection();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(?string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function isIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest(?bool $isBest): self
    {
        $this->isBest = $isBest;

        return $this;
    }

    public function isIsStock(): ?bool
    {
        return $this->isStock;
    }

    public function setIsStock(?bool $isStock): self
    {
        $this->isStock = $isStock;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getName();
    }

    /**
     * @return Collection<int, SupportPDF>
     */
    public function getPdfname(): Collection
    {
        return $this->pdfname;
    }

    public function addPdfname(SupportPDF $pdfname): self
    {
        if (!$this->pdfname->contains($pdfname)) {
            $this->pdfname->add($pdfname);
        }

        return $this;
    }

    public function removePdfname(SupportPDF $pdfname): self
    {
        $this->pdfname->removeElement($pdfname);

        return $this;
    }

    public function isIsChoix(): ?bool
    {
        return $this->isChoix;
    }

    public function setIsChoix(?bool $isChoix): self
    {
        $this->isChoix = $isChoix;

        return $this;
    }

    /**
     * @return Collection<int, Author>
     */
    public function getAuthorFullname(): Collection
    {
        return $this->authorFullname;
    }

    public function addAuthorFullname(Author $authorFullname): self
    {
        if (!$this->authorFullname->contains($authorFullname)) {
            $this->authorFullname->add($authorFullname);
        }

        return $this;
    }

    public function removeAuthorFullname(Author $authorFullname): self
    {
        $this->authorFullname->removeElement($authorFullname);

        return $this;
    }

    
}