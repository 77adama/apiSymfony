<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FritteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FritteRepository::class)]
#[ApiResource]
class Fritte extends Complement
{
    // #[ORM\Column(type: 'string', length: 255)]
    // private $portion;

    // public function getPortion(): ?string
    // {
    //     return $this->portion;
    // }

    // public function setPortion(string $portion): self
    // {
    //     $this->portion = $portion;

    //     return $this;
    // }
}
