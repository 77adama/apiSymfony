<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[

        "post" => [
            'denormalization_context' => ['groups' => ['write_boisson']],
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
                'normalization_context' => ['groups' => ['boisson:read:simple']],
                ]]
)]
class Boisson  extends Produit
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write_boisson","boisson:read:simple","menu:read:simple"])]
    private $taille;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'boisson')]
    private $menu;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: Menu::class)]
    private $menus;


    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }






    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
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
            $menu->setBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            // set the owning side to null (unless already changed)
            if ($menu->getBoisson() === $this) {
                $menu->setBoisson(null);
            }
        }

        return $this;
    }

   

}
