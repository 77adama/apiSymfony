<?php
namespace App\DataProvider;

use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\ProduitRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;


class CatalogueProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface {

    public function __Construct(ProduitRepository $produitRepository, MenuRepository $menuRepository,BurgerRepository $burgerRepository)
     {
        $this->produitRepository = $produitRepository;
        $this->menuRepository = $menuRepository;
        $this->burgerRepository = $burgerRepository;
     }

     /**
     * {@inheritdoc}
     */
     public function getCollection(string $ressourceClass, string $operationName=null, array $context=[]){
      $catalogue=[];
      $catalogue['menu'] = $this->menuRepository->findAll();
      $catalogue['burger'] = $this->burgerRepository->findAll();
        return $catalogue;
     }

     public function supports(string $ressourceClass, string $operationName=null, array $context=[]): bool{
        return $ressourceClass == Catalogue::class;
      
     }
}