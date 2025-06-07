<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
class PropertySearch
{
    /**
     * @Assert\Type("string")
     * @var string|null
     */
    private $nom = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }
}
