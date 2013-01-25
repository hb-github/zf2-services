<?php

namespace Regras;

/**
 * AbstractRegras
 * 
 * Classe abstrata que contem os metodos gerais de validacao
 * 
 * @author Francisco Ambrozio <francisco.ambrozio@telecontrol.com.br>
 * @version 2012-10-26
 */
class Regras {

    private $_msg = array();
    private $_app;

    /**
     * setMaskCpfCnpj - Retorna o numero formatado com a mascara "000.000.000-00" para CPF ou CNPJ<br>
     * CPF  - 229.591.822-78     -> 11 caracteres, sem pontos ou hifem - www.geradorcpf.com<br>
     * CNPJ - 86.452.608/0001-72 -> 14 caracteres, sem pontos ou hifem - www.geradorcnpj.com
     * @param string $cpf_cnpj Numero para setar a mascara
     * @return string Número com a máscara pré-formatada
     */
    public function setMaskCpfCnpj($cpf_cnpj) {
        $cpf_cnpj = preg_replace('/\D/', '', $cpf_cnpj);
        $formato = (strlen($cpf_cnpj) == 14) ? '$1.$2.$3/$4-$5' : '$1.$2.$3-$4'; /* 00.000.000/0000-00 ou 000.000.000-00 */
        $mascara = (strlen($cpf_cnpj) == 14) ? '/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/' : '/(\d{3})(\d{3})(\d{3})(\d{2})/';

        return preg_replace($mascara, $formato, $cpf_cnpj);
    }

    /**
     * setMaskCep - Retorna o número formatado com a máscara "00.000-000" para o CEP
     * @param string $cep Número para setar a máscara
     * @return string Número com a máscara pré-formatada
     */
    public function setMaskCep($cep) {
        $cep = preg_replace('/\D/', '', $cep);
        $formato = '$1.$2-$3'; /* 00.000-000 */
        $mascara = '/(\d{2})(\d{3})(\d{2})/';

        return preg_replace($mascara, $formato, $cep);
    }

    /**
     * setMaskTime - Retorna o número formatado com a máscara "00:00" ou "00:00:00" para a hora
     * @param string $hora Número para setar a máscara
     * @return string Número com a máscara pré-formatada
     */
    public function setMaskTime($hora) {
        $hora = preg_replace('/\D/', '', $hora);

        if (strlen($hora) == 4) {
            $formato = '$1:$2';    /* hh:mm    */
            $mascara = '/(\d{2})(\d{2})/';
        } else if (strlen($hora) == 6) {
            $formato = '$1:$2:$3'; /* hh:mm:ss */
            $mascara = '/(\d{2})(\d{2})(\d{2})/';
        }

        return preg_replace($mascara, $formato, $hora);
    }

    /**
     * setMaskTelefone - Retorna o número formatado com a máscara "(00) 0000-0000"<br>
     * ou "(00) 00000-0000" para o Telefone conforme a quantidade de 10 ou 11 caracteres
     * @param string $tel Número para setar a máscara
     * @return string Número com a máscara pré-formatada
     */
    public function setMaskTelefone($telefone) {
        $telefone = preg_replace('/\D/', '', $telefone);

        switch (strlen($telefone)) {
            case 10 : /* (00) 0000-0000 */
                $formato = '($1) $2-$3';
                $mascara = '/(\d{2})(\d{4})(\d{4})/';
                break;

            case 11 : /* (00) 00000-0000 */
                $mascara = '/(\d{2})(\d{5})(\d{4})/';
                $formato = '($1) $2-$3';
                break;

            default :
                return $this->messageField(9, null);
                break;
        }

        return preg_replace($mascara, $formato, $telefone);
    }

    /**
     * isEmpty - Retorna se uma variável é ou não vazia
     * @param mixed $var Variável a ser validada
     * @return boolean
     */
    public function isEmpty($var) {
        if (empty($var))
            return $this->messageField(9, null);
    }

    /**
     * isString - Retorna se uma variável é ou não uma string
     * @param mixed $var Variável a ser validada
     * @return string Retorna mensagem para o usuário
     */
    public function isString($var) {
        if (!is_string($var))
            return $this->messageField(12, null);
    }

    /**
     * isNumber - Retorna se uma variável é ou não numérica
     * @param mixed $var Variável a ser validada
     * @return string Retorna mensagem para o usuário
     */
    public function isNumber($var) {
        if (!is_numeric($var))
            return $this->messageField(7, null);
    }

