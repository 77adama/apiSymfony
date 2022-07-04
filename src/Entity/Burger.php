<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(collectionOperations:[

        "post" => [
            // 'denormalization_context' => ['groups' => ['write']],
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
        // 'normalization_context' => ['groups' => ['produit:read:simple']],
        ]]
        ,)]
class Burger extends Produit
{
    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'burger')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
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
            $menu->addBurger($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBurger($this);
        }

        return $this;
    }
}
