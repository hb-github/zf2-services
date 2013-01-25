<?php
/**
 * Reponse monta e exibe a reponse da requisição
 * 
 * @author Francisco Ambrozio <francisco.ambrozio@telecontrol.com.br>
 * @version 2012-10-25
 */

namespace Rest;

/**
 * Classe Reponse, monta e exibe a reponse da requisição
 * 
 * @author Francisco Ambrozio <francisco.ambrozio@telecontrol.com.br>
 */
class Response 
{
    private $_app;
    public  $statusNumber;
    
    /**
     * Variáveis de erro da fábrica
     */
    CONST ERROR_CODE    = 'WARNING_PARAMETRO_%s';
    CONST ERROR_MESSAGE = 'Parametro %s não encontrado';
    
    /**
     * Construtor da Classe
     */
    public function __construct(\Phlyty\App $app)
    {
        $this->_app = $app;
    }
        
    /**
     * set - 
     * @param type $prop
     * @param type $value
     * @return \Rest\Response
     */
    public function set($prop, $value)
    {
        $this->$prop = $value;
        return $this;
    }
    
    /**
     * pageNotFound - Método para retorno de rota(página) não encontrada
     */
    public function pageNotFound()
    {
        $this->response(array('error' => 'Page not found.'), 404);
    }
    
    /**
     * forbidden - Método para retorno de acesso negado
     */
    public function forbidden()
    {
        $this->response(array('error' => 'Forbidden'), 403);
    }
    
    /**
     * invalid - Método para retorno de parâmetro inválido
     */
    public function invalid() 
    {
        $this->response(array('error' => 'Invalid parameter.'), 400);
    }
    
    /**
     * isHeaders - Verifica se os headers foram passados
     * @return mixed headers Headers a serem validados
     */
    public function isHeaders($header)
    {
        $headers = $this->_app->request()->getHeader($header);
        
        if( !$headers ){
            $return = array(sprintf(self::ERROR_CODE, strtoupper($header)), sprintf(self::ERROR_MESSAGE, $header));
            $this->response($return, 400);
            $this->_app->stop();
        }
        
        return $headers;
    }
    
    /**
     * processDataReturn - Processa o retorno de dados
     * @param array $return Saída que deverá ir para response
     * @param string $error_code Código de erro em caso de erro
     * @param string $error_message Mensagem de erro em caso de erro
     */
    public function processDataReturn($return)
    {
        $status = $this->statusNumber;    
        $this->response($return, $status);
    }

    /**
     * response - Monta a reponse da requisição
     * @param array $output Saída a ser exibida
     * @param int $status HTTP status code default 200
     * @param string $content_type Tipo do documento de resposta default JSON
     */
    public function response($output, $status = 200, $content_type = 'application/json')
    {
        $this->_app->response()->setStatusCode($status);
        $this->_app->response()->getHeaders()->addHeaderLine('Content-Type', $content_type);
        $this->_app->response()->setContent(json_encode($output));
//        $this->_app->response()->setContent($output);
        $this->_app->run();
    }
}