<?php

namespace App\Entity;

use App\Repository\MenuFritteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuFritteRepository::class)]
class MenuFritte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrittes')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: FrittePortion::class, inversedBy: 'menuFrittes')]
    private $fritte;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getFritte(): ?FrittePortion
    {
        return $this->fritte;
    }

    public function setFritte(?FrittePortion $fritte): self
    {
        $this->fritte = $fritte;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }
}
