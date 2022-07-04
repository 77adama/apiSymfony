<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivreurRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
/**
 * @ORM\Entity(repositoryClass="App\Repository\LivreurRepository")
 *
 * @ApiResource
 */
class Livreur extends User
{


    #[ORM\Column(type: 'string', length: 255)]
    private $matricule;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'livreur')]
    private $livraison;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }


}
