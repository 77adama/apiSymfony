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

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            // 'method' => 'get',
        //     'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['commande:read:simple']],
            ],
            "post" => [
                'denormalization_context' => ['groups' => ['commande:write']],
                // 'serialization_context' => 
                // 'normalization_context' => ['groups' => ['commande:read:all']],
                "security"=>"is_granted('ROLE_CLIENT')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
                ],
        //   "add" => [
        //         'method' => 'Post',
        //         "path"=>"/add",
        //         "controller"=>ProduitController::class,
        //         ]   
            ],
    itemOperations:[
        "put"=>[
    // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
    // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
    ],
    "get"=>[
    //     // 'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
        // 'normalization_context' => ['groups' => ['commande:read:simple']],
        ],
        // "post"=>[
        //         // 'method' => 'post',
        //     //     // 'status' => Response::HTTP_OK,
        //         'normalization_context' => ['groups' => ['listeCommandeFull']],
        //         ]
        ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read:simple"])]
    private $id;

    #[ORM\Column(type: 'datetime',nullable:true)]
    // #[Groups(["listeCommandeFull"])]
    private $timeAt;

    #[ORM\Column(type: 'boolean')]
    private $isEtat=true;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class,cascade:["persist"])]
    #[SerializedName("produits")]
    #[Groups(["commande:write","commande:read:simple"])]
    private $ligneCommande;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[Groups(["commande:write","commande:read:simple"])]
    private $client;


    public function __construct()
    {
        $this->ligneCommande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeAt(): ?\DateTimeInterface
    {
        return $this->timeAt;
    }

    public function setTimeAt(\DateTimeInterface $timeAt): self
    {
        $this->timeAt = $timeAt;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

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

}
