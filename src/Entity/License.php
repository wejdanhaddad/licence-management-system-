<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LicenseRepository")
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
    private $expirationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="licenses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    public function getId(): ?int { return $this->id; }
    public function getLicenseKey(): ?string { return $this->licenseKey; }
    public function setLicenseKey(string $licenseKey): self { $this->licenseKey = $licenseKey; return $this; }
    public function getExpirationDate(): ?\DateTimeInterface { return $this->expirationDate; }
    public function setExpirationDate(\DateTimeInterface $expirationDate): self { $this->expirationDate = $expirationDate; return $this; }
    public function getClient(): ?Client { return $this->client; }
    public function setClient(?Client $client): self { $this->client = $client; return $this; }
}
