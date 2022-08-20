<?php
namespace App\DataPersister;

use App\Entity\Livraison;
use App\Entity\Livreur;
use Doctrine\ORM\EntityManagerInterface;

class PersisterLivraison implements ContextAwareDataPersisterInterface
{

    protected $entityManager;

    // public function __construct(EntityManagerInterface $entityManager)
    // {
    //     $this->entityManager = $entityManager;
    // }


    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return  $data instanceof Livraison;
    }

     /**
     * @param Livraison $data 
     */
    public function persist($data, array $context = [])
    {

        if ($data instanceof Livraison) {
            $tr=$data->getLivreur();
            dd($tr);
        }

            
        // $this->entityManager->persist($data);
        // // $tr->setEtatLiv('occupé');
        // // $this->entityManager->persist($tr);
        //     $this->entityManager->flush();
           
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