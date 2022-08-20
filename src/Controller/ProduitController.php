<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;

class ProduitController extends AbstractController
{
    
    public function __invoke(Request $request,
    ValidatorInterface $validator,
    TokenStorageInterface $tokenStorage,
    SerializerInterface $serializer,
    EntityManagerInterface $entityManager): JsonResponse
    {
        
        $produit = $serializer->deserialize($request->getContent(),
    Produit::class,'json');
    $errors = $validator->validate($produit);
    if (count($errors) > 0) {
     $errorsString =$serializer->serialize($errors,"json");
    return new JsonResponse( $errorsString
    ,Response::HTTP_BAD_REQUEST,[],true);
    }
    dd($tokenStorage->getToken());
    $produit->setUser($tokenStorage->getToken()->getUser());
    $entityManager->persist($produit);
    $entityManager->flush();
    $result =$serializer->serialize([
    'code'=>Response::HTTP_CREATED,
    'data'=>$produit
    ],"json",[
    "groups"=>["produit:read:all"]
    ]);
    return new JsonResponse($result ,Response::HTTP_CREATED,[],true);
    } 

    // #[Route('/produit', name: 'app_produit')]
    // public function index(): Response
    // {
    //     return $this->render('produit/index.html.twig', [
    //         'controller_name' => 'ProduitController',
    //     ]);
    // }
}
