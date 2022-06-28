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
            // 'denormalization_context' => ['groups' => ['write_boisson']],
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
class Boisson  extends  Complement
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write_boisson","boisson:read:simple"])]
    private $taille;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'boissons')]
    private $menu;

    public function __construct()
    {
        $this->menu = new ArrayCollection();
    }



    // #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'boisson')]
    // private $menu;




    public function getTaille(): ?string
    {
        return $this->taille;
    }

    public function setTaille(string $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    // public function getMenu(): ?Menu
    // {
    //     return $this->menu;
    // }

    // public function setMenu(?Menu $menu): self
    // {
    //     $this->menu = $menu;

    //     return $this;
    // }

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
