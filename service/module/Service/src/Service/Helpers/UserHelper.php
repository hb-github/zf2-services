<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Service\Helpers;

use Zend\Session\Container;
    
class User
{
   
    public function isLoggedIn() {
        $session = new \Zend\Session\Container('myAuth');
        $session->offsetExists('userObj');
        $userObj = $session->offsetGet('userObj');
        if(!isset($userObj) || $userObj->user_token == '') {
            return $this->redirect()->toUrl('/user/login');
        }
        return true;
    }
    
}
?>
