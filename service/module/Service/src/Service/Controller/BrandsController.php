<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonService for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Service\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Service\Form\BrandsForm;
use Service\Model\Brands;    
use Service\Helpers\SendRequests;
use Service\Helpers\DynamicTable;

class BrandsController extends AbstractActionController {

    public function indexAction() {
       
        $sendRequest = new SendRequests;
        $tableGrid = new DynamicTable();
	
        $prop = array(
            'customRequest' => 'GET',
            'headerInformation' => array('environment: development', 'token_secret: abc')
        );


        $returnRequest = $sendRequest->set($prop)->requests('http://service-api/brands');
//        print_r($returnRequest['return']);exit;
        
        $returnData = json_decode($returnRequest['return'],true);
        
//        var_dump ($returnData); exit;

        
        $tableGrid->tableArray = $returnData['result'];
        
        
        $dynamicTable = $tableGrid->tableGenerate();
        
        $view = new ViewModel(array(
                    'table' => $dynamicTable
                ));
        

        return $view;
    }

    public function addAction() {

        $message = null;
        $form = new BrandsForm();
        if ($this->getRequest()->isPost()) {
            
            $model = new Brands();
            
            $form->setInputFilter($model->getInputFilter());
            $form->setData($this->getRequest()->getPost());
            
            if ($form->isValid()) {
                $sendRequest = new SendRequests;

                $prop = array(
                    'customRequest' => 'POST',
                    'postInformation' => $_POST,
                    'headerInformation' => array('environment: development', 'token_secret: abc')
                );

                $returnRequest = $sendRequest->set($prop)->requests('http://service-api/brands');

                if ($returnRequest['headerInformation'] == 400) {
                    $message = '<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Aviso!</strong> Você deve colocar algo no campo BRANDS!
    </div>';
                } elseif ($returnRequest['headerInformation'] == 200) {
                    $message = '<div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Aviso!</strong> Cadastro inserido com sucesso!
    </div>';
                }
            }      
        }
        
        $view = new ViewModel(array(
            'form' => $form,
            'message' => $message
                ));

        return $view;
    }

}
