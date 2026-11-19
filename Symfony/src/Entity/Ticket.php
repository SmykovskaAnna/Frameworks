<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TicketRepository::class)]
class Ticket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $purchaseDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price = null;

    #[ORM\Column(length: 50)]
    private ?string $ticketType = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Visitor $visitor = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Exhibition $exhibition = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchaseDate(): ?\DateTime
    {
        return $this->purchaseDate;
    }

    public function setPurchaseDate(\DateTime $purchaseDate): static
    {
        $this->purchaseDate = $purchaseDate;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getTicketType(): ?string
    {
        return $this->ticketType;
    }

    public function setTicketType(string $ticketType): static
    {
        $this->ticketType = $ticketType;

        return $this;
    }

    public function getVisitor(): ?Visitor
    {
        return $this->visitor;
    }

    public function setVisitor(?Visitor $visitor): static
    {
        $this->visitor = $visitor;

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
}
