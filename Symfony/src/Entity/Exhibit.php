<?php

namespace App\Entity;

use App\Repository\ExhibitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExhibitRepository::class)]
class Exhibit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $author = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $creationDate = null;

    /**
     * @var Collection<int, ExhibitionExhibit>
     */
    #[ORM\OneToMany(targetEntity: ExhibitionExhibit::class, mappedBy: 'exhibit')]
    private Collection $exhibitionExhibits;

    public function __construct()
    {
        $this->exhibitionExhibits = new ArrayCollection();
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

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getCreationDate(): ?\DateTime
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTime $creationDate): static
    {
        $this->creationDate = $creationDate;

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
            $exhibitionExhibit->setExhibit($this);
        }

        return $this;
    }

    public function removeExhibitionExhibit(ExhibitionExhibit $exhibitionExhibit): static
    {
        if ($this->exhibitionExhibits->removeElement($exhibitionExhibit)) {
            // set the owning side to null (unless already changed)
            if ($exhibitionExhibit->getExhibit() === $this) {
                $exhibitionExhibit->setExhibit(null);
            }
        }

        return $this;
    }
}
