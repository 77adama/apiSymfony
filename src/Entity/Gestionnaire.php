<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
// /**
//  * @ORM\Entity(repositoryClass="App\Repository\GestionnaireRepository")
//  *
//  * @ApiResource
//  */
#[ApiResource(
    collectionOperations:[
    ],
)]

class Gestionnaire extends User
{




 
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private $produits;

    // #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    // #[ApiSubresource]
    // #[Groups(["produit:read:all"])]
    // private $produits;



    public function __construct()
    {
        parent::__construct();
        // $this->produits = new ArrayCollection();
        // $this->burgers = new ArrayCollection();
        
    }


    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }
}
