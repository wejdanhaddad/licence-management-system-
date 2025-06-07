<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 * @ORM\Table(name="app_user")
 * @UniqueEntity(fields={"username"}, message="L'email que vous avez tapé est déjà utilisé !")
 */
class User implements UserInterface
{
    public function __construct()
{
    $this->licenseRequests = new \Doctrine\Common\Collections\ArrayCollection();
}

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="Veuillez entrer une adresse email valide")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=8,
     *     minMessage="Votre mot de passe doit comporter au minimum {{ limit }} caractères"
     * )
     */
    private $password;
    /**
     * @Assert\EqualTo(
     *     propertyPath="password",
     *     message="Vous n'avez pas saisi le même mot de passe !"
     * )
     */
    private $confirm_password;
    /**
   * @ORM\Column(type="boolean", nullable=true)
   */
    private $isAdministrative;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }
    /**
 * @ORM\OneToMany(targetEntity=License::class, mappedBy="client")
 */
private $licenses;

public function getLicenses(): Collection {
    return $this->licenses;
}

/**
 * @ORM\OneToMany(targetEntity=LicenseRequest::class, mappedBy="client")
 */
private $licenseRequests;

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }
    public function getConfirmPassword(): ?string
    {
        return $this->confirm_password;
    }
    public function setConfirmPassword(string $confirm_password): self
    {
        $this->confirm_password = $confirm_password;
        return $this;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_ADMIN';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }
    public function addRole(string $role): self
    {
        if (!in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    public function removeRole(string $role): self
    {
        if (($key = array_search($role, $this->roles)) !== false) {
            unset($this->roles[$key]);
        }
        return $this;
    }
    public function __toString(): string
    {
        return $this->username ?? 'Unknown Client';
    }
    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        $this->confirm_password = null;
    }

    public function getIsAdministrative(): ?bool
    {
        return $this->isAdministrative;
    }

    public function setIsAdministrative(bool $isAdministrative): self
    {
        $this->isAdministrative = $isAdministrative;

        return $this;
    }
    
public function getLicenseRequests(): Collection
{
    return $this->licenseRequests;
}
}
