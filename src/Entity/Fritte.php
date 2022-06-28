<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FritteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FritteRepository::class)]
#[ApiResource(
    collectionOperations:[

        "post" => [
            'denormalization_context' => ['groups' => ['write_fritte']],
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
                'normalization_context' => ['groups' => ['fritte:read:simple']],
                ]]
)]
class Fritte extends Complement
{

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'fritte')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
    }

    // #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(["fritte:read:simple","write_fritte"])]
    // private $diff_frit;

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
            $menu->addFritte($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeFritte($this);
        }

        return $this;
    }


}
