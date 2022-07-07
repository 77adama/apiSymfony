<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\FrittePortion;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\MenuController;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[

        "post" => [
            // 'denormalization_context' => ['groups' => ['write_menu']],
             'normalization_context' => ['groups' => ['produit:read:all']],
            "security"=>"is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            ],
            "get" => [
                "path"=>"/menu2",
                 'normalization_context' => ['groups' => ['produit:read:all']],
                ],
                "menu2" => [
                    'method' => 'Post',
                    "path"=>"/menu2",
                    "deserialize"=>false,
                    "controller"=>MenuController::class,
                    ]
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
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:["persist"])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBoisson::class,cascade:["persist"])]
    private $menuBoissons;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFritte::class,cascade:["persist"])]
    private $menuFrittes;

    public function __construct()
    {
        parent::__construct();
        $this->menuBurgers = new ArrayCollection();
        $this->menuBoissons = new ArrayCollection();
        $this->menuFrittes = new ArrayCollection();
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
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBoisson>
     */
    public function getMenuBoissons(): Collection
    {
        return $this->menuBoissons;
    }

    public function addMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if (!$this->menuBoissons->contains($menuBoisson)) {
            $this->menuBoissons[] = $menuBoisson;
            $menuBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getMenu() === $this) {
                $menuBoisson->setMenu(null);
            }
        }

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
            $menuFritte->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFritte(MenuFritte $menuFritte): self
    {
        if ($this->menuFrittes->removeElement($menuFritte)) {
            // set the owning side to null (unless already changed)
            if ($menuFritte->getMenu() === $this) {
                $menuFritte->setMenu(null);
            }
        }

        return $this;
    }


 
    public function addBurger(Burger $burger,int $qt=1){
        $mb= new MenuBurger();
        $mb->setBurger($burger);
        $mb->setQuantite($qt);
        $mb->setMenu($this);
        $this->addMenuBurger($mb);
    }

    public function addBoisson(Boisson $boisson,int $qt=1){
        $mboi= new MenuBoisson();
        $mboi->setBoisson($boisson);
        $mboi->setQuantite($qt);
        $mboi->setMenu($this);
        $this->addMenuBoisson($mboi);
    }

    public function addFritte(FrittePortion $fritte,int $qt=1){
        $mfrit= new MenuFritte();
        $mfrit->setFritte($fritte);
        $mfrit->setQuantite($qt);
        $mfrit->setMenu($this);
        $this->addMenuFritte($mfrit);
    }

}