    /**
     * isValidDate - Retorna se uma variável é ou não uma data válida
     * @param mixed $date Data a ser validada
     * @param int $iso Formato da data
     * @return string Retorna mensagem para o usuário
     */
    public function isValidDate($date, $iso = 1) {
        $retorno = true;

        if ($iso == 1) {
            $yidx = 0;
            $midx = 1;
            $didx = 2;
        } else {
            $yidx = 2;
            $midx = 1;
            $didx = 0;
        }

        $arrDate = ($iso == 1) ? explode('-', $date) : explode('/', $date);

        if (count($arrDate) <> 3) {
            $retorno = false;
        }

        foreach ($arrDate as $item) {
            if (!$this->isNumber($item)) {
                $retorno = false;
            }
        }

        $y = (int) $arrDate[$yidx];
        $m = (int) $arrDate[$midx];
        $d = (int) $arrDate[$didx];

        if (!checkdate($m, $d, $y)) {
            $retorno = false;
        }

        if ($retorno == false) {
            return $this->messageField(2, null);
        }
    }

    /**
     * isValidEmail - Verifica se o e-mail é válido
     * @param string $email Recebe o E-mail para validação
     * @return string Retorna mensagem para o usuário
     */
    public function isValidEmail($email) {
        if (!(filter_var(str_replace(array(' ', '  '), '', trim($email)), FILTER_VALIDATE_EMAIL))) {
            return $this->messageField(14, $email);
        }
    }

    /**
     * isValidCpfCnpj - Valida CPF ou CNPJ com ou sem máscara setada<br>
     * CPF  - 229.591.822-78     -> 11 caracteres, sem pontos e hífem - www.geradorcpf.com<br>
     * CNPJ - 86.452.608/0001-72 -> 14 caracteres, sem pontos, barra e hífem - www.geradorcnpj.com
     * @param string $cnpj Recebe um número para validação
     * @return string Retorna mensagem para o usuário
     */
    public function isValidCpfCnpj($cpf_cnpj) {
        $cpf_cnpj = preg_replace('/\D/', '', $cpf_cnpj); /* Deixando apenas dígitos */

        if (strlen($cpf_cnpj) == 11) { /* Validando CPF */

            $soma = 0;
            for ($i = 0; $i < 9; $i++) {
                $soma += (($i + 1) * $cpf_cnpj[$i]);
            }

            $dv1 = ($soma % 11);
            if ($dv1 == 10)
                $dv1 = 0;

            $soma = 0;
            for ($i = 9, $j = 0; $i > 0; $i--, $j++) {
                $soma += ($i * $cpf_cnpj[$j]);
            }

            $dv2 = ($soma % 11);
            if ($dv2 == 10)
                $dv2 = 0;

            if (($dv1 != $cpf_cnpj[9]) && ($dv2 != $cpf_cnpj[10])) {
                return $this->messageField(4, $cpf_cnpj);
            }
        } else if (strlen($cpf_cnpj) == 14) { /* Validando CNPJ */

            $soma = 0;
            $soma += ($cpf_cnpj[0] * 5);
            $soma += ($cpf_cnpj[1] * 4);
            $soma += ($cpf_cnpj[2] * 3);
            $soma += ($cpf_cnpj[3] * 2);
            $soma += ($cpf_cnpj[4] * 9);
            $soma += ($cpf_cnpj[5] * 8);
            $soma += ($cpf_cnpj[6] * 7);
            $soma += ($cpf_cnpj[7] * 6);
            $soma += ($cpf_cnpj[8] * 5);
            $soma += ($cpf_cnpj[9] * 4);
            $soma += ($cpf_cnpj[10] * 3);
            $soma += ($cpf_cnpj[11] * 2);

            $dv1 = $soma % 11;
            $dv1 = $dv1 < 2 ? 0 : 11 - $dv1;

            $soma = 0;
            $soma += ($cpf_cnpj[0] * 6);
            $soma += ($cpf_cnpj[1] * 5);
            $soma += ($cpf_cnpj[2] * 4);
            $soma += ($cpf_cnpj[3] * 3);
            $soma += ($cpf_cnpj[4] * 2);
            $soma += ($cpf_cnpj[5] * 9);
            $soma += ($cpf_cnpj[6] * 8);
            $soma += ($cpf_cnpj[7] * 7);
            $soma += ($cpf_cnpj[8] * 6);
            $soma += ($cpf_cnpj[9] * 5);
            $soma += ($cpf_cnpj[10] * 4);
            $soma += ($cpf_cnpj[11] * 3);
            $soma += ($cpf_cnpj[12] * 2);

            $dv2 = $soma % 11;
            $dv2 = $dv2 < 2 ? 0 : 11 - $dv2;

            if (($cpf_cnpj[12] != $dv1) && ($cpf_cnpj[13] != $dv2)) {
                return $this->messageField(5, $cpf_cnpj);
            }
        } else {
            return $this->messageField(9, null);
        }
    }

