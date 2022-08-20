<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuBoissonRepository::class)]
class MenuBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBoissons')]
    #[Groups(["menu:read:all"])]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'menuBoissons')]
    #[Groups(["menu:read:all","write_menu","catalogue:read:all",
    "menu:read:one","commande:read:all","client-reed-one"])]
    private $boisson;

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

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

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
