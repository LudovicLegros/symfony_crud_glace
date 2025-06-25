<?php

namespace App\Entity;

use App\Repository\ToppingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ToppingRepository::class)]
class Topping
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    /**
     * @var Collection<int, Glace>
     */
    #[ORM\ManyToMany(targetEntity: Glace::class, mappedBy: 'topping')]
    private Collection $glaces;

    public function __construct()
    {
        $this->glaces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, Glace>
     */
    public function getGlaces(): Collection
    {
        return $this->glaces;
    }

    public function addGlace(Glace $glace): static
    {
        if (!$this->glaces->contains($glace)) {
            $this->glaces->add($glace);
            $glace->addTopping($this);
        }

        return $this;
    }

    public function removeGlace(Glace $glace): static
    {
        if ($this->glaces->removeElement($glace)) {
            $glace->removeTopping($this);
        }

        return $this;
    }
}
