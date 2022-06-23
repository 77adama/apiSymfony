<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ComplementRepository::class)]
#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name:"nature", type:"string")]
#[ORM\DiscriminatorMap(["boisson"=>"Boisson","fritte" => "Fritte"])]
#[ApiResource]
class Complement extends Produit
{


    // #[ORM\Column(type: 'string', length: 255)]
    // protected $nature;



    // public function getNature(): ?string
    // {
    //     return $this->nature;
    // }

    // public function setNature(string $nature): self
    // {
    //     $this->nature = $nature;

    //     return $this;
    // }
}
