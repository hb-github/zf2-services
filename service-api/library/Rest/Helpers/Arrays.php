<?php

namespace Rest\Helpers;

/**
 * Classe Arrays em PosVendaApi
 * @author Ricardo Vicente <ricardo.vicente@telecontrol.com.br>
 */
class Arrays
{
    /**
     * $_estados - Todos Estados Brasileiros
     * @var array 
     */
    private $_estados = array(
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AM' => 'Amazonas',
        'AP' => 'Amapá',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MG' => 'Minas Gerais',
        'MS' => 'Mato Grosso do Sul',
        'MT' => 'Mato Grosso',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'PR' => 'Paraná',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'RS' => 'Rio Grande do Sul',
        'SC' => 'Santa Catarina',
        'SE' => 'Sergipe',
        'SP' => 'São Paulo',
        'TO' => 'Tocantins'
    );
    
    /**
     * $_tipos_contas_bancarias - Todos Tipos de Contas Bancárias
     * @var array 
     */
    private $_tipos_contas_bancarias = array(
        1 => 'Conta Conjunta',
        2 => 'Conta Corrente',
        3 => 'Conta Individual',
        4 => 'Conta Jurídica',
        5 => 'Conta Poupança'
    );
    
    /**
     * $_localizacao_posto - Localização dos Postos
     * @var array 
     */
    private $_localizacao_posto = array(
        1 => 'Capital',
        2 => 'Interior'
    );
    
    /**
     * $_origem_produto - Origem dos Produtos
     * @var array 
     */
    private $_origem_produto = array(
        'Nac' => 'Nacional',
        'Imp' => 'Importado',
        'USA' => 'Importado USA',
        'Asi' => 'Importado Ásia'
    );
    
    /**
     * $_voltagem - Voltagem dos Produtos
     * @var array 
     */
    private $_voltagem = array(
        '12 V',
        '110 V',
        '127 V',
        '220 V',
        '230 V',
        'Bivolt',
        'Bivolt Aut',
        'Bateria',
        'Pilha'
    );
    
    /**
     * $_sim_nao - Opção: 'Sim' ou 'Não'  =>  't' ou 'f'
     * @var array 
     */
    private $_sim_nao = array(
        't' => 'Sim',
        'f' => 'Não'
    );
    
    /**
     * Estados
     * @return array
     */
    public function estados()
    {
        return $this->_estados;
    }
    
    /**
     * Tipos de contas bancárias
     * @return array
     */
    public function tipos_contas_bancarias()
    {
        return $this->_tipos_contas_bancarias;
    }
    
    /**
     * Localização do posto
     * @return array
     */
    public function localizacao_posto()
    {
        return $this->_localizacao_posto;
    }
    
    /**
     * Origem do produto
     * @return array
     */
    public function origem_produto()
    {
        return $this->_origem_produto;
    }
    
    /**
     * Voltagem do produto
     * @return array
     */
    public function voltagem()
    {
        return $this->_voltagem;
    }
    
    /**
     * Ativo e Inativo
     * @return array
     */
    public function ativo_inativo()
    {
        return $this->_ativo;
    }
    
    /**
     * Sim e Não
     * @return array
     */
    public function sim_nao()
    {
        return $this->_sim_nao;
    }
}