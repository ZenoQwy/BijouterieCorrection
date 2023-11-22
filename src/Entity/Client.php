<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;

// Permet de trier les données 
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter; 
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter; 

use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(paginationItemsPerPage:  10, 
operations:[new Get(normalizationContext:['groups' => 'client:item']),
            new GetCollection(normalizationContext:['groups' => 'client:list'])])]


#[ApiFilter(SearchFilter::class, properties:['nom' => 'partial','prenom' => 'partial'])]
#[ApiFilter(OrderFilter::class,properties:['nom' => 'ASC','prenom' => 'ASC'])]

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['client:item','client:list','location:item','location:list'])]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Groups(['client:item','client:list','location:item','location:list'])]
    private ?string $prenom = null;

    #[ORM\Column(length: 100)]
    private ?string $rue = null;

    #[ORM\Column(length: 10)]
    private ?string $cp = null;

    #[ORM\Column(length: 50)]
    private ?string $ville = null;

    #[ORM\Column(length: 50)]
    private ?string $email = null;

    #[ORM\Column(length: 25)]
    private ?string $telFixe = null;

    #[ORM\Column(length: 25)]
    private ?string $telPortable = null;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Location::class)]
    private Collection $locations;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->rue;
    }

    public function setRue(string $rue): static
    {
        $this->rue = $rue;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelFixe(): ?string
    {
        return $this->telFixe;
    }

    public function setTelFixe(string $telFixe): static
    {
        $this->telFixe = $telFixe;

        return $this;
    }

    public function getTelPortable(): ?string
    {
        return $this->telPortable;
    }

    public function setTelPortable(string $telPortable): static
    {
        $this->telPortable = $telPortable;

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
            $location->setClient($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): static
    {
        if ($this->locations->removeElement($location)) {
            // set the owning side to null (unless already changed)
            if ($location->getClient() === $this) {
                $location->setClient(null);
            }
        }

        return $this;
    }
}
