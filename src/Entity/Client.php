<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
/**
 *
 * @ApiResource
 */
#[ApiResource(
    collectionOperations:[
        "get",
        "post" => [
       
        'denormalization_context' => ['groups' => ['write_']],
        ]
        ],
        itemOperations:[
            
            // //     "put"=>[
            // //     "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // //     "security_message"=>"Vous n'avez pas access à cette Ressource",
            // // ],
            "get"=>[
                'normalization_context' => ['groups' => ['client-reed-one']],
            ]
            
                ]
        
)]
class Client extends User
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write_","client-reed-one"],"commande:read:all")]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    #[Groups(["write_","client-reed-one"])]
    #[ApiSubresource]
    private $commandes;


    public function __construct()
    {
        parent::__construct();
        $this->commandes = new ArrayCollection();
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

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
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }
}
