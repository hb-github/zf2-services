<?php

namespace Service\Helpers;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class RestRequest
{
	protected $url;
	protected $verb;
	protected $requestBody;
	protected $requestLength;
	protected $username = '';
	protected $password = '';
	protected $acceptType;
	protected $responseBody;
	protected $responseInfo;
	
        public    $requestHeader;
        
	public function __construct ($url = null, $verb = 'POST', $requestBody = null,$requestHeader=null)
	{
		$this->url                      = $url;
		$this->verb                     = $verb;
		$this->requestBody		= $requestBody;
		$this->requestLength            = 0;
		$this->username			= '';
		$this->password			= '';
		$this->acceptType		= 'application/json';
		$this->responseBody		= null;
		$this->responseInfo		= null;
                $this->requestHeader            = $requestHeader;
		
		/*if ($this->requestBody !== null)
		{
			$this->buildPostBody();
		}*/
	}
	
	public function flush ()
	{
		$this->requestBody		= null;
		$this->requestLength            = 0;
		$this->verb			= 'POST';
		$this->responseBody		= null;
		$this->responseInfo		= null;
                $this->requestHeader            = null;
	}
	
	public function execute ()
	{
		$ch = curl_init();
		$this->setAuth($ch);
		
		try
		{
			switch (strtoupper($this->verb))
			{
				case 'GET':
					$this->executeGet($ch);
					break;
				case 'POST':
					$this->executePost($ch);
					break;
				case 'PUT':
					$this->executePut($ch);
					break;
				case 'DELETE':
					$this->executeDelete($ch);
					break;
				default:
					throw new InvalidArgumentException('Current verb (' . $this->verb . ') is an invalid REST verb.');
			}
		}
		catch (InvalidArgumentException $e)
		{
			curl_close($ch);
			throw $e;
		}
		catch (Exception $e)
		{
			curl_close($ch);
			throw $e;
		}
		
	}
	
	public function buildPostBody ($data = null)
	{
		$data = ($data !== null) ? $data : $this->requestBody;
		
                // $data = http_build_query($data, '', '&');
		$this->requestBody = $data;
	}
	
	protected function executeGet ($ch)
	{		
		$this->doExecute($ch);	
	}
	
	protected function executePost ($ch)
	{
		
                if (!is_string($this->requestBody))
		{
			$this->buildPostBody();
		}
                $this->requestLength = strlen($this->requestBody);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		$this->doExecute($ch);	
	}
	
	protected function executePut ($ch)
	{
		if (!is_string($this->requestBody))
		{
			$this->buildPostBody();
		}
		
		$this->requestLength = strlen($this->requestBody);
		
		$fh = fopen('php://memory', 'rw');
		fwrite($fh, $this->requestBody);
		rewind($fh);
		
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, $this->requestLength);
		curl_setopt($ch, CURLOPT_PUT, true);
		
		$this->doExecute($ch);
		
		fclose($fh);
	}
	
	protected function executeDelete ($ch)
	{
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
		
		$this->doExecute($ch);
	}
	
	protected function doExecute (&$curlHandle)
	{
            $ch = curl_init($this->url);
            
            if(isset($this->requestHeader)) {
                $header = $this->requestHeader;
            } else {
                $header = array(                                                       'Content-Type: application/json',                                                            'Content-Length: ' . strlen($this->requestBody),
                               'app-secret-token: abc123'
                        );
            }
            if($this->verb == 'POST') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->verb);     
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->requestBody); 
            } else if($this->verb == 'PUT') {
                
            }
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);        
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            
            $this->responseBody     = curl_exec($ch);
            $this->responseInfo	= curl_getinfo($ch);
            curl_close($ch);
	}
	
	protected function setCurlOpts (&$curlHandle)
	{
		               
		curl_setopt($curlHandle, CURLOPT_URL, $this->url);
		curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curlHandle, CURLOPT_HTTPHEADER, array(                                                       'Content-Type: application/json',                                                            'Content-Length: ' . $this->requestLength,
                             'app-secret-token: abc123'
                    )                                                                       
                );
                
	}
	
	protected function setAuth (&$curlHandle)
	{
		if ($this->username !== null && $this->password !== null)
		{
			curl_setopt($curlHandle, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
			curl_setopt($curlHandle, CURLOPT_USERPWD, $this->username . ':' . $this->password);
		}
	}
	
	public function getAcceptType ()
	{
		return $this->acceptType;
	} 
	
	public function setAcceptType ($acceptType)
	{
		$this->acceptType = $acceptType;
	} 
	
	public function getPassword ()
	{
		return $this->password;
	} 
	
	public function setPassword ($password)
	{
		$this->password = $password;
	} 
	
	public function getResponseBody ()
	{
		return $this->responseBody;
	} 
	
	public function getResponseInfo ()
	{
		return $this->responseInfo;
	} 
	
	public function getUrl ()
	{
		return $this->url;
	} 
	
	public function setUrl ($url)
	{
		$this->url = $url;
	} 
	
	public function getUsername ()
	{
		return $this->username;
	} 
	
	public function setUsername ($username)
	{
		$this->username = $username;
	} 
	
	public function getVerb ()
	{
		return $this->verb;
	} 
	
	public function setVerb ($verb)
	{
		$this->verb = $verb;
	} 
        
        
}
?>
