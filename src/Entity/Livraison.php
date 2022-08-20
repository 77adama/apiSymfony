<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
// #[ApiResource(
//     collectionOperations:[
//         "get"=>[
//             // 'method' => 'get',
//         //     'status' => Response::HTTP_OK,
//            'normalization_context' => ['groups' => ['livraison:read:all']],
//             ],
//             "post" => [
//                 'denormalization_context' => ['groups' => ['livraison:write']],
//                 // 'serialization_context' => 
                
//                // "security"=>"is_granted('ROLE_CLIENT')",
//               //  "security_message"=>"Vous n'avez pas access à cette Ressource",
//                 ],
//             ],
//     itemOperations:[
//         // "put"=>[
            
//             // 'status' => Response::HTTP_OK,
//         // 'normalization_context' => ['groups' => ['commande:read:put']],

//     // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
//     // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
//     // ],
//     "put"=>[
//         'method' => 'put',
//         'denormalization_context' => ['groups' => ['livraison:read:put']],

//         // "security" => "is_granted('ROLE_GESTIONNAIRE')",
//         // "security_message"=>"Vous n'avez pas access à cette Ressource",
//         // 'status' => Response::HTTP_OK,
//     ],
//     "get"=>[
//       //   'method' => 'get',
//     //     // 'status' => Response::HTTP_OK,
//          'normalization_context' => ['groups' => ['livraison:read:un']],
//         ],
//         ]
// )]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'normalization_context' => ['groups' => ['livraison:read:all']]
        ],
        "post",
    ],
    itemOperations:[
        "put"=>[
            // 'method' => 'put',
            'denormalization_context' => ['groups' => ['livraison:read:put']],
    
            // "security" => "is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas access à cette Ressource",
            // 'status' => Response::HTTP_OK,
        ],
        "get"=>[
            'normalization_context' => ['groups' => ['livraison:read:one']]
        ],
    ]
)]
class Livraison
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["livraison:read:all","livraison:read:one"])]
    private $id;

    // #[ORM\Column(type: 'boolean')]
    // private $etat_livraison=true;

    // #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    // #[Groups(["write_livraison"])]
    // private $commandes;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'livraisons')]
    #[Groups(["livraison:read:all","livraison:write","livraison:read:one",
    "commande:read:simple","commande:read:one","commande:write"])]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    #[Groups(["livraison:read:all","livraison:write","livraison:read:one"])]
    private $livreur;

    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    #[Groups(["livraison:write","livraison:read:all","livraison:read:one","livraison:read:put"])] 
    private $commandes;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livraison:read:all","livraison:write","livraison:read:put"])]
    private $etat_livraison;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

 

    public function getId(): ?int
    {
        return $this->id;
    }

    

    // /**
    //  * @return Collection<int, Commande>
    //  */
    // public function getCommandes(): Collection
    // {
    //     return $this->commandes;
    // }

    // public function addCommande(Commande $commande): self
    // {
    //     if (!$this->commandes->contains($commande)) {
    //         $this->commandes[] = $commande;
    //         $commande->setLivraison($this);
    //     }

    //     return $this;
    // }

    // public function removeCommande(Commande $commande): self
    // {
    //     if ($this->commandes->removeElement($commande)) {
    //         // set the owning side to null (unless already changed)
    //         if ($commande->getLivraison() === $this) {
    //             $commande->setLivraison(null);
    //         }
    //     }

    //     return $this;
    // }

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

    public function getEtatLivraison(): ?string
    {
        return $this->etat_livraison;
    }

    public function setEtatLivraison(string $etat_livraison): self
    {
        $this->etat_livraison = $etat_livraison;

        return $this;
    }

}
