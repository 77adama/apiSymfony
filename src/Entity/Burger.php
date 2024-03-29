<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(collectionOperations:[

        "post" => [
             'denormalization_context' => ['groups' => ['write_burger']],
            // 'normalization_context' => ['groups' => ['produit:read:all']],
            // "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get" => [
                 'normalization_context' => ['groups' => ['produit:read:all']],
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
         'normalization_context' => ['groups' => ['produit:read:simple']],
        ]]
        ,)]
class Burger extends Produit
{
    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
    #[Groups(["menu:read:al"])]
    private $menuBurgers;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }
}
