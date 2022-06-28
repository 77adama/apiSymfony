<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource]
class Menu extends Produit
{
   
    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'menu')]
    private $boissons;

    #[ORM\ManyToMany(targetEntity: Fritte::class, inversedBy: 'menus')]
    private $fritte;

    #[ORM\ManyToMany(targetEntity: Burger::class, inversedBy: 'menus')]
    private $burger;

    



    public function __construct()
    {
        $this->fritte = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->burger = new ArrayCollection();
    }


    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->addMenu($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            $boisson->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Fritte>
     */
    public function getFritte(): Collection
    {
        return $this->fritte;
    }

    public function addFritte(Fritte $fritte): self
    {
        if (!$this->fritte->contains($fritte)) {
            $this->fritte[] = $fritte;
        }

        return $this;
    }

    public function removeFritte(Fritte $fritte): self
    {
        $this->fritte->removeElement($fritte);

        return $this;
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

}
