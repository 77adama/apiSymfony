<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
/**
 *
 * @ApiResource
 */
#[ApiResource(
    collectionOperations:[
        "get",
        "post" => [
       
        'denormalization_context' => ['groups' => ['write_']],
        ]
        ],
        
)]
class Client extends User
{


    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write_"])]
    private $telephone;

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
