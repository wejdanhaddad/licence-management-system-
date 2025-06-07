<?php

namespace App\Entity;

use App\Repository\LicenseRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTimeInterface;
use App\Entity\User; 
use App\Entity\Client;


/**
 * @ORM\Entity(repositoryClass=LicenseRepository::class)
 */
class License
{
    /** 
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, unique=true) 
     */
    private $licenseKey;

    /** 
     * @ORM\Column(type="datetime") 
     */
    private $dateExpiration;

    /** 
     * @ORM\Column(type="boolean", options={"default": false}) 
     */

    private $active;

    /** 
     * @ORM\Column(type="datetime") 
     */
    private $dateCreation;

   
/**
 * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="licenses")
 * @ORM\JoinColumn(nullable=false)
 */
private $client;

/**
 * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="licenses")
 * @ORM\JoinColumn(name="produit_id", referencedColumnName="id", nullable=false)
 */
private $product;

    public function getId(): ?int { return $this->id; }

    public function getLicenseKey(): ?string { return $this->licenseKey; }
    public function setLicenseKey(string $licenseKey): self { $this->licenseKey = $licenseKey; return $this; }

    public function getDateExpiration(): ?DateTimeInterface { return $this->dateExpiration; }
    public function setDateExpiration(DateTimeInterface $dateExpiration): self { $this->dateExpiration = $dateExpiration; return $this; }

    public function getActive(): ?bool { return $this->active; }
    public function setActive(bool $active): self { $this->active = $active; return $this; }

    public function getDateCreation(): ?DateTimeInterface { return $this->dateCreation; }
    public function setDateCreation(DateTimeInterface $dateCreation): self { $this->dateCreation = $dateCreation; return $this; }

    public function getClient(): ?Client { return $this->client; }
    public function setClient(Client $client): self { $this->client = $client; return $this; }

    public function getProduct(): ?Produit { return $this->product; }
    public function setProduct(?Produit $produit): self { $this->product = $produit; return $this; }

    public function __toString(): string
    {
        return $this->licenseKey . ' (exp. ' . $this->dateExpiration->format('d/m/Y') . ')';
    }
}