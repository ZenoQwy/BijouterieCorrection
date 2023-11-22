<?php

namespace App\Entity;

use App\Repository\BijouRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

// Permet de trier les données 
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter; 
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter; 

use Symfony\Component\Serializer\Annotation\Groups;


#[ApiResource(paginationItemsPerPage: 10, 
operations:[new Get(normalizationContext:['groups' => 'bijou:item']),
            new GetCollection(normalizationContext:['groups' => 'bijou:list'])])]

#[ApiFilter(OrderFilter::class, properties:['description' => 'ASC'])] 

#[ORM\Entity(repositoryClass: BijouRepository::class)]
class Bijou
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['location:list','location:item'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups(['location:list','location:item'])]
    private ?float $prixVente = null;

    #[ORM\Column]
    #[Groups(['location:list','location:item'])]
    private ?float $prixLocation = null;

    #[ORM\ManyToOne(inversedBy: 'bijous')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['bijou:list','bijou:item','categorie:item','categorie:list'])]
    private ?Categorie $categorie = null;

    #[ORM\OneToMany(mappedBy: 'bijou', targetEntity: Location::class)]
    private Collection $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrixVente(): ?float
    {
        return $this->prixVente;
    }

    public function setPrixVente(float $prixVente): static
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getPrixLocation(): ?float
    {
        return $this->prixLocation;
    }

    public function setPrixLocation(float $prixLocation): static
    {
        $this->prixLocation = $prixLocation;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Location>
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): static
    {
        if (!$this->locations->contains($location)) {
            $this->locations->add($location);
            $location->setBijou($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getBijou() === $this) {
                $location->setBijou(null);
            }
        }

        return $this;
    }
}
