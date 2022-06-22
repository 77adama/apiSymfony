<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GestionnaireRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
/**
 * @ORM\Entity(repositoryClass="App\Repository\GestionnaireRepository")
 *
 * @ApiResource
 */
class Gestionnaire extends User
{


    public function getId(): ?int
    {
        return $this->id;
    }
}
