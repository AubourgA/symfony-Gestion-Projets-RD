<?php

namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Repository\MaterialFormulaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MaterialFormulaRepository::class)]
class MaterialFormula
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Formulas::class, inversedBy: 'materialFormulas', cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private $idformula;

    #[ORM\ManyToOne(targetEntity: Materials::class, inversedBy: 'materialFormulas', cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private $idMaterial;

    #[ORM\Column(type: 'float')]
    private $quantity;

    #[ORM\Column(type: 'string', length: 5)]
    private $unit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdformula(): ?Formulas
    {
        return $this->idformula;
    }

    public function setIdformula(?Formulas $idformula): self
    {
        $this->idformula = $idformula;

        return $this;
    }

    public function getIdMaterial(): ?Materials
    {
        return $this->idMaterial;
    }

    public function setIdMaterial(?Materials $idMaterial): self
    {
        $this->idMaterial = $idMaterial;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public function __toString() {

        return $this->idformula;
    }
}
