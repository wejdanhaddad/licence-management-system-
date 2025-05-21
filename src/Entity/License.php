<?php

namespace App\Entity;

use App\Repository\LicenseRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Client;


/**
 * This class represents a software license entity, including details such as license key, expiration date, and associated client.
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
    private $DateExpiration;

    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="licenses", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $active;

    public function getLicenseKey(): ?string
    {
        return $this->licenseKey;
    }
    public function getId(): ?string
    {
        return $this->id;
    }

    public function setLicenseKey(string $licenseKey): self
    {
        if (strlen($licenseKey) < 10 || strlen($licenseKey) > 255) {
            throw new \InvalidArgumentException('The license key must be between 10 and 255 characters.');
        }

        

        $this->licenseKey = $licenseKey;
        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->DateExpiration;
    }

    public function setDateExpiration(\DateTimeInterface $DateExpiration): self
    {
        if ($DateExpiration <= new \DateTime()) {
            throw new \InvalidArgumentException('The expiration date must be in the future.');
        }
        $this->DateExpiration = $DateExpiration;
        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;
        return $this;
    }
    public function setId(?Client $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;
        return $this;
    }
/**
 * @ORM\Column(type="datetime")
 */
private $dateCreation;

public function getDateCreation(): ?\DateTimeInterface
{
    return $this->dateCreation;
}

public function setDateCreation(\DateTimeInterface $dateCreation): self
{
    $this->dateCreation = $dateCreation;
    return $this;
}
public function __toString(): string
{
    return $this->licenseKey . ' (exp. ' . $this->DateExpiration->format('d/m/Y') . ')';
}

}