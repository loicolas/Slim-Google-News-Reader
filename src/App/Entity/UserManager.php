<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use App\Entity\User;

/**
 * Description of UserManager
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class UserManager
{
    CONST ENTITY_USER_NAMESPACE = 'App\Entity\User';
    
    private $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }
    
    
   /**
    * authenticate a user by email and password. Return the user or null
    * 
    * @param string $email
    * @param string $password
    * @return User
    */
    public function authenticate(string $email, string $password )
    {
        $user = null;
        
        $entity = $this->em->getRepository(self::ENTITY_USER_NAMESPACE)->findOneBy(['email' => $email]);
        
        if( $entity && password_verify($password, $entity->getPassword()) ){
            $user = $entity;
        }
        
        return $user;
    }
}
