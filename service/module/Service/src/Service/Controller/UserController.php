<?php

/*
 * User Controller class, which is useful to Authenticate Users & for User related data
 * 
 */
namespace Service\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Service\Form\LoginForm;
use Service\Model\User;    
use Zend\Authentication\AuthenticationService;
use Service\Helpers\SendRequests;
use Service\Helpers\RestRequest;
use Service\Helpers\DynamicTable;
use Zend\Session\Container;


class UserController extends AbstractActionController {
    
    /*
     * Default Index Action
     */ 
    public function indexAction() {
        
        // Authentication Service to authenticate user
        $auth = new AuthenticationService();
        
        // check Whether user logged in or not
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            return $this->redirect()->toUrl('brands');
        } else {
            return $this->redirect()->toUrl('user/login');
        }
     }
     
     /*
      * If user not logged in than we need to call this function
      */
     function loginAction() {
         
        $message = null;
        $loginForm = new LoginForm();
        
        if ($this->getRequest()->isPost()) {
            
            $userModel = new User();
            
            $loginForm->setInputFilter($userModel->getInputFilter());
            $loginForm->setData($this->getRequest()->getPost());
            
            if ($loginForm->isValid()) {
               $data = $this->getRequest()->getPost();
               
               $dataJson = json_encode($data);
               $dataObj = json_decode($dataJson);
               $url = "http://servicedb.kadabra.me/login";
               $verb = 'POST';
               $data = array("email" => $dataObj->email, "password" => $dataObj->password);                  $data_string = json_encode($data);                                                            /*
               $ch = curl_init($url);                                                                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                              curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                               curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                       'Content-Type: application/json',                                                             'Content-Length: ' . strlen($data_string),
                   'app-secret-token: abc123'
                    )                                                                       
                 );                                                                                          
              $result = curl_exec($ch);
              print_r($result);exit;
               */ 
               
                    
               $restRequest = new RestRequest($url, $verb, $data_string);
               $restRequest->execute();
               
               // REMOVE EXISTING SESSION DATA
               unset($_SESSION['myAuth']);
               
               $responseObj = json_decode($restRequest->getResponseBody());
              
               if(!is_object($responseObj)) {
                  $view = new ViewModel(array(
                    'form' => $loginForm,
                    'message' => "In valid Username & Password, Please try again !"
                ));
                return $view;
                
               } else {
                    
                    
                    // CREATE NEW SESSION CONTAINER NOW ..
                    $sessionContainer = new \Zend\Session\Container('myAuth');
                    $sessionContainer->offsetSet('userObj', $responseObj);
                    return $this->redirect()->toUrl('/service_orders/new');
               }
                            
               
            }
        } 
        
       // $this->layout()->disableLayout();
        
        $view = new ViewModel(array(
            'form' => $loginForm,
            'message' => $message
                ));
        //$this->getLocator()->get('view')->layout()->setLayout('layout/login.phtml');
        $this->layout('layout/login');
       // $view->setTemplate('layout/login');
        
        return $view;
    }
     
}
?>
