<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
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


#[ApiResource(paginationItemsPerPage: 10, 
operations:[new Get(normalizationContext:['groups' => 'categorie:item']),
            new GetCollection(normalizationContext:['groups' => 'categorie:list'])])]
#[ORM\Entity(repositoryClass: CategorieRepository::class)]

class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['bijou:list','bijou:item','categorie:item','categorie:list'])]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Bijou::class)]
    private Collection $bijous;

    public function __construct()
    {
        $this->bijous = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): static
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Bijou>
     */
    public function getBijous(): Collection
    {
        return $this->bijous;
    }

    public function addBijou(Bijou $bijou): static
    {
        if (!$this->bijous->contains($bijou)) {
            $this->bijous->add($bijou);
            $bijou->setCategorie($this);
        }

        return $this;
    }

    public function removeBijou(Bijou $bijou): static
    {
        if ($this->bijous->removeElement($bijou)) {
            // set the owning side to null (unless already changed)
            if ($bijou->getCategorie() === $this) {
                $bijou->setCategorie(null);
            }
        }

        return $this;
    }
}
