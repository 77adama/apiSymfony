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
            // 'denormalization_context' => ['groups' => ['write_fritte']],
            // 'normalization_context' => ['groups' => ['produit:read:all']],
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get" => [
            //     'normalization_context' => ['groups' => ['produit:read:all']],
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
    #[Groups(["write_fritte","fritte:read:simple"])]
    private $portionnss;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'frittePortions')]
    private $menu;

    



    public function __construct()
    {
        parent::__construct();
        $this->menu = new ArrayCollection();
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
     * @return Collection<int, Menu>
     */
    public function getMenu(): Collection
    {
        return $this->menu;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menu->contains($menu)) {
            $this->menu[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menu->removeElement($menu);

        return $this;
    }
    
}
