<?php

namespace App\Entity;

use App\Repository\ParcRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParcRepository::class)]
class Parc
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\OneToMany(mappedBy: 'parc', targetEntity: Arbre::class)]
    private Collection $arb;

    public function __construct()
    {
        $this->arb = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * @return Collection<int, Arbre>
     */
    public function getArb(): Collection
    {
        return $this->arb;
    }

    public function addArb(Arbre $arb): static
    {
        if (!$this->arb->contains($arb)) {
            $this->arb->add($arb);
            $arb->setParc($this);
        }

        return $this;
    }

    public function removeArb(Arbre $arb): static
    {
        if ($this->arb->removeElement($arb)) {
            // set the owning side to null (unless already changed)
            if ($arb->getParc() === $this) {
                $arb->setParc(null);
            }
        }

        return $this;
    }
}
