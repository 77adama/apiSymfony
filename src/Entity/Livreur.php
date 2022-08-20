<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            // 'method' => 'get',
        //     'status' => Response::HTTP_OK,
           'normalization_context' => ['groups' => ['livreur:read:all']],
            ],
            "post" => [
                'denormalization_context' => ['groups' => ['livreur:write']],
                // 'serialization_context' => 
                
               // "security"=>"is_granted('ROLE_CLIENT')",
              //  "security_message"=>"Vous n'avez pas access à cette Ressource",
                ],
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
        'denormalization_context' => ['groups' => ['livreur:read:put']],

        // "security" => "is_granted('ROLE_GESTIONNAIRE')",
        // "security_message"=>"Vous n'avez pas access à cette Ressource",
        // 'status' => Response::HTTP_OK,
    ],
    "get"=>[
      //   'method' => 'get',
    //     // 'status' => Response::HTTP_OK,
         'normalization_context' => ['groups' => ['livreur:read:un']],
        ],
        ]
)]
class Livreur extends User
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:read:all","livreur:read:un"])]
    private $matricule;



    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["livreur:read:all","livraison:read:all","livreur:read:un",
    "livreur:read:put"])]
    private $etatLiv;

    public function __construct()
    {
        parent::__construct();
        $this->livraisons = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

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
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }

    public function getEtatLiv(): ?string
    {
        return $this->etatLiv;
    }

    public function setEtatLiv(string $etatLiv): self
    {
        $this->etatLiv = $etatLiv;

        return $this;
    }


}
