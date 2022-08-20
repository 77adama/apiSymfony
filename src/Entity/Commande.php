<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\ProduitController;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            // 'method' => 'get',
        //     'status' => Response::HTTP_OK,
           'normalization_context' => ['groups' => ['commande:read:all']],
            ],
            "post" => [
                'denormalization_context' => ['groups' => ['commande:write']],
                // 'serialization_context' => 
                
               // "security"=>"is_granted('ROLE_CLIENT')",
              //  "security_message"=>"Vous n'avez pas access à cette Ressource",
                ],
        //   "add" => [
        //         'method' => 'Post',
        //         "path"=>"/add",
        //         "controller"=>ProduitController::class,
        //         ]   
            ],
    itemOperations:[
        // "put"=>[
            
            // 'status' => Response::HTTP_OK,
        // 'normalization_context' => ['groups' => ['commande:read:put']],

    // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
    // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
    // ],
    "put"=>[
        'method' => 'put',
        'denormalization_context' => ['groups' => ['commande:read:put']],

        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
        // 'status' => Response::HTTP_OK,
    ],
    "get"=>[
      //   'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
         'normalization_context' => ['groups' => ['commande:read:un']],
        ],
        ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read:all","commande:read:un","client-reed-one",
    "zone:read:all","zone:read:one","livraison:read:put","livraison:read:one"])]
    private $id;

    // #[ORM\Column(type: 'datetime')]
    // // #[Groups(["listeCommandeFull"])]
    // private $timeAt;

    // #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(["client-reed-one","commande:read:un","commande:read:all",
    // "commande:write"])]
    // private $isEtat=encours;

    
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade:["persist"])]
    #[Groups(["commande:write","commande:write:simple","commande:read:un","commande:read:all","client-reed-one",
    "zone:read:all","zone:read:one","livraison:read:all"])]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    #[SerializedName("produits")]
    private $ligneCommande;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(["commande:read:simple","commande:read:one","commande:write","commande:read:all",
    "commande:read:un","zone:read:all"])]
    private $client;

    #[ORM\ManyToMany(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["commande:read:simple","commande:read:one","commande:write","commande:read:all"])]
    private $zones;

    #[ORM\Column(type: 'datetime_immutable')]
    #[Groups(["commande:read:simple","commande:read:one","commande:write","commande:read:all",
    "zone:read:all","zone:read:one","client-reed-one"])]
    private $timeAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livraison:read:all","commande:read:simple","commande:read:one","commande:write","commande:read:all","commande:read:put",
    "client-reed-one","zone:read:all","zone:read:one","livraison:read:one","livraison:read:put"])]
    private $etat;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

   


    public function __construct()
    {
        $this->ligneCommande = new ArrayCollection();
        $this->zones = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    // public function getTimeAt(): ?\DateTimeInterface
    // {
    //     return $this->timeAt;
    // }

    // public function setTimeAt(\DateTimeInterface $timeAt): self
    // {
    //     $this->timeAt = $timeAt;

    //     return $this;
    // }

    // public function isIsEtat(): ?bool
    // {
    //     return $this->isEtat;
    // }

    // public function setIsEtat(bool $isEtat): self
    // {
    //     $this->isEtat = $isEtat;

    //     return $this;
    // }

    /**
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommande(): Collection
    {
        return $this->ligneCommande;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommande->contains($ligneCommande)) {
            $this->ligneCommande[] = $ligneCommande;
            $ligneCommande->setCommande($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommande->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getCommande() === $this) {
                $ligneCommande->setCommande(null);
            }
        }

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, Zone>
     */
    public function getZones(): Collection
    {
        return $this->zones;
    }

    public function addZone(Zone $zone): self
    {
        if (!$this->zones->contains($zone)) {
            $this->zones[] = $zone;
        }

        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        $this->zones->removeElement($zone);

        return $this;
    }

    public function getTimeAt(): ?\DateTimeImmutable
    {
        return $this->timeAt;
    }

    public function setTimeAt(\DateTimeImmutable $timeAt): self
    {
        $this->timeAt = $timeAt;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    

}
