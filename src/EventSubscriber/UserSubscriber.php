<?php

namespace App\EventSubscriber;

use App\Entity\Zone;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\Quartier;
use Doctrine\ORM\Events;
use App\Entity\Livraison;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
            private ?TokenInterface $token;
        public function __construct(TokenStorageInterface $tokenStorage)
        {
        $this->token = $tokenStorage->getToken();
        //getSubscribedEvents c'est l'ecouteur evennement
        }public static function getSubscribedEvents(): array
        {
        return [
        Events::prePersist,
        ];
        }
        private function getUser()
        {
        //dd($this->token);
        if (null === $token = $this->token) {
        return null;
        }
        if (!is_object($user = $token->getUser())) {
        // e.g. anonymous authentication
        return null;
        }
        return $user;
        }
        public function prePersist(LifecycleEventArgs $args)
        {
        if ($args->getObject() instanceof Produit or $args->getObject() instanceof Zone
        or $args->getObject() instanceof Quartier) {
        $args->getObject()->setGestionnaire($this->getUser());
        }
        
        if($args->getObject() instanceof Livraison) {
            $args->getObject()->setLivreur($this->getUser());
        }
        }
}
