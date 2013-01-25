<?php
/**
 * Routes mapeia as rotas do projeto
 * 
 * @author Francisco Ambrozio <francisco.ambrozio@telecontrol.com.br>
 * @version 2012-10-25
 */

namespace Rest;

/**
 * Classe Routes, mapeia as rotas do projeto
 */
class Routes
{
    /**
     * getRoutes
     * 
     * Carrega as rotas disponíveis na aplicação.
     * Para adicionar uma nova rota é só adicionar um novo par chave => valor no array. 
     * Sendo chave = rota, valor = controller.
     * Cada controller deve ter uma model correspondente.
     * 
     * @return array
     */
    public static function getRoutes()
    {
        return array(
            '/brands'                    => 'Brands',
        );
    }
}