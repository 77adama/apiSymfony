<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\User;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\FrittePortion;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

/**
 *
 */
class PersisterProduit implements ContextAwareDataPersisterInterface
{
    protected $entityManager;
    protected $encoder;
    protected $prix=0;
    

    public function __construct(
        EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
           
        
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }

    /**
     * @param Produit $data 
     */
    public function persist($data, array $context = [])
    {
        if ($data instanceof Boisson or $data instanceof FrittePortion) {
           $data->setPrix(0);
        }elseif ($data instanceof Menu ) {
           foreach ($data->getBurger() as $burger) {
            $this->prix+=$burger->getPrix();
           }
          

           foreach ($data->getFrittePortions() as $frittePortions) {
               $this->prix+=$frittePortions->getPrix();
            }
            foreach ($data->getBoisson() as $boisson) {
                 $this->prix+=$boisson->getPrix();
            }
            $this->prix-=$this->prix*0.05;
           $data->setPrix($this->prix);
        }
       
           
            $this->entityManager->persist($data);
            $this->entityManager->flush();
           
        

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}