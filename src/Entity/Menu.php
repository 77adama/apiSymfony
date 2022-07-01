<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\FrittePortion;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[

        "post" => [
            //'denormalization_context' => ['groups' => ['write_menu']],
            // 'normalization_context' => ['groups' => ['produit:read:all']],
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            // "get" => [
            //     'normalization_context' => ['groups' => ['produit:read:all']],
            //     ],
            ],
            itemOperations:[
                "put"=>[
                "security"=>"is_granted('ROLE_GESTIONNAIRE')",
                "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get"=>[
                // 'method' => 'get',
                // 'status' => Response::HTTP_OK,
               // 'normalization_context' => ['groups' => ['menu:read:simple']],
                ]]
)]
class Menu extends Produit
{
   
    // #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'menu')]
    // #[Groups(["menu:read:simple"])]
    // private $boissons;



    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
   // #[Groups(["menu:read:simple","write_menu"])]
    private $burger;

    #[ORM\ManyToMany(targetEntity: FrittePortion::class, mappedBy: 'menu')]
   // #[Groups(["menu:read:simple","write_menu"])]
    private $frittePortions;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'menus')]
    private $boisson;

    


    

    



    public function __construct()
    {
        // $this->boissons = new ArrayCollection();
        $this->burger = new ArrayCollection();
        $this->frittePortions = new ArrayCollection();

    }


    /**
     * @return Collection<int, Burger>
     */
    public function getBurger(): Collection
    {
        return $this->burger;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burger->contains($burger)) {
            $this->burger[] = $burger;
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        $this->burger->removeElement($burger);

        return $this;
    }

    /**
     * @return Collection<int, FrittePortion>
     */
    public function getFrittePortions(): Collection
    {
        return $this->frittePortions;
    }

    public function addFrittePortion(FrittePortion $frittePortion): self
    {
        if (!$this->frittePortions->contains($frittePortion)) {
            $this->frittePortions[] = $frittePortion;
            $frittePortion->addMenu($this);
        }

        return $this;
    }

    public function removeFrittePortion(FrittePortion $frittePortion): self
    {
        if ($this->frittePortions->removeElement($frittePortion)) {
            $frittePortion->removeMenu($this);
        }

        return $this;
    }

    //  public function totalBurger()
    // {
    //     return array_reduce($this->burgers->toArray(), function($totalBurger, $burger){
    //             return $totalBurger + $burger->getPrix();
    //     },0);
    // }
    // public function totalBoisson()
    // {
    //     return array_reduce($this->boissons->toArray(), function ($totalBoisson, $boisson){
    //             return $totalBoisson + $boisson->getPrix();
    //     },0);
    // }
    // public function totalFrittePortion()
    // {
    //     return array_reduce($this->frittes->toArray(), function ($totalFrittePortion, $frittePortion){
    //             return $totalFrittePortion + $frittePortion->getPrix();
    //     },0);
    // }

    // public function getPriceMenu()
    // {
    //     // array_reduce($this->burgers->toArray()), function ($totalBurger )
    //     return $this->totalBoisson() + $this->totalBurger() + $this->totalFrittePortion();

    // }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

   
}
