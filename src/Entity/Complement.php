<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;


// #[ORM\Entity(repositoryClass: ComplementRepository::class)]
// #[ORM\InheritanceType("JOINED")]
// #[ORM\DiscriminatorColumn(name:"type", type:"string")]
// #[ORM\DiscriminatorMap(["boisson"=>"Boisson","fritte" => "Fritte"])]
#[ApiResource]
class Complement 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(["produit:read:simple","produit:read:all"])]
    private $id;

}
