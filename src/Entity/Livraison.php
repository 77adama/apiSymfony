<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            // 'method' => 'get',
        //     'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['livraison:read:all']],
            ],
            "post" => [
                 'denormalization_context' => ['groups' => ['write_livraison']],
                // 'normalization_context' => ['groups' => ['produit:read:all']],
                "security"=>"is_granted('ROLE_LIVREUR')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
                ]  
            ],
    itemOperations:[
    // //     "put"=>[
    // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
    // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
    // // ],
    "get"=>[
    //     // 'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
    //     'normalization_context' => ['groups' => ['produit:read:all']],
        ]]
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'boolean')]
    private $etat_livraison=true;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["write_livraison","livraison:read:all"])]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(["write_livraison","livraison:read:all"])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(["livraison:read:all"])]
    private $livreur;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
    }

}
