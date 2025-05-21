<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\License;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @UniqueEntity(fields={"email"}, message="L'email est déjà utilisé.")
 * @UniqueEntity(fields={"username"}, message="Le nom d'utilisateur est déjà utilisé.")
 */
class Client implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /** 
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email()
     * @Assert\NotBlank()
     */
    private $email;
/**
     * @ORM\OneToMany(targetEntity=License::class, mappedBy="client", orphanRemoval=true)
     */
    private $licenses;
    /** 
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /** 
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /** 
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min=8, minMessage="Le mot de passe doit faire au moins 8 caractères.")
     */
    private $password;

    public function getId(): ?int { return $this->id; }

    public function getEmail(): ?string { return $this->email; }

    public function setEmail(string $email): self {
        $this->email = $email;
        return $this;
    }

    public function getUsername(): ?string { return $this->username; }

    public function setUsername(string $username): self {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string { return $this->password; }

    public function setPassword(string $password): self {
        $this->password = $password;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // Garantit que chaque utilisateur a au moins ROLE_USER
        $roles[] = 'ROLE_CLIENT';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
{
    if (!in_array('ROLE_CLIENT', $roles)) {
        $roles[] = 'ROLE_CLIENT';
    }

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
    
    public function eraseCredentials() {}

    public function getSalt() { return null; }
    private ?string $plainPassword = null;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }
    

    public function __construct()
    {
        $this->licenses = new ArrayCollection();
    }

    public function getLicenses(): Collection
    {
        return $this->licenses;
    }

    public function addLicense(License $license): self
    {
        if (!$this->licenses->contains($license)) {
            $this->licenses[] = $license;
            $license->setClient($this);
        }

        return $this;
    }

    public function removeLicense(License $license): self
    {
        if ($this->licenses->removeElement($license)) {
            if ($license->getClient() === $this) {
                $license->setClient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->username;
    }

}
