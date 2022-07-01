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
    private $etat_livraison;

    #[ORM\Column(type: 'datetime')]
    private $DateAt;


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

   
}
