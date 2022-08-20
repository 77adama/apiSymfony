<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Controller\ProduitController;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"type", type:"string")]
#[ORM\DiscriminatorMap(["menu"=>"Menu","burger"=>"Burger","boisson"=>"Boisson","frittePortion" => "FrittePortion"])]
#[ApiResource(
    collectionOperations:[
        "get"=>[
             'method' => 'get',
            'status' => Response::HTTP_OK,
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
    #[Groups(["write_menu","menu:read:al","commande:read:all",
    "menu:read:all","produit:read:all","catalogue:read:all","menu:read:one",
    "boisson:read:all","fritte:read:all","client-reed-one",
    "commande:read:un","zone:read:all","zone:read:one"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write","produit:read:simple","write_boissons",
    "boisson:read:simple","write_fritte","fritte:read:simple",
    "menu:read:one","menu:read:simple","write_burger","write_menu",
    "menu:read:al","produit:read:all","catalogue:read:all","boisson:read:all",
    "fritte:read:all","commande:read:all","client-reed-one","commande:read:un",
    "zone:read:all","zone:read:one"])]
    #[Assert\NotBlank(message:"Le nom est Obligatoire")]
    protected $nom;

    #[ORM\Column(type: 'float')]
    // #[Groups(["produit:read:simple","produit:read:all","write"])]
    #[Groups(["produit:read:simple","write_boissons","write_fritte",
    "fritte:read:simple","menu:read:one","write_menu",
    "produit:read:all","menu:read:al","catalogue:read:all","write_burger",
    "boisson:read:all","fritte:read:all","client-reed-one","zone:read:all"])]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["commande:read:all","client-reed-one"])]
    protected $isEtat=true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    // #[Groups(["produit:read:simple","produit:read:all","write"])]
    #[Groups(["write","produit:read:simple","boisson:read:simple","fritte:read:simple"])]
    protected $gestionnaire;



   

    #[ORM\Column(type: 'blob')]
    #[Groups(["write_burger","write_fritte"])]
    private $image;

    
    #[SerializedName("image")]
    private $fakeImage;

    #[ORM\ManyToOne(targetEntity: LigneCommande::class, inversedBy: 'produit')]
    private $ligneCommande;

    

   

    

 

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

   

    
    public function getImage(): ?string
    {
        return (is_resource($this->image)?utf8_encode(base64_encode(stream_get_contents($this->image))):$this->image); 
    }

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }




    /**
     * Get the value of fakeImage
     */ 
    public function getFakeImage()
    {
        return $this->fakeImage;
    }

    /**
     * Set the value of fakeImage
     *
     * @return  self
     */ 
    public function setFakeImage($fakeImage)
    {
        $this->fakeImage = $fakeImage;

        return $this;
    }


    public function getLigneCommande(): ?LigneCommande
    {
        return $this->ligneCommande;
    }

    public function setLigneCommande(?LigneCommande $ligneCommande): self
    {
        $this->ligneCommande = $ligneCommande;

        return $this;
    }

      
}
