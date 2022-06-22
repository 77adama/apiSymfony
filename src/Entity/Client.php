<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 *
 * @ApiResource
 */
class Client extends User
{


    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
}
