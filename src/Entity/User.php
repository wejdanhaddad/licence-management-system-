<?php 
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Entity(repositoryClass=App\Repository\UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="l’email que vous avez tapé est déjà utilisé !")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $User;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\Email(message="Please enter a valid email address")
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *     min=8,
     *     minMessage="Votre mot de passe doit comporter au minimum {{ limit }} caractères"
     * )
     * @Assert\EqualTo(
     *     propertyPath="confirm_password",
     *     message="Vous n’avez pas saisi le même mot de passe"
     * )
     */
    private $password;

    /**
     * @Assert\EqualTo(
     *     propertyPath="password",
     *     message="Vous n’avez pas saisi le même mot de passe !"
     * )
     */
    private $confirm_password;

    // Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?string
    {
        return $this->User;
    }

    public function setUser(string $User): self
    {
        $this->User = $User;
        return $this;
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

    // UserInterface methods

    public function getRoles(): array
    {
        // By default, return ROLE_USER, you can add more roles based on your business logic
        return ['ROLE_USER'];
    }

    public function eraseCredentials()
    {
        // If you have sensitive data (like plain text passwords), erase it here
    }

    public function getSalt()
    {
        // bcrypt and argon2i do not need a salt, so you can return null
        return null;
    }
}
