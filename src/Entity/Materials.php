<?php

namespace App\Entity;

use DateTimeZone;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MaterialsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: MaterialsRepository::class)]
#[UniqueEntity('name')]
class Materials
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $vendor;

    #[ORM\Column(type: 'float', nullable: true)]
    private $price;

    #[ORM\Column(type: 'string', length: 5, nullable: true, options: ["default" => "g"])]
    private $unit;

    #[ORM\OneToMany(mappedBy: 'idMaterial', targetEntity: MaterialFormula::class, cascade: ['persist'])]
    private $materialFormulas;

    #[ORM\Column(type: 'datetime_immutable', options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->materialFormulas = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now', new DateTimeZone('+0200'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    public function setVendor(string $vendor): self
    {
        $this->vendor = $vendor;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(?string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection<int, MaterialFormula>
     */
    public function getMaterialFormulas(): Collection
    {
        return $this->materialFormulas;
    }

    public function addMaterialFormula(MaterialFormula $materialFormula): self
    {
        if (!$this->materialFormulas->contains($materialFormula)) {
            $this->materialFormulas[] = $materialFormula;
            $materialFormula->setIdMaterial($this);
        }

        return $this;
    }

    public function removeMaterialFormula(MaterialFormula $materialFormula): self
    {
        if ($this->materialFormulas->removeElement($materialFormula)) {
            // set the owning side to null (unless already changed)
            if ($materialFormula->getIdMaterial() === $this) {
                $materialFormula->setIdMaterial(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function __toString(){
        return $this->name; // Remplacer champ par une propriété "string" de l'entité
    }
}
