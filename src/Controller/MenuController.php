<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\FrittePortionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
// use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{

        public function __invoke(Request $request,ValidatorInterface $validator,
                         EntityManagerInterface $entityManager,BurgerRepository $burgerRep,
                         BoissonRepository $boissonRep,FrittePortionRepository $fritteRep,
                                 )
         {
            $content=json_decode( $request->getContent());
            if(!isset( $content->nom)){
                return  $this->json('Nom Obligatoire',400);
              }
              $menu=new Menu();
              $menu->setNom($content->nom);
              $prix=0;
              foreach($content->menuBurgers as $bur) {
                $burger=$burgerRep->find($bur->burger);
                if($burger){
                  $prix+=$burger->getPrix();
                  $menu->addBurger($burger,$bur->quantite);
                }
              }
              
              foreach($content->menuBoissons as $boi) {
                $boisson=$boissonRep->find($boi->boisson);
                if($boisson){
                  $prix+=$boisson->getPrix();
                  $menu->addBoisson($boisson,$boi->quantite);
                }
              }

              foreach($content->menuFrittes as $frit) {
                $fritte=$fritteRep->find($frit->fritte);
                if($fritte){
                  $prix+=$fritte->getPrix();
                  $menu->addFritte($fritte,$frit->quantite);
                }
              }

              $menu->setPrix($prix);
              $entityManager->persist($menu);
              $entityManager->flush();
              return  $this->json('Succes',201);
         }
    
    // public function __invoke(Request $request,ValidatorInterface $validator,
    // SerializerInterface $serializer,EntityManagerInterface $entityManager): JsonResponse
    // {

    //     $menu = $serializer->deserialize($request->getContent(), Menu::class,'json');
        
    //     $errors = $validator->validate($menu);
    //     if (count($errors) > 0) {
    //         $errorsString =$serializer->serialize($errors,"json");
    //        return new JsonResponse( $errorsString
    //        ,Response::HTTP_BAD_REQUEST,[],true);
    //        }
    //     // $menu->setUser($tokenStorage->getToken()->getUser());
    //     $entityManager->persist($menu);
    //     $entityManager->flush();
    //     $result =$serializer->serialize([
    //     'code'=>Response::HTTP_CREATED,
    //     'data'=>$menu
    //     ],"json",
    //     // [
    //     // "groups"=>["write_menu"]
    //     // ]
    // );
    // return new JsonResponse($result ,Response::HTTP_CREATED,[],true);
    // }
    // #[Route('/menu', name: 'app_menu')]
    // public function index(): Response
    // {
    //     return $this->render('menu/index.html.twig', [
    //         'controller_name' => 'MenuController',
    //     ]);
    // }
}
