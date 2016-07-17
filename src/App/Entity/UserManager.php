<?php

namespace App\Entity;

use Doctrine\ORM\EntityManager;
use App\Entity\{User,UserFeedPreference};

/**
 * Description of UserManager
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class UserManager
{
    CONST ENTITY_USER_NAMESPACE = 'App\Entity\User';
    CONST ENTITY_USER_FEED_PREFERENCE_NAMESPACE = 'App\Entity\UserFeedPreference';
    
    /**
     *
     * @var EntityManager
     */
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
    
    
    /**
     * retrieve user in database from id
     * 
     * @param int $id
     * @return User
     */
    public function getById( int $id ){
        return  $this->em->getRepository(self::ENTITY_USER_NAMESPACE)->findOneBy(['id' => $id]);
    }
    
    /**
     * Register user preferences
     * 
     * @param User $user
     * @param array $preferences
     * @param User
     */
    public function setPreferences( User $user, array $preferences ){
        
        // clean up current preferences
        foreach( $user->getPreferences() as $userPreference ){
            $user->removePreference($userPreference);  
            $this->em->remove($userPreference);
        }        
        $this->em->flush();
        
        // set new preferences from parameters
        foreach( $preferences as $feed => $active ){
            $userPreference = new UserFeedPreference();
            $userPreference->setUser($user)
                            ->setFeed($feed)
                            ->setActive($active);
            
            $user->addPreference( $userPreference );
        }
        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }
}
