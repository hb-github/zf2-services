<?php

namespace Service\Form;

use Zend\Form\Form;

class ServiceOrderForm extends Form {

    public function __construct($name = null) {
        parent::__construct('service-order');
        $this->setAttribute('method', 'post');
               
        $this->add(array(
            'name' => 'customer_name',
            
            'attributes' => array(
                'type' => 'text',
                'id' => 'customer_name',
                'style' => 'float:left',
                
            ),
            'options' => array(
                'label' => 'Customer Name',
                'attributes' => array(
                    'style' => 'float:left;width:100px;',
                ),
            )
                )
        );
         $this->add(array(
                'name' => 'customer_email',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Customer Email'
                )
            )
        );
        $this->add(array(
                'name' => 'customer_mobile',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Customer Mobile'
                )
            )
        );
        $this->add(array(
                'name' => 'customer_phone',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Customer Phone'
                )
            )
        );
        $this->add(array(
                'name' => 'customer_address',
                'attributes' => array(
                    'type' => 'textarea'
                ),
                'options' => array(
                    'label' => 'Customer Address'
                )
            )
        );
        
        $this->add(array(
                'name' => 'product_description',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Product Description'
                )
            )
        );
        $this->add(array(
                'name' => 'product_voltage',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Product Voltage'
                )
            )
        );
        $this->add(array(
                'name' => 'product_serial_number',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Product Serial Number'
                )
            )
        );
        $this->add(array(
                'name' => 'brand_name',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Brand Name'
                )
            )
        );
        
        $this->add(array(
                'name' => 'reported_problem_description',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Reported Problem'
                )
            )
        );
        
        $this->add(array(
                'name' => 'buy_date',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Buy Date'
                )
            )
        );
        
        $this->add(array(
                'name' => 'buy_store_name',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Buy Store Name'
                )
            )
        );
        
        $this->add(array(
                'name' => 'buy_invoice_number',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Buy Invoice Number'
                )
            )
        );
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Gravar'
                )
            )
        );
    }

}
?>
