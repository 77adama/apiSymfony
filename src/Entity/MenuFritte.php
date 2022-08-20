<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuFritteRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuFritteRepository::class)]
class MenuFritte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuFrittes')]
    #[Groups(["menu:read:all","write_menu"])]
    private $menu;

    #[ORM\ManyToOne(targetEntity: FrittePortion::class, inversedBy: 'menuFrittes')]
    #[Groups(["menu:read:all","write_menu","catalogue:read:all",
    "menu:read:one","commande:read:all","client-reed-one"])]
    private $fritte;

    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:read:all","write_menu","catalogue:read:all",
    "menu:read:one"])]
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
