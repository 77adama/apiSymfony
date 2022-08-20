<?php

namespace App\Entity;

use App\Controller\ValideEmail;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"role", type:"string")]
#[ORM\DiscriminatorMap(["gestionnaaire"=>"Gestionnaire","client" => "Client","livreur"=>"Livreur" ])]
#[ApiResource(
    collectionOperations:[
        // "get",
        // "post_register" => [
        // "method"=>"post",
        // 'path'=>'/register', 
        // 'normalization_context' => ['groups' => ['user:read:simple']],
       
        // ],
         "post" => [
            'normalization_context' => ['groups' => ['produit:read:all']],
             ],
        "token" => [
            'method' => 'patch',
            "path"=>"user/validate/{token}",
            "controller"=>ValideEmail::class,
            "deserialize"=>false
            ]   
        ],
        
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["boisson:read:simple","fritte:read:simple","client-reed-one",
    "livreur:read:all","livraison:read:all","livreur:read:un"])]
    protected $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    // #[Groups(["produit:read:all","user:read:simple","produit:read:simple","write_"])]
    #[Groups(["livraison:read:all","boisson:read:simple","fritte:read:simple","write_g","client-reed-one"
    ,"commande:read:all","livreur:read:all","livreur:read:un","livreur:read:put"])]
    protected $email;

    #[ORM\Column(type: 'json')]
    // #[Groups(["write_"])]
    protected $roles = [];

    #[ORM\Column(type: 'string')]
   
    // #[Groups(["write_"])]
    protected $password;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livraison:read:all","write_","write_g","client-reed-one","commande:read:all",
    "zone:read:all","livreur:read:all","livreur:read:un"])]
    protected $nom;

    #[ORM\Column(type: 'string', length: 255)]
     #[Groups(["produit:read:simple","write_","write_g"])]
    protected $prenom;

    
     
    #[SerializedName("password")]
    protected $plainPassword;

    // #[ORM\OneToMany(mappedBy: 'user', targetEntity: Produit::class)]
    // private $produits;

    #[ORM\Column(type: 'datetime')]
    private $expireAt;

    #[ORM\Column(type: 'boolean')]
    private $isEnable=false;

    #[ORM\Column(type: 'string', length: 255)]
    private $token;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Menu::class)]
    private $menus;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
        $this->expireAt= new \DateTime("+1 day");
        $this->token=str_replace(['+', '/', '='], ['-', '_', ''], base64_encode(random_bytes(128)));
        $this->menus = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
         $this->plainPassword = null;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    // /**
    //  * @return Collection<int, Produit>
    //  */
    // public function getProduits(): Collection
    // {
    //     return $this->produits;
    // }

    // public function addProduit(Produit $produit): self
    // {
    //     if (!$this->produits->contains($produit)) {
    //         $this->produits[] = $produit;
    //         $produit->setUser($this);
    //     }

    //     return $this;
    // }

    // public function removeProduit(Produit $produit): self
    // {
    //     if ($this->produits->removeElement($produit)) {
    //         // set the owning side to null (unless already changed)
    //         if ($produit->getUser() === $this) {
    //             $produit->setUser(null);
    //         }
    //     }

    //     return $this;
    // }

    public function getExpireAt(): ?\DateTimeInterface
    {
        return $this->expireAt;
    }

    public function setExpireAt(\DateTimeInterface $expireAt): self
    {
        $this->expireAt = $expireAt;

        return $this;
    }

    public function isIsEnable(): ?bool
    {
        return $this->isEnable;
    }

    public function setIsEnable(bool $isEnable): self
    {
        $this->isEnable = $isEnable;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setUser($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getUser() === $this) {
                $menu->setUser(null);
            }
        }

        return $this;
    }
}
