<?php

namespace Rest\Controller;

use Rest\Helpers\SendRequests;
use Rest\Response;

/**
 * Class Controller\Brands em Service-API
 * @author Bruno Kawakami <bruno.kawakami@telecontrol.com.br>
 */
class Brands {

    private $_phlyty;
    private $_response;
    
    /**
     * Metodos permitidos para esta classe, e public porque e usado na \App.php
     */
    public $allowedMethods = array('GET', 'POST', 'PUT', 'DELETE');

    /**
     * Construtor da Classe
     * @param \Phlyty\App $phlyty
     */
    public function __construct(\Phlyty\App $phlyty) {

        $this->_phlyty = $phlyty;
        $this->_response = new Response($this->_phlyty);
    }

    /**
     * run - Classe Controller Brands em Service-API
     */
    public function run() {        
        
        $this->_phlyty->get(API_PATH . '/brands', function() {

                    $curlArray = array(
                        'headerInformation' => array(
                            'token_secret: ' . 'abc',
                            'environment: '  . 'development' 
                        ),
                        'customRequest' => 'GET'
                    );

                    $sendRequisitions = new SendRequests();
                    
                    $response = $sendRequisitions->set($curlArray)->requests(API_DB . '/brands');
                    
//                    var_dump ($responseData);exit;
                    
                    $response['headerInformation'] = (empty($response['headerInformation'])) ? null : $response['headerInformation'];
                    $this->_response->set('statusNumber', $response['headerInformation'])
                            ->processDataReturn(json_decode($response['return']));
                });

         $this->_phlyty->post(API_PATH . '/brands', function() {

                    $requestPost = $this->_phlyty->request()->getPost()->toArray();
                    $curlArray = array(
                        'customRequest' => 'POST',
                        'postInformation' => $requestPost
                    );

                    $classRegras = "\\Regras\\" . CONTROLLER;
                    $regras = new $classRegras($this->_phlyty);
                    $regras->validatePost($requestPost);

                    $sendRequisitions = new SendRequests();
                    $response = $sendRequisitions->set($curlArray)->requests(API_DB . '/brands');
                    $response['headerInformation'] = (empty($response['headerInformation'])) ? null : $response['headerInformation'];
                    $this->_response->set('statusNumber', $response['headerInformation'])
                            ->processDataReturn($response['return']);

                    $requestPost = $this->_phlyty->request()->getPost()->toArray();
                    $curlArray = array(
                        'customRequest' => 'POST',
                        'postInformation' => $requestPost
                    );

                    $classRegras = "\\Regras\\" . CONTROLLER;
                    $regras = new $classRegras($this->_phlyty);
                    $regras->validatePost($requestPost);

                    $sendRequisitions = new SendRequests();
                    $response = $sendRequisitions->set($curlArray)->requests(API_DB . '/brands');
                    $response['headerInformation'] = (empty($response['headerInformation'])) ? null : $response['headerInformation'];
                    $this->_response->set('statusNumber', $response['headerInformation'])
                            ->processDataReturn($response['return']);
                });



        $this->_phlyty->run();
    }

}
