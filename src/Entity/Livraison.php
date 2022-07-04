<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $etat_livraison=true;

    #[ORM\Column(type: 'datetime')]
    private $DateAt;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'livraison')]
    private $commande;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Livreur::class)]
    private $livreur;


    public function __construct()
    {
        $this->livreur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEtatLivraison(): ?bool
    {
        return $this->etat_livraison;
    }

    public function setEtatLivraison(bool $etat_livraison): self
    {
        $this->etat_livraison = $etat_livraison;

        return $this;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->DateAt;
    }

    public function setDateAt(\DateTimeInterface $DateAt): self
    {
        $this->DateAt = $DateAt;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * @return Collection<int, Livreur>
     */
    public function getLivreur(): Collection
    {
        return $this->livreur;
    }

    public function addLivreur(Livreur $livreur): self
    {
        if (!$this->livreur->contains($livreur)) {
            $this->livreur[] = $livreur;
            $livreur->setLivraison($this);
        }

        return $this;
    }

    public function removeLivreur(Livreur $livreur): self
    {
        if ($this->livreur->removeElement($livreur)) {
            // set the owning side to null (unless already changed)
            if ($livreur->getLivraison() === $this) {
                $livreur->setLivraison(null);
            }
        }

        return $this;
    }

   
}
