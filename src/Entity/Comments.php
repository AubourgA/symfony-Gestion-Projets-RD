<?php

namespace App\Entity;

use App\Repository\CommentsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentsRepository::class)]
class Comments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaires;

    #[ORM\OneToOne(targetEntity: Formulas::class, cascade: ['persist', 'remove'])]
    private $formula;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): self
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getFormula(): ?Formulas
    {
        return $this->formula;
    }

    public function setFormula(?Formulas $formula): self
    {
        $this->formula = $formula;

        return $this;
    }
}
