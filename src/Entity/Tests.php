<?php

namespace App\Entity;

use DateTimeZone;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TestsRepository;

#[ORM\Entity(repositoryClass: TestsRepository::class)]
class Tests
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $critere;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pres;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $duedate;

    #[ORM\Column(type: 'string', length: 15, nullable: true)]
    private $unit;

    #[ORM\OneToMany(mappedBy: 'tests', targetEntity: Results::class, orphanRemoval: true)]
    private $results;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?DateTimeImmutable $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now', new DateTimeZone('+0200'));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCritere(): ?string
    {
        return $this->critere;
    }

    public function setCritere(string $critere): self
    {
        $this->critere = $critere;

        return $this;
    }

    public function getPres(): ?string
    {
        return $this->pres;
    }

    public function setPres(?string $pres): self
    {
        $this->pres = $pres;

        return $this;
    }

    public function getDuedate(): ?string
    {
        return $this->duedate;
    }

    public function setDuedate(?string $duedate): self
    {
        $this->duedate = $duedate;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function __toString()
    {
        return $this->critere;
    }
}
