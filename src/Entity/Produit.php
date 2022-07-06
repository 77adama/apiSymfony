<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\ProduitController;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["menu"=>"Menu","burger"=>"Burger","boisson"=>"Boisson","frittePortion" => "FrittePortion"])]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            // 'method' => 'get',
        //     'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['produit:read:simple']],
            ],
            "post" => [
            //     'denormalization_context' => ['groups' => ['write']],
            //     'normalization_context' => ['groups' => ['produit:read:all']],
            //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            //     "security_message"=>"Vous n'avez pas access à cette Ressource",
                ],
          "add" => [
                'method' => 'Post',
                "path"=>"/add",
                "controller"=>ProduitController::class,
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
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    //#[Groups(["write_menu"])]
    // #[Groups(["produit:read:simple","produit:read:all"])]
    #[Groups(["commande:write"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(["produit:read:simple","produit:read:all","write"])]
    #[Groups(["write","produit:read:simple","write_boisson",
    "boisson:read:simple","write_fritte","fritte:read:simple",
    "menu:read:simple","menu:read:simple"])]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    protected $nom;

    #[ORM\Column(type: 'float')]
    // #[Groups(["produit:read:simple","produit:read:all","write"])]
    #[Groups(["produit:read:simple","write_boisson","write_fritte",
    "fritte:read:simple","menu:read:simple"])]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    protected $isEtat=true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    // #[Groups(["produit:read:simple","produit:read:all","write"])]
    #[Groups(["write","produit:read:simple","boisson:read:simple","fritte:read:simple"])]
    protected $gestionnaire;

    #[ORM\ManyToMany(targetEntity: LigneCommande::class, inversedBy: 'produits')]
    private $ligneCommande;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: LigneCommande::class)]
    private $ligneCommandes;


 

 

    public function __construct()
    {
        $this->ligneCommandes = new ArrayCollection();
    }

    
    // #[ORM\Column(type: 'string', length: 255)]
    // private $type;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

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

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

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
     * @return Collection<int, LigneCommande>
     */
    public function getLigneCommandes(): Collection
    {
        return $this->ligneCommandes;
    }

    public function addLigneCommande(LigneCommande $ligneCommande): self
    {
        if (!$this->ligneCommandes->contains($ligneCommande)) {
            $this->ligneCommandes[] = $ligneCommande;
            $ligneCommande->setProduit($this);
        }

        return $this;
    }

    public function removeLigneCommande(LigneCommande $ligneCommande): self
    {
        if ($this->ligneCommandes->removeElement($ligneCommande)) {
            // set the owning side to null (unless already changed)
            if ($ligneCommande->getProduit() === $this) {
                $ligneCommande->setProduit(null);
            }
        }

        return $this;
    }



}
