<?php

namespace App\Entity;

use DateTimeZone;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;


#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProjectsRepository::class)]
class Projects
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $subject;

    #[ORM\Column(type: 'text')]
    private $goals;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $testingNumber;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    #[ORM\Column(type: 'datetime_immutable',  options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?DateTimeImmutable $updatedAt;

    #[ORM\OneToMany(mappedBy: 'projects', targetEntity: Formulas::class)]
    private $formulas;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $TimeForcast;

    #[ORM\Column(type: 'string', length: 100)]
    private $status;

    #[ORM\Column(type: 'integer')]
    private $active;

    #[ORM\Column(type: 'boolean')]
    private $isVisible;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'projects', cascade:['persist'])]
    #[ORM\JoinColumn(nullable: false)]
    private $User;

    public function __construct()
    {
        $this->formulas = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable('now', new DateTimeZone('+0200'));
        $this->updatedAt = new \DateTimeImmutable('now', new DateTimeZone('+0200'));
        $this->active = 0;
       
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTimeImmutable();
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

    public function getGoals(): ?string
    {
        return $this->goals;
    }

    public function setGoals(string $goals): self
    {
        $this->goals = $goals;

        return $this;
    }

    public function getTestingNumber(): ?int
    {
        return $this->testingNumber;
    }

    public function setTestingNumber(?int $testingNumber): self
    {
        $this->testingNumber = $testingNumber;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Formulas>
     */
    public function getFormulas(): Collection
    {
        return $this->formulas;
    }

    public function addFormula(Formulas $formula): self
    {
        if (!$this->formulas->contains($formula)) {
            $this->formulas[] = $formula;
            $formula->setProjects($this);
        }

        return $this;
    }

    public function removeFormula(Formulas $formula): self
    {
        if ($this->formulas->removeElement($formula)) {
            // set the owning side to null (unless already changed)
            if ($formula->getProjects() === $this) {
                $formula->setProjects(null);
            }
        }

        return $this;
    }

    public function getTimeForcast(): ?string
    {
        return $this->TimeForcast;
    }

    public function setTimeForcast(?string $TimeForcast): self
    {
        $this->TimeForcast = $TimeForcast;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getActive(): ?int
    {
        return $this->active;
    }

    public function setActive(int $active): self
    {
        $this->active = $active;

        return $this;
    }

   

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function __toString()
    {
        return $this->subject;
    }
}
