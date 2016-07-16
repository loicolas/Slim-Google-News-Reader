<?php

namespace App\Service;

use App\Model\UserInterface;
use SlimSession\Helper;
/**
 * Description of AuthService
 *
 * @author Loïc Colas <loicolas@gmail.com>
 */
class AuthService
{
    /**
     *
     * @var  Helper
     */
    protected $session;
    
    public function __construct(Helper $session)
    {
        $this->session = $session;
    }

    
    public function registerUser(UserInterface $user)
    {
        $this->session->set('user_id', $user->getId());
        $this->session->set('user_username', $user->getUsername());
        $this->session->set('user_email', $user->getUsername());
    }
    
    public function isLoggedIn(){
        $logged_in = false;
        if( $this->session->get('user_id') ){
            $logged_in = true;
        }
        
        return $logged_in;
    }
    
    public function logout(){
        $this->session->clear();
    }
    
    public function getUsername(){
        return $this->session->get('user_username');
    }
}
