<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Burger;
use App\Entity\Boisson;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Livraison;
use App\Entity\FrittePortion;
use App\Entity\LigneCommande;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class PersisterCommande implements ContextAwareDataPersisterInterface
{
    protected $entityManager;
    protected $prix=0;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande or $data instanceof Livraison;
    }


    /**
     * @param Commande $data 
     */
    public function persist($data, array $context = [])
    {

        // if ($data instanceof Livraison) {
        //     $tr=$data->getLivreur();
        // }

            foreach ($data->getLigneCommande() as $ligneCommande) {
           
          
            
            }   
        $this->entityManager->persist($data);
        // $tr->setEtatLiv('occupé');
        // $this->entityManager->persist($tr);
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