<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        // "get"=>[
        //     'method' => 'get',
        //     'status' => Response::HTTP_OK,
        //     'normalization_context' => ['groups' => ['produit:read:simple']],
        //     ],
            "post" => [
                // 'denormalization_context' => ['groups' => ['write']],
                // 'normalization_context' => ['groups' => ['produit:read:all']],
                "security"=>"is_granted('ROLE_CLIENT')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
                ],
        //   "add" => [
        //         'method' => 'Post',
        //         "path"=>"/add",
        //         "controller"=>ProduitController::class,
        //         ]   
            ],
    // itemOperations:[
    // //     "put"=>[
    // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
    // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
    // // ],
    // "get"=>[
    //     // 'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
    //     'normalization_context' => ['groups' => ['produit:read:all']],
    //     ]]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $timeAt;

    #[ORM\Column(type: 'boolean')] 
    private $isEtat=true;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: LigneCommande::class)]
    private $ligneCommande;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    private $gestionnaire;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Livraison::class)]
    private $livraison;

    public function __construct()
    {
        $this->ligneCommande = new ArrayCollection();
        $this->livraison = new ArrayCollection();
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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraison(): Collection
    {
        return $this->livraison;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraison->contains($livraison)) {
            $this->livraison[] = $livraison;
            $livraison->setCommande($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraison->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getCommande() === $this) {
                $livraison->setCommande(null);
            }
        }

        return $this;
    }

}
