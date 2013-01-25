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
class User implements InputFilterAwareInterface
{
    // Email address
    public $email;
    
    // Password for validation
    public $password;
    
    // Set Input Filter which required to validate all Inputs
    protected $inputFilter;    
    
    // Data Exchange Array .. to set Default values of data ..
    public function exchangeArray($data)
    {
       // $this->id     = (isset($data['id']))     ? $data['id']     : null;
        $this->email = (isset($data['email'])) ? $data['email'] : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
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
                'name'     => 'email',
                'required' => true,
                
                'validators' => array(
                    array (
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
                'name'	=> 'password',
                'required' => true,
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

