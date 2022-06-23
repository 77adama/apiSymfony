<?php
// src/DataPersister/UserDataPersister.php

namespace App\DataPersister;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 *
 */
class UserDataPersister implements ContextAwareDataPersisterInterface
{
    protected $entityManager;
    protected $encoder;
    

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $encoder) {
        $this->entityManager = $entityManager;
        $this->encoder = $encoder;
       
        
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if ($data->getPlainPassword()) {
           $password = $this->encoder->hashPassword( $data,$data->getPlainPassword());
           $data->setPassword($password);
           $data->eraseCredentials();
            $this->entityManager->persist($data);
            $this->entityManager->flush();
        }

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