<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GlaceRepository;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;

use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: GlaceRepository::class)]
class Glace
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $secretIngredient = null;

    //IMG PART--------
    #[Vich\UploadableField(mapping: 'images', fileNameProperty: 'imageName')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    //IMG PART END--------


    /**
     * @var Collection<int, Topping>
     */
    #[ORM\ManyToMany(targetEntity: Topping::class, inversedBy: 'glaces')]
    private Collection $topping;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cornet $cornet = null;
    

    public function __construct()
    {
        $this->topping = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getSecretIngredient(): ?string
    {
        return $this->secretIngredient;
    }

    public function setSecretIngredient(string $secretIngredient): static
    {
        $this->secretIngredient = $secretIngredient;

        return $this;
    }

    /**
     * @return Collection<int, Topping>
     */
    public function getTopping(): Collection
    {
        return $this->topping;
    }

    public function addTopping(Topping $topping): static
    {
        if (!$this->topping->contains($topping)) {
            $this->topping->add($topping);
        }

        return $this;
    }

    public function removeTopping(Topping $topping): static
    {
        $this->topping->removeElement($topping);

        return $this;
    }

    public function getCornet(): ?Cornet
    {
        return $this->cornet;
    }

    public function setCornet(?Cornet $cornet): static
    {
        $this->cornet = $cornet;

        return $this;
    }

    public function setImageFile(?File $imageFile = null):void
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
}

