<?php

namespace App\Entity;

use App\Repository\SupportPDFRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: SupportPDFRepository::class)]
#[Vich\Uploadable]
class SupportPDF
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[Vich\UploadableField(mapping: "pdf_files", fileNameProperty: "pdfUrl")]
    private $pdfFile;

    #[ORM\Column(type: "string", length: 255)]
    private ?string $pdfname = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $pdfUrl = null;

    #[ORM\ManyToMany(targetEntity: Product::class, mappedBy: 'pdfname')]
    private Collection $products;

    #[ORM\Column(type: "datetime_immutable")]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'pdfname', targetEntity: OrderDetails::class)]
    private Collection $orderDetails;

    public function __toString()
    {
        return $this->pdfUrl;
    }
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPdfname(): ?string
    {
        return $this->pdfname;
    }

    public function setPdfname(?string $pdfname): self
    {
        $this->pdfname = $pdfname;

        return $this;
    }

    public function getPdfFile(): ?File
    {
        return $this->pdfFile;
    }

    public function setPdfFile(?File $pdfFile): self
    {
        $this->pdfFile = $pdfFile;

        if (null !== $pdfFile) {
            $this->updatedAt = new \DateTimeImmutable('now');
        }

        return $this;
    }

    public function getPdfUrl(): ?string
    {
        return $this->pdfUrl;
    }

    public function setPdfUrl(?string $pdfUrl): self
    {
        $this->pdfUrl = $pdfUrl;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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
            $product->addPdfname($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            $product->removePdfname($this);
        }

        return $this;
    }

    public function getFullPdfUrl(): string
    {
        return '/uploads/supports/' . $this->getPdfUrl();
    }

    /**
     * @return Collection<int, OrderDetails>
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOrderDetail(OrderDetails $orderDetail): self
    {
        if (!$this->orderDetails->contains($orderDetail)) {
            $this->orderDetails->add($orderDetail);
            $orderDetail->setPdfname($this);
        }

        return $this;
    }

    public function removeOrderDetail(OrderDetails $orderDetail): self
    {
        if ($this->orderDetails->removeElement($orderDetail)) {
            // set the owning side to null (unless already changed)
            if ($orderDetail->getPdfname() === $this) {
                $orderDetail->setPdfname(null);
            }
        }

        return $this;
    }

}
