<?php

/*
 * User Controller class, which is useful to Authenticate Users & for User related data
 * 
 */
namespace Service\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Service\Form\ServiceOrderForm;
use Service\Model\ServiceOrder;    
use Zend\Authentication\AuthenticationService;
use Service\Helpers\SendRequests;
use Service\Helpers\RestRequest;
use Service\Helpers\User;
use Zend\Session\Container;
use Zend\Json\Json;


class ServiceOrderController extends AbstractActionController {
    
    /*
     * Default Index Action
     */ 
    public function indexAction() {
        
        // Authentication Service to authenticate user
        $auth = new AuthenticationService();
        
       // $userObj =  $sessionContainer->userObj;
        // check Whether user logged in or not
        if (is_object($userObj)) {
            return $this->redirect()->toUrl('/service_orders');
        } else {
            return $this->redirect()->toUrl('/user/login');
        }
     }
     
     
     function neworderAction() {
        
        $viewmodel = new ViewModel();
        $request = $this->getRequest();
        $response = $this->getResponse();
       
        //disable layout if request by Ajax
        $viewmodel->setTerminal(1);
        
        if ($request->isXmlHttpRequest()){
            if ($request->isPost()){
               $data = $this->getRequest()->getPost();
               $dataJson = json_encode($data);
               $dataObj = json_decode($dataJson);
               
               //$requestBody = jsonData
               $session = new \Zend\Session\Container('myAuth');
               $session->offsetExists('userObj');
               $userObj = $session->offsetGet('userObj');
                
               $newData = array("customer-name"=>$dataObj->customer_name);
               $jsonData = json_encode($newData);
               
               $header = array( 'Content-Type: application/json',                                                            'Content-Length: ' . strlen($jsonData),
                                'app-secret-token: abc123',
                                'user-token: '.$userObj->user_token,
                                'kdb-company-id: '.$userObj->kdb_company_id
                              );
               $url = "http://servicedb.kadabra.me/service-order";
               $verb = 'POST';
               /*
               $ch = curl_init($url);                                                                       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                             curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);                                             curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                              curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                       'Content-Type: application/json',                                                            'Content-Length: ' . strlen($jsonData),
                    'app-secret-token: abc123',
                    'user-token: '.$userObj->user_token,
                    'kdb-company-id: '.$userObj->kdb_company_id
                    )                                                                       
                 );                                                                                          
              $result = curl_exec($ch);
              print_r($result);exit;
               */
               
               $restRequest = new RestRequest($url, $verb, $jsonData,$header);
               $restRequest->execute();
               $responseObj = $restRequest->getResponseBody();
               echo $responseObj;
               exit;
               
               // return $responseObj;
            }
        }
        
        /*
        if ($request->isPost()) {
          /*  $new_note = new \StickyNotes\Model\Entity\StickyNote();
            if (!$note_id = $this->getStickyNotesTable()->saveStickyNote($new_note))
                $response->setContent(\Zend\Json\Json::encode(array('response' => false)));
            else {
                $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => $note_id)));
            }
           * 
         
            $response->setContent(\Zend\Json\Json::encode(array('response' => true, 'new_note_id' => 123)));
        }
        return $response;*/
        // echo "hi";exit;
     }
     
     /*
      * If user not logged in than we need to call this function
      */
     function newAction() {
         
        $message = null;
        $serviceForm = new ServiceOrderForm();
        
        if ($this->getRequest()->isPost()) {
            
            $serviceModel = new ServiceOrder();
            
            $serviceForm->setInputFilter($serviceForm->getInputFilter());
            
            $serviceForm->setData($this->getRequest()->getPost());
            
            if ($serviceForm->isValid()) {
               
               $data = $this->getRequest()->getPost();
               
               $dataJson = json_encode($data);
               $dataObj = json_decode($dataJson);
               
               $newData = array(
                   'customer-name' => $dataObj->customer_name, 
                   'customer-email' => $dataObj->customer_email,
                   'customer-phone' => $dataObj->customer_phone,
                   'customer-mobile' => $dataObj->customer_mobile,
                   'customer-address' => $dataObj->customer_address,
                   'product-description' => $dataObj->product_description, 
                   'product-voltage' => $dataObj->product_voltage,
                   'product-serial-number' => $dataObj->product_serial_number,
                   'brand-name' => $dataObj->brand_name,
                   'reported-problem-description'=>$dataObj->reported_problem_description,
                   'buy-date' => $dataObj->buy_date,
                   'buy-store-name' => $dataObj->buy_store_name,
                   'buy-invoice-number'=>$dataObj->buy_invoice_number
               );
               
               $jsonData = json_encode($newData);
               //$requestBody = jsonData
               $session = new \Zend\Session\Container('myAuth');
               $session->offsetExists('userObj');
               $userObj = $session->offsetGet('userObj');
               
               print_r($userObj);
               exit;
               
               $header = array( 'Content-Type: application/json',                                                            'Content-Length: ' . strlen($jsonData),
                                'app-secret-token: abc123',
                                'user-token: '.$userObj->user_token,
                                'kdb-company-id: '.$userObj->kdb_company_id
                              );
               $url = "http://servicedb.kadabra.me/service-order?".$dataObj->serviceOrderId;
               $verb = 'PUT';
               
               $restRequest = new RestRequest($url, $verb, $jsonData,$header);
               $restRequest->execute();
               $responseObj = $restRequest->getResponseBody();
               echo $responseObj;
               exit;
              
             // $restRequest = new RestRequest($url, $verb, $data_string);
             //  $restRequest->execute();
               
             //  $responseObj = json_decode($restRequest->getResponseBody());
             /* 
               if(!is_object($responseObj)) {
                  $view = new ViewModel(array(
                    'form' => $serviceForm,
                    'message' => "In valid Username & Password, Please try again !"
                ));
                return $view;
                
               } else {
                    $sessionContainer = new \Zend\Session\Container('myAuth');
                    $sessionContainer->userObj = $responseObj;
                    return $this->redirect()->toUrl('brands');
               }
             */               
               
            }
        } 
        $view = new ViewModel(array(
            'form' => $serviceForm,
            'message' => $message
                ));
            return $view;
    }
     
}
?>
