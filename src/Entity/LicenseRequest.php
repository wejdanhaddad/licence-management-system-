<?php

namespace App\Entity;

use App\Repository\LicenseRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=LicenseRequestRepository::class)
 */
class LicenseRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
/**
 * @ORM\Column(type="string", length=255, nullable=true)
 */
private $machineId;

public function getMachineId(): ?string
{
    return $this->machineId;
}

public function setMachineId(?string $machineId): self
{
    $this->machineId = $machineId;
    return $this;
}

   /**
 * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="licenseRequests")
 * @ORM\JoinColumn(nullable=false)
 */

private $client;


    /**
     * @ORM\ManyToOne(targetEntity=Produit::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(choices={"pending", "approved", "rejected"}, message="Statut invalide.")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Choice(choices={"activation", "renouvellement", "désactivation"}, message="Type de demande invalide.")
     */
    private $requestType;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $message;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $licenseKey;

    public function __construct()
    {
        $this->status = 'pending';
        $this->createdAt = new \DateTime();
    }

    // Getters et Setters

    public function getId(): ?int { return $this->id; }

    public function getClient(): ?User
{
    return $this->client;
}

    public function setClient(?User $user): self
{
    $this->client = $user;
    return $this;
}

    public function getProduct(): ?Produit { return $this->product; }

    public function setProduct(?Produit $product): self {
        $this->product = $product;
        return $this;
    }

    public function getStatus(): ?string { return $this->status; }

    public function setStatus(string $status): self {
        $this->status = $status;
        return $this;
    }

    public function getRequestType(): ?string { return $this->requestType; }

    public function setRequestType(string $requestType): self {
        $this->requestType = $requestType;
        return $this;
    }

    public function getMessage(): ?string { return $this->message; }

    public function setMessage(?string $message): self {
        $this->message = $message;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface { return $this->createdAt; }

    public function setCreatedAt(\DateTimeInterface $createdAt): self {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface { return $this->startDate; }

    public function setStartDate(?\DateTimeInterface $startDate): self {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface { return $this->endDate; }

    public function setEndDate(?\DateTimeInterface $endDate): self {
        $this->endDate = $endDate;
        return $this;
    }

    public function getLicenseKey(): ?string { return $this->licenseKey; }

    public function setLicenseKey(?string $licenseKey): self {
        $this->licenseKey = $licenseKey;
        return $this;
    }

    public function __toString(): string
    {
        return $this->client->getUsername() . ' - ' . $this->product->getName() . ' (' . $this->requestType . ')';
    }
}
