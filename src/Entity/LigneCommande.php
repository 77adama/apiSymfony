<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LigneCommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LigneCommandeRepository::class)]
class LigneCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read:all","commande:read:un","zone:read:one"])]
    private $id;




    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'ligneCommande')]
    private $commande;

    #[ORM\Column(type: 'float')]
    #[Groups(["commande:write","commande:read:simple","commande:read:un","commande:read:all",
    "client-reed-one","zone:read:all","zone:read:one"])]
    #[Assert\NotBlank(message:"La quantite est Obligatoire")]
    private $quantite;

    #[ORM\Column(type: 'float')]
    #[Groups(["commande:write","commande:read:un","commande:read:one","commande:read:all",
    "client-reed-one","zone:read:all","zone:read:one"])]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'ligneCommande', targetEntity: Produit::class)]
    #[Groups(["commande:write","commande:read:simple","commande:read:un","commande:read:all",
    "client-reed-one","zone:read:all","zone:read:one"])]
    private $produit;

    // #[ORM\ManyToMany(targetEntity: Produit::class, inversedBy: 'ligneCommandes')]
    // #[Groups(["commande:write","commande:read:one","client-reed-one","commande:read:all",
    // "commande:read:un","commande:read:un"])]
    // private $produits;

   

   

    // #[ORM\OneToMany(mappedBy: 'ligneCommande', targetEntity: Produit::class)] 
    // #[Groups(["commande:write","commande:read:one","client-reed-one","commande:read:all"])]
    // private $produit;


    public function __construct()
    {
       
       
        $this->produits = new ArrayCollection();
        $this->produit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduit(): Collection
    {
        return $this->produit;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produit->contains($produit)) {
            $this->produit[] = $produit;
            $produit->setLigneCommande($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produit->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getLigneCommande() === $this) {
                $produit->setLigneCommande(null);
            }
        }

        return $this;
    }

    

    
    

}
