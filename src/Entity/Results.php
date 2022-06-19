<?php

namespace App\Entity;

use App\Repository\ResultsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ResultsRepository::class)]
class Results
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Formulas::class, inversedBy: 'results', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $formula;

    #[ORM\Column(type: 'float', nullable: true)]
    private $value;

    #[ORM\ManyToOne(targetEntity: Tests::class, inversedBy: 'results', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $tests;
    // #[ORM\OneToOne(targetEntity: Tests::class, cascade: ['persist', 'remove'])]
    // private $tests;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?float
    {
        return $this->value;
    }

    public function setValue(?float $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getTests(): ?Tests
    {
        return $this->tests;
    }

    public function setTests(?Tests $tests): self
    {
        $this->tests = $tests;

        return $this;
    }
}
