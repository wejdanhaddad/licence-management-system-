<?php

namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProduitRepository")
 */
class Produit
{
    /** 
     * @ORM\Id 
     * @ORM\GeneratedValue 
     * @ORM\Column(type="integer") 
     */
    private $id;

    /** @ORM\Column(type="string", length=255) */
    private $name;

    /** @ORM\Column(type="string", length=255, nullable=true) */
    private $image;

    /** @ORM\Column(type="text", nullable=true) */
    private $description;

    /** @ORM\Column(type="string", length=50) */
    private $versionActuelle;

    /** @ORM\Column(type="string", length=20) */
    private $typeLicence;

    /** @ORM\Column(type="datetime") */
    private $dateCreation;

    /** @ORM\Column(type="datetime", nullable=true) */
    private $dateDerniereMiseAJour;

    /** @ORM\Column(type="boolean") */
    private $statut;

    /** @ORM\Column(type="decimal", precision=10, scale=2, nullable=true) */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=License::class, mappedBy="product", orphanRemoval=true, cascade={"persist"})
     */
    private $licenses;

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): self { $this->name = $name; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(?string $image): self { $this->image = $image; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }

    public function getVersionActuelle(): ?string { return $this->versionActuelle; }
    public function setVersionActuelle(string $versionActuelle): self { $this->versionActuelle = $versionActuelle; return $this; }

    public function getTypeLicence(): ?string { return $this->typeLicence; }
    public function setTypeLicence(string $typeLicence): self { $this->typeLicence = $typeLicence; return $this; }

    public function getDateCreation(): ?\DateTimeInterface { return $this->dateCreation; }
    public function setDateCreation(\DateTimeInterface $dateCreation): self { $this->dateCreation = $dateCreation; return $this; }

    public function getDateDerniereMiseAJour(): ?\DateTimeInterface { return $this->dateDerniereMiseAJour; }
    public function setDateDerniereMiseAJour(?\DateTimeInterface $dateDerniereMiseAJour): self { $this->dateDerniereMiseAJour = $dateDerniereMiseAJour; return $this; }

    public function getStatut(): ?bool { return $this->statut; }
    public function setStatut(bool $statut): self { $this->statut = $statut; return $this; }

    public function getPrix(): ?float { return $this->prix; }
    public function setPrix(?float $prix): self { $this->prix = $prix; return $this; }

    public function getCategory(): ?Category { return $this->category; }
    public function setCategory(?Category $category): self { $this->category = $category; return $this; }

    public function getLicenses(): Collection { return $this->licenses; }

    public function addLicense(License $license): self
    {
        if (!$this->licenses->contains($license)) {
            $this->licenses[] = $license;
            $license->setProduct($this);
        }

        return $this;
    }

    public function removeLicense(License $license): self
    {
        if ($this->licenses->removeElement($license)) {
            if ($license->getProduct() === $this) {
                $license->setProduct(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
