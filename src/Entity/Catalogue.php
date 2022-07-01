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
        ]
        ],
    itemOperations:[]
)]
class Catalogue 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    // #[Groups(["produit:read:simple","produit:read:all"])]
    private $id;
}
