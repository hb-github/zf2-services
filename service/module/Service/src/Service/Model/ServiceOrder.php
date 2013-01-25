<?php
/*
 * Model class to Filter Inputs provided in Login form
 */
namespace Service\Model;

use Zend\InputFilter\Factory as InputFactory;     // Import Input filter factory
use Zend\InputFilter\InputFilter;                 // Input Filter
use Zend\InputFilter\InputFilterAwareInterface;   // Add Input filter Aware Interface
use Zend\InputFilter\InputFilterInterface;        // Import Input filter Interface
use Zend\Validator\EmailAddress;                  // Validate Email address


// Class User Implements Input Filter Aware Interface ..
class ServiceOrder implements InputFilterAwareInterface
{
    // Email address
    public $customer_name;
    
    // Password for validation
    public $customer_email;
    
    public $customer_mobile;

    public $customer_phone;
    
    public $customer_address;
    
    public $product_description;
   
    public $product_voltage;
    
    public $product_serial_number;
    
    public $brand_name;
    
    public $reported_problem_description;
    
    public $buy_date;
    
    public $buy_store_name;
    
    public $buy_invoice_number;



    // Set Input Filter which required to validate all Inputs
    protected $inputFilter;    
    
    // Data Exchange Array .. to set Default values of data ..
    public function exchangeArray($data)
    {
       // $this->id     = (isset($data['id']))     ? $data['id']     : null;
      $this->customer_name = (isset($data['customer_name'])) ? $data['customer_name'] : null;
      $this->customer_email  = (isset($data['customer_email']))  ? $data['customer_email']  : null;
      $this->customer_mobile  = (isset($data['customer_mobile']))  ? $data['customer_mobile']  : null;
      
      $this->customer_phone  = (isset($data['customer_phone']))  ? $data['customer_phone']  : null;
      $this->customer_address  = (isset($data['customer_address']))  ? $data['customer_address']  : null;
      
      $this->product_description  = (isset($data['product_description']))  ? $data['product_description']  : null;
      
      $this->product_voltage  = (isset($data['product_voltage']))  ? $data['product_voltage']  : null;
      $this->product_serial_number  = (isset($data['product_serial_number']))  ? $data['product_serial_number']  : null;
      
      $this->brand_name  = (isset($data['brand_name']))  ? $data['brand_name']  : null;
      
      $this->reported_problem_description  = (isset($data['reported_problem_description']))  ? $data['reported_problem_description']  : null;
      $this->buy_date  = (isset($data['buy_date']))  ? $data['buy-date']  : null;
      $this->buy_store_name  = (isset($data['buy_store_name']))  ? $data['buy_store_name']  : null;
      
      $this->buy_invoice_number  = (isset($data['buy_invoice_number']))  ? $data['buy_invoice_number']  : null;
      
      
    }
    
    /*
     * Set input filter for the Current Form
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
    
    /*
     * Set validation criteria on the Input we received in post data.
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'customer_name',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'customer_email',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'emailAddress',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'customer_mobile',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'customer_phone',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 3,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'customer_address',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'product_description',
                'required' => true,
                
                'validators' => array(
                    
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'product_voltage',
                'required' => true,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'product_serial_number',
                'required' => false,
                
                'validators' => array(
                    array (
                        'allowEmpty' => false,
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 5,
                            'max'      => 255,
                        ),
                    ),
                ),
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'brand_name',
                'required' => false,
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'reported_problem_description',
                'required' => false,
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'buy_date',
                'required' => false,
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'buy_store_name',
                'required' => false,
            )));
            
            $inputFilter->add($factory->createInput(array(
                'name'     => 'buy_invoice_number',
                'required' => false,
            )));
            
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

