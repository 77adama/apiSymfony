<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations:[
          "get"=>[
            'normalization_context' => ['groups' => ['zone:read:all']],
          ]
           //   "post" => [

            //      ]
            ],
    itemOperations:[
        // "get"
    // //     "put"=>[
    // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
    // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
    // // ],
     "get"=>[
    //     // 'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['zone:read:one']],
         ]
        ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["zone:read:all","zone:read:one","commande:read:all","livraison:read:all"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["zone:read:all","zone:read:one","commande:read:all","livraison:read:all",
    "livraison:read:one"])]
    private $nom_zone;

    #[ORM\Column(type: 'float')]
    #[Groups(["zone:read:all","zone:read:one","commande:read:all","livraison:read:all",
    "livraison:read:one"])]
    private $prix_livr;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartier::class)]
    private $quartier;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'zones')]
    private $gestionnaire;



    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'zones')]
    #[Groups(["zone:read:all","zone:read:one"])]
    #[ApiSubresource]
    private $commandes;

    public function __construct()
    {
        $this->quartier = new ArrayCollection();
        $this->commandes = new ArrayCollection();
        $this->livraisons = new ArrayCollection();
    }

    // #[ORM\Column(type: 'string', length: 255)]
    // private $prix_livraison;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomZone(): ?string
    {
        return $this->nom_zone;
    }

    public function setNomZone(string $nom_zone): self
    {
        $this->nom_zone = $nom_zone;

        return $this;
    }

    // public function getPrixLivraison(): ?string
    // {
    //     return $this->prix_livraison;
    // }

    // public function setPrixLivraison(string $prix_livraison): self
    // {
    //     $this->prix_livraison = $prix_livraison;

    //     return $this;
    // }

    public function getPrixLivr(): ?float
    {
        return $this->prix_livr;
    }

    public function setPrixLivr(float $prix_livr): self
    {
        $this->prix_livr = $prix_livr;

        return $this;
    }

    /**
     * @return Collection<int, Quartier>
     */
    public function getQuartier(): Collection
    {
        return $this->quartier;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartier->contains($quartier)) {
            $this->quartier[] = $quartier;
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartier->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
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


    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setZone($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getZone() === $this) {
                $livraison->setZone(null);
            }
        }

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
            $commande->addZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeZone($this);
        }

        return $this;
    }

}
