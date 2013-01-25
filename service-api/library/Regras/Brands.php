<?php

namespace Regras;

use Rest\Response;

/**
 * Brands
 * 
 * Classe para validação de Brands
 * 
 * @author Bruno Kawakami <bruno.kawakami@telecontrol.com.br>
 * @version 2012-11-12
 */
class Brands extends Regras implements InterfaceRegras {

    private $_app;

    /**
     * As validacoes comuns a todas fabricas ficarao no __construct
     * @param array $data
     * @param \Phlyty\App $app
     */
    public function __construct(\Phlyty\App $app) {

        $this->_app = $app;
    }

    public function validatePost($data) {

        $generalFields = array(
            'brand'
        );

        $arrayRequired = array(
            'brand' => array(
                'rule' => 'is_string',
                'maxLength' => 50,
            )
        );

        $dataArray = $this->filterDataPost($arrayRequired, $generalFields, $data);

        if (!empty($dataArray['dataError'])) {
            $this->msgErro($dataArray['dataError']);
        }
    }

    public function validateUpdate($data) {

        $generalFields = array(
            'brand'
        );

        $arrayRequired = array(
            'brand' => array(
                'rule' => 'is_string',
                'maxLength' => 50,
            )
        );

        $dataArray = $this->filterDataUpdate($arrayRequired, $generalFields, $data);

        if (!empty($dataArray['dataError'])) {
            $this->msgErro($dataArray['dataError']);
        }
    }

    /**
     * msgErro - 
     * @param string $erro Mensagem a ser exibida
     * @param int $status HTTP status code, default 400
     */
    public function msgErro($msg, $status = 400) {
        $response = new Response($this->_app);
        $response->response(json_encode(array('error' => $msg)), $status);
        $this->_app->stop();
    }

}