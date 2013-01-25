<?php

namespace Service\Form;

use Zend\Form\Form;



class BrandsForm extends Form {

    public function __construct($name = null) {
        parent::__construct('brands');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'brand',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Brand Name'
            )
                )
        );
        
         $this->add(array(
                'name' => 'description',
                'attributes' => array(
                    'type' => 'text'
                ),
                'options' => array(
                    'label' => 'Descriptions'
                )
            )
        );
         
        $this->add(array(
                'name' => 'telecontrol_id',
                'attributes' => array(
                        'type' => 'text'
                ),
                'options' => array(
                        'label' => 'Telecontrol Id'
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