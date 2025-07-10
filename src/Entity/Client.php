<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=255) */
    private $companyName;

    /** @ORM\Column(type="string", length=255) */
    private $address;

    /** @ORM\Column(type="string", length=20) */
    private $phone;

    /**
 * @ORM\OneToOne(targetEntity=User::class)
 * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=false)
 */
private $user;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\License", mappedBy="client")
     */
    private $licenses;

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }
    public function getCompanyName(): ?string { return $this->companyName; }
    public function setCompanyName(string $name): self { $this->companyName = $name; return $this; }
    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $addr): self { $this->address = $addr; return $this; }
    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(string $p): self { $this->phone = $p; return $this; }
    public function getUser(): ?User { return $this->user; }
    public function setUser(User $u): self { $this->user = $u; return $this; }

    public function getLicenses(): Collection { return $this->licenses; }

    public function __toString() { return $this->companyName ?? 'Client'; }
}
