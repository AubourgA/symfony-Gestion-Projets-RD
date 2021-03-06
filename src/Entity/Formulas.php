<?php

namespace App\Entity;

use DateTimeZone;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FormulasRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormulasRepository::class)]
class Formulas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $subject;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaires;

    #[ORM\OneToMany(mappedBy: 'idformula', targetEntity: MaterialFormula::class, orphanRemoval: true, cascade: ["persist"])]
    #[ORM\JoinColumn(name: "idformula_id", referencedColumnName: "id")]
    private $materialFormulas;

    #[ORM\ManyToOne(targetEntity: Projects::class, inversedBy: 'formulas')]
    #[ORM\JoinColumn(nullable: false)]
    private $projects;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'formula', targetEntity: Results::class, orphanRemoval: true)]
    private $results;

    #[ORM\OneToMany(mappedBy: 'formula', targetEntity: Images::class, cascade: ["persist"])]
    private $images;

    public function __construct()
    {
        $this->materialFormulas = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now', new DateTimeZone('+0200'));
        $this->results = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->commentaires;
    }

    public function setComment(?string $commentaires): self
    {
        $this->commentaires = $commentaires;

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
            $materialFormula->setIdformula($this);
        }

        return $this;
    }

    public function removeMaterialFormula(MaterialFormula $materialFormula): self
    {
        if ($this->materialFormulas->removeElement($materialFormula)) {
            // set the owning side to null (unless already changed)
            if ($materialFormula->getIdformula() === $this) {
                $materialFormula->setIdformula(null);
            }
        }

        return $this;
    }

    public function getProjects(): ?Projects
    {
        return $this->projects;
    }

    public function setProjects(?Projects $projects): self
    {
        $this->projects = $projects;

        return $this;
    }

    public function __toString(){
        return $this->subject; // Remplacer champ par une propri??t?? "string" de l'entit??
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

    /**
     * @return Collection<int, Results>
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    public function addResult(Results $result): self
    {
        if (!$this->results->contains($result)) {
            $this->results[] = $result;
            $result->setFormula($this);
        }

        return $this;
    }

    public function removeResult(Results $result): self
    {
        if ($this->results->removeElement($result)) {
            // set the owning side to null (unless already changed)
            if ($result->getFormula() === $this) {
                $result->setFormula(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setFormula($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getFormula() === $this) {
                $image->setFormula(null);
            }
        }

        return $this;
    }
}
