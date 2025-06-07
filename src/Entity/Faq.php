<?php
namespace App\Entity;

use App\Repository\FaqRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FaqRepository::class)
 */
class Faq
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    /**
 * @ORM\Id
 * @ORM\GeneratedValue
 * @ORM\Column(type="integer")
 */
private $id;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string|null
     */
    private $question;
    /**
     * @ORM\Column(type="text")
     * @var string|null
     */
    private $answer;
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getQuestion(): ?string
    {
        return $this->question;
    }
    public function setQuestion(string $question): self
    {
        if (empty($question)) {
            throw new \InvalidArgumentException('Question cannot be empty.');
        }
        $this->question = $question;
        return $this;
    }
    public function getAnswer(): ?string
    {
        return $this->answer;
    }
    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;
        return $this;
    }
}
