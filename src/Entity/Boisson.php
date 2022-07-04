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
            "get" => [
            //     'normalization_context' => ['groups' => ['produit:read:all']],
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
                'normalization_context' => ['groups' => ['boisson:read:simple']],
                ]]
)]
class Boisson  extends Produit
{


    // #[ORM\Column(type: 'string', length: 255)]
    // #[Groups(["write_boisson","boisson:read:simple","menu:read:simple"])]
    // private $taille;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'boisson')]
    private $menus;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;


    public function __construct()
    {
        $this->menus = new ArrayCollection();
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
            $menu->addBoisson($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removeBoisson($this);
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

}