    /**
     * isValidCep - Valida o CEP com a máscara setada, ex.: 00.000-000
     * @param string $cep Recebe um número para validação
     * @return string Retorna mensagem para o usuário em caso de negação
     */
    public function isValidCep($cep) {
        if (!preg_match('/^[0-9]{2}.[0-9]{3}-[0-9]{3}$/', $cep)) { /* 00.000-000 */
            return $this->messageField(1, $cep);
        }
    }

    /**
     * isValidTime - Valida a Hora com a máscara pré-setada, ex.: 00:00 ou 00:00:00
     * @param string $hora Recebe um número para validação
     * @return string Retorna mensagem para o usuário
     */
    public function isValidTime($hora) {
        if (strlen($hora) == 5) {
            if (!preg_match('/^([0-1][0-9]|[2][0-3]):[0-5][0-9]$/', $hora)) { /* 00:00 */
                return $this->messageField(15, $hora);
            }
        } else if (strlen($hora) == 8) {
            if (!preg_match('/^([0-1][0-9]|[2][0-3]):[0-5][0-9]:[0-5][0-9]$/', $hora)) { /* 00:00:00 */
                return $this->messageField(15, $hora);
            }
        }
    }

    /**
     * isValidField - Validação simples de campo vazio, número máximo e mínimo de caracteres )
     * @param string $valor String com o valor digitado no input a ser validado
     * @param string $campo Nome/Título do campo a ser verificado, ex.: CPF, Endereço, ...
     * @param int $max Número máximo de caracteres aceitos
     * @param int $min Número mínimo de caracteres aceitos
     * @return string Retorna a mensagem formatada para o usuário
     */
    public function isValidField($valor, $campo, $max, $min) {
        $valor = str_replace(array(' ', '  '), '', trim($valor));

        if (empty($valor)) {
            return $this->messageField(8, $campo, null, $max, $min);
        } elseif (strlen($valor) > $max) {
            return $this->messageField(9, $campo, null, $max, $min);
        } elseif (strlen($valor) < $min) {
            return $this->messageField(10, $campo, null, $max, $min);
        }
    }

    /**
     * messageField - Validando a quantidade de caracteres para cada campo
     * @param int $num Número da mensagem pré-configurada que será retornada ao usuário
     * @param string $campo Nome do campo, Título ou Mensagem personalizada, ex.: CPF, www.site.com, ...
     * @param int $status HTTP status code, default 400
     * @param int $max Número máximo de caracteres aceitos
     * @param int $min Número mínimo de caracteres aceitos
     * @return string Retorna a mensagem formatada para o usuário
     */
    public function messageField($num, $campo, $status = 400, $max = null, $min = null) {
        $this->_msg[0] = "$campo";                                    /* Mensagem personalizada */
        $this->_msg[1] = "CEP em formato inválido";                   /* CEP inválido           */
        $this->_msg[2] = "Data em formato inválido";                  /* Data inválida          */
        $this->_msg[3] = "Telefone inválido";                         /* Telefone inválido      */
        $this->_msg[4] = "CPF: $campo inválido";                      /* CPF inválido           */
        $this->_msg[5] = "CNPJ: $campo inválido";                     /* CNPJ inválido          */
        $this->_msg[6] = "Endereço IP: $campo inválido";              /* IP inválido            */
        $this->_msg[7] = "Preencha o campo apenas com números";       /* Somente números        */
        $this->_msg[8] = "A URL informada é inválida";                /* URL inválida           */
        $this->_msg[9] = "Preencha corretamente o campo";             /* Campo vazio            */
        $this->_msg[10] = "$campo deve ter no máximo $max caracteres"; /* Máximo de caracteres   */
        $this->_msg[11] = "$campo deve ter no mínimo $min caracteres"; /* Mínimo de caracteres   */
        $this->_msg[12] = "O valor do campo não é uma String";         /* Não é String           */
        $this->_msg[13] = "O código $campo já existe";                 /* Código já existe       */
        $this->_msg[14] = "E-mail: $campo inválido";                   /* E-mail inválido        */
        $this->_msg[15] = "Hora: $campo inválida";                     /* E-mail inválido        */

        /* $response = new Response($this->_app);
          $response->response(json_encode(array('error' => $this->_msg[$num])), $status);
          $this->_app->stop(); */

        return json_encode(array('error' => $this->_msg[$num]));
    }

