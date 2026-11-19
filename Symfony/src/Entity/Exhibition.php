<?php

namespace App\Entity;

use App\Repository\ExhibitionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitionRepository::class)]
class Exhibition
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    /**
     * @var Collection<int, ExhibitionExhibit>
     */
    #[ORM\OneToMany(targetEntity: ExhibitionExhibit::class, mappedBy: 'exhibition')]
    private Collection $exhibitionExhibits;

    /**
     * @var Collection<int, Ticket>
     */
    #[ORM\OneToMany(targetEntity: Ticket::class, mappedBy: 'exhibition')]
    private Collection $tickets;

    public function __construct()
    {
        $this->exhibitionExhibits = new ArrayCollection();
        $this->tickets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, ExhibitionExhibit>
     */
    public function getExhibitionExhibits(): Collection
    {
        return $this->exhibitionExhibits;
    }

    public function addExhibitionExhibit(ExhibitionExhibit $exhibitionExhibit): static
    {
        if (!$this->exhibitionExhibits->contains($exhibitionExhibit)) {
            $this->exhibitionExhibits->add($exhibitionExhibit);
            $exhibitionExhibit->setExhibition($this);
        }

        return $this;
    }

    public function removeExhibitionExhibit(ExhibitionExhibit $exhibitionExhibit): static
    {
        if ($this->exhibitionExhibits->removeElement($exhibitionExhibit)) {
            // set the owning side to null (unless already changed)
            if ($exhibitionExhibit->getExhibition() === $this) {
                $exhibitionExhibit->setExhibition(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Ticket>
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): static
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets->add($ticket);
            $ticket->setExhibition($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): static
    {
        if ($this->tickets->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getExhibition() === $this) {
                $ticket->setExhibition(null);
            }
        }

        return $this;
    }
}
