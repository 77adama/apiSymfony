<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;


// #[ApiResource(
//     collectionOperations: [
//         "catalogue" => [
//             'method' => 'GET',
//             'path' => '/catalogue',
//         ]
//     ]
// )]
#[ApiResource(
    collectionOperations:[
        'GET' => [
            'path' => '/catalogues',
            'normalization_context' => ['groups' => ['catalogue:read:all']],
        ]
        ],
    itemOperations:[
        'get' => [
            
            'normalization_context' => ['groups' => ['catalogue:read:one']],
        ]
    ]
)]
class Catalogue 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:read:all","produit:read:all"])]
    private $id;
}
