<?php

namespace Service\Helpers;

/**
 * Classe SendRequests
 * @author 
 */
class SendRequests
{
    public $customRequest     = null;
    public $headerInformation = null;
    public $postInformation   = array('');
    
    /**
     * set - 
     * @param array $prop Array de dados
     * @param mixed $value Valores mistos
     * @return \Rest\Helpers\SendRequests
     */
    public function set($prop, $value = null)
    {
        if( is_array($prop) ){
            foreach( $prop as $key => $propValue ){
                $this->$key = $propValue;
            }
        }else{
            $this->$prop = $value;   
        }
        
        return $this;
    }
    
    /**
     * requests - 
     * @param string $url String
     * @return mixed
     */
    public function requests($url = null)
    {
        $string_informations = null;
        
        // surfing in array      
        foreach( $this->postInformation as $name => $value ){
            $string_informations .= $name.'='.$value.'&';
        }
        
        rtrim($string_informations, '&');
        $ch = \curl_init();
        
        // config curl options
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->customRequest);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        
        if( !empty($this->headerInformation) ){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headerInformation);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // recall requisition return
        
        // curl_setopt($ch, CURLOPT_HEADER, 1);
        if( !empty($this->postInformation) ){
            curl_setopt($ch, CURLOPT_POST, count($this->postInformation));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $string_informations);
        }
        
        // send post requisition
        $exeCurl     = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // send verification
        if( $this->customRequest == 'HEAD' ){
            $return["return"]            = true;
            $return["headerInformation"] = $header_size;
        }elseif( !$exeCurl ){
            $return["return"]            = false;
            $return["errorMessage"]      = "The server don't receive a Response / SendRequests";
        }else{
            $return["return"]            = $exeCurl;
            $return["headerInformation"] = $header_size;
        }
        
        curl_close($ch); // close the curl protocol
        return $return;
    }
}