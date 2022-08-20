<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FrittePortionRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FrittePortionRepository::class)]
#[ApiResource(
    collectionOperations:[

        "post" => [
            'denormalization_context' => ['groups' => ['write_fritte']],
            // 'normalization_context' => ['groups' => ['produit:read:all']],
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get" => [
               'normalization_context' => ['groups' => ['fritte:read:all']],
                ],
            ],
            itemOperations:[
                "put"=>[
                "security"=>"is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get"=>[
                // 'method' => 'get',
                // 'status' => Response::HTTP_OK,
                // 'normalization_context' => ['groups' => ['fritte:read:simple']],
                ]
                ]
)]
class FrittePortion extends Produit
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write_fritte","fritte:read:simple","catalogue:read:all",
    "menu:read:one","fritte:read:all"])]
    private $portionnss;

    #[ORM\OneToMany(mappedBy: 'fritte', targetEntity: MenuFritte::class)]
    private $menuFrittes;

    public function __construct()
    {
        parent::__construct();
        $this->menuFrittes = new ArrayCollection();
    }


    public function getPortionnss(): ?string
    {
        return $this->portionnss;
    }

    public function setPortionnss(string $portionnss): self
    {
        $this->portionnss = $portionnss;

        return $this;
    }

    /**
     * @return Collection<int, MenuFritte>
     */
    public function getMenuFrittes(): Collection
    {
        return $this->menuFrittes;
    }

    public function addMenuFritte(MenuFritte $menuFritte): self
    {
        if (!$this->menuFrittes->contains($menuFritte)) {
            $this->menuFrittes[] = $menuFritte;
            $menuFritte->setFritte($this);
        }

        return $this;
    }

    public function removeMenuFritte(MenuFritte $menuFritte): self
    {
        if ($this->menuFrittes->removeElement($menuFritte)) {
            // set the owning side to null (unless already changed)
            if ($menuFritte->getFritte() === $this) {
                $menuFritte->setFritte(null);
            }
        }

        return $this;
    }

    
}
