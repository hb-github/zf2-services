<?php

namespace Rest;

use Zend\Http\PhpEnvironment\Request;
use Zend\Http\Headers;
use Rest\Routes,
    Rest\Response;
use Rest\Helpers\SendRequests;

/**
 * Classe App - Inicialização das rotas e execução delas.
 * @author Francisco Ambrozio <francisco.ambrozio@telecontrol.com.br>
 */
class App {

    private $_request;
    private $_routes;
    private $_phlyty;
    
    /**
     * Construtor da Classe
     */
    public function __construct() {
        $this->_request = new Request();
        $this->_routes = Routes::getRoutes();
        $this->_phlyty = new \Phlyty\App;
        /* Tokens */
        \Phlyty\Route::allowMethod('HEAD');
        //$host = $this->_request->getServer('REMOTE_ADDR');
        //$this->isHostAllowed($host);
    }

    /**
     * run - Inicia o carregamento da Model e do Controller relacionados à rota
     */
    public function run() {
        $path = explode('/', $this->_request->getUri()->getPath());
        if ($this->_request->getUri()->getHost() == 'http://servicedb.kadabra.me') {
            $route = '/' . $path[2];
            define('API_PATH', '/');
        } else {
            $route = '/' . $path[1];
            define('API_PATH', '');
        }

        if (array_key_exists($route, $this->_routes)) {

            $config = $this->getConfig();
            define('API_DB', $config['api_db']);
            define('CONTROLLER', $this->_routes[$route]);

            $class_name = 'Rest\\Controller\\' . $this->_routes[$route];

            $phlyty = new \Phlyty\App;
            $load = new $class_name($phlyty);
            $allowed = (!empty($load->allowedMethods)) ? $load->allowedMethods : array('GET');

            $this->isAllowedMethod($allowed, $this->_request->getMethod());

            $load->run();
        } else {
            $response = new Response($this->_phlyty);
            $response->pageNotFound();
        }
    }

    /**
     * getConfig - Carrega o arquivo de configuração
     * @author Ricardo Vicente <ricardo.vicente@telecontrol.com.br>
     * @return mixed
     */
    public function getConfig() {
        $path = __DIR__ . '/../../config/autoload/';
        $include = (file_exists($path . 'local.php')) ? 'local' : 'global';
        return include $path . $include . '.php';
    }

    public function headerVerf($data) {
        $returnArray = array();
        foreach ($data as $value) {
            if ($this->_request->getHeader($value) === false) {
                $returnArray[] = $value;
            }
        }

        return $returnArray;
    }

    /**
     * isAllowedMethod - Verifica se método http é aceito pela classe
     * @param array $metodosPermitidos Array contendo GET, POST, PUT, DELETE, HEAD, etc...
     * @param string $metodoEnviado Método a ser validado
     * @return mixed
     */
    public function isAllowedMethod($metodosPermitidos, $metodoEnviado) {
        if (!in_array($metodoEnviado, $metodosPermitidos)) {
            $response = new Response($this->_phlyty);
            $response->set('statusNumber', 405)->processDataReturn('Allow: ' . implode('|', $metodosPermitidos));
            exit;
        }
        return;
    }

}
