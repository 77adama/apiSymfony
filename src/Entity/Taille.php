<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource]
class Taille
{
    #[ORM\Id]
    
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["catalogue:read:all","menu:read:one","write_boissons"])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["catalogue:read:all","menu:read:one","boisson:read:all"])]
    private $libelle;




   

    #[ORM\Column(type: 'integer')]
    #[Groups(["catalogue:read:all","menu:read:one","boisson:read:all"])]
    private $prix;

    #[ORM\ManyToMany(targetEntity: Boisson::class, mappedBy: 'tailles')]
    private $boissons;

    #[ORM\Column(type: 'integer')]
    #[Groups(["catalogue:read:all","menu:read:one","boisson:read:all"])]
    private $quantite;

   


    public function __construct()
    {
     
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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



    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
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
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        $this->boissons->removeElement($boisson);

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
