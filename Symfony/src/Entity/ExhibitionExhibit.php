<?php

namespace App\Entity;

use App\Repository\ExhibitionExhibitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitionExhibitRepository::class)]
class ExhibitionExhibit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $displayOrder = null;

    #[ORM\ManyToOne(inversedBy: 'exhibitionExhibits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exhibition $exhibition = null;

    #[ORM\ManyToOne(inversedBy: 'exhibitionExhibits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exhibit $exhibit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDisplayOrder(): ?int
    {
        return $this->displayOrder;
    }

    public function setDisplayOrder(int $displayOrder): static
    {
        $this->displayOrder = $displayOrder;

        return $this;
    }

    public function getExhibition(): ?Exhibition
    {
        return $this->exhibition;
    }

    public function setExhibition(?Exhibition $exhibition): static
    {
        $this->exhibition = $exhibition;

        return $this;
    }

    public function getExhibit(): ?Exhibit
    {
        return $this->exhibit;
    }

    public function setExhibit(?Exhibit $exhibit): static
    {
        $this->exhibit = $exhibit;

        return $this;
    }
}