    public function filterDataPost($arrayRequired, $generalFields, $input) {
        //echo "<pre>"; print_r($input);print_r($arrayRequired);print_r($generalFields);
        $requiredVerf = TRUE;
        $arrayReturn = array();
        $dataError = array();

        foreach ($arrayRequired as $key => $value) {
            $requiredVerf = FALSE; /* Validando campos obrigatórios */

            if (empty($input[$key])) {
                $input[$key] = null;
            }


            if (!$value['rule']($input[$key]) || empty($input[$key])) {
                $dataError[$key]['rule'] = $value['rule'];
            }

            if (!empty($value['maxLength'])) {
                if ($value['maxLength'] < strlen($input[$key])) {
                    $dataError[$key]['maxLength'] = $value['maxLength'];
                }
            }
            if (!empty($value['minLength'])) {
                if ($value['minLength'] > strlen($input[$key])) {
                    $dataError[$key]['minLength'] = $value['minLength'];
                }
            }

            if ($value['rule'] == 'is_bool') {
                if (empty($input[$key])) {
                    $dataError[$key]['rule'] = $value['rule'];
                }
                if ($input[$key] != 'false' && $input[$key] != 'true') {
                    $dataError[$key]['rule'] = $value['rule'];
                } else {
                    unset($dataError[$key]);
                }
            }
        }
        foreach ($generalFields as $key => $value) {
            if (!empty($input[$value])) {
                $arrayReturn[$value] = $input[$value]; /* Capturando apenas os campos preenchidos para executar a query */
            } else {
                $arrayReturn[$value] = null;
            }
        }

        $return['requiredVerf'] = $requiredVerf;
        $return['arrayReturn'] = $arrayReturn;
        $return['dataError'] = $dataError;

        return $return;
    }

    public function filterDataUpdate($arrayRequired, $generalFields, $input) {
        //echo "<pre>"; print_r($input);print_r($arrayRequired);print_r($generalFields);
        $requiredVerf = TRUE;
        $arrayReturn = array();
        $dataError = array();



        foreach ($arrayRequired as $key => $value) {


            foreach ($input as $keyInput => $valueInput) {
                if ($keyInput == $key) {
                    $requiredVerf = FALSE; /* Validando campos obrigatórios */

                    if (empty($input[$key])) {
                        $input[$key] = null;
                    }

                    if (!$value['rule']($input[$key])) {
                        $dataError[$key]['rule'] = $value['rule'];
                    }

                    if (!empty($value['maxLenght'])) {
                        if ($value['maxLenght'] < strlen($input[$key])) {
                            $dataError[$key]['maxLenght'] = $value['maxLenght'];
                        }
                    }
                    if (!empty($value['minLenght'])) {
                        if ($value['minLenght'] > strlen($input[$key])) {
                            $dataError[$key]['minLenght'] = $value['minLenght'];
                        }
                    }

                    if ($value['rule'] == 'is_bool') {
                        if (empty($input[$key])) {
                            $dataError[$key]['rule'] = $value['rule'];
                        }
                        if ($input[$key] != 'false' && $input[$key] != 'true') {
                            $dataError[$key]['rule'] = $value['rule'];
                        } else {
                            unset($dataError[$key]);
                        }
                    }
                }
            }
        }

        foreach ($generalFields as $key => $value) {
            if (!empty($input[$value])) {
                $arrayReturn[$value] = $input[$value]; /* Capturando apenas os campos preenchidos para executar a query */
            } else {
                $arrayReturn[$value] = null;
            }
        }

        $return['requiredVerf'] = $requiredVerf;
        $return['arrayReturn'] = $arrayReturn;
        $return['dataError'] = $dataError;

        return $return;
    }

}