<?php

/**
 * PosVendaApiDb
 * 
 * Class Model\Table\Familia
 * 
 * @author Fabiano Souza <fabiano.souza@telecontrol.com.br>
 */

namespace Rest\Model;

use Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet,
    Zend\Db\Sql\Sql;


/**
 * Classe FamiliaTable Model em PosVendaApiDb
 * @author Fabiano Souza <fabiano.souza@telecontrol.com.br>
 */
class BrandsTable {

    protected $table = 'brands';
    protected $lastInsertValue = 'id';
    protected $sql;
    protected $seq = 'seq_familia';
    protected $primary_key = 'id';
    protected $adapter;
    protected $columns = array(
        '*'
    );

    /**
     * Construtor da Classe
     * @param \Zend\Db\Adapter\Adapter $adapter
     */
    public function __construct(Adapter $adapter) {
        
        $this->adapter = $adapter;
        $this->sql = new Sql($this->adapter, $this->table);
    }

    /**
     * getAll - Recupera todas as Familias
     * @param int $fabrica Id da Fábrica
     * @param int $offset Results Start, default 0
     * @param int $limit Valor máximo, default 100
     * @return mixed
     */
    public function getAll() {

        $select = $this->sql->select();
        $select->columns($this->columns);
        
        /**
         * $select->limit($limit)
         * ->offset($offset);
         */
                
        $statement = $this->sql->prepareStatementForSqlObject($select);
        

        $result = $statement->execute();
        

        $resultSet = new ResultSet();
        $resultSet->initialize($result);

        $returnArray['array'] = $resultSet->toArray();



        return $returnArray;
    }

    /**
     * save - Grava a Familia
     * @param array $data Array de Dados para salvar
     * @return mixed
     */
    public function save($data) {

        $insert = $this->sql->insert();

        $insert->values($data);
        $statement = $this->sql->prepareStatementForSqlObject($insert);
        
        
        $result = $statement->execute();

        $returnArray['insert'] = $result;

        return $returnArray;
    }

    /**
     * update - Atualiza a Familia
     * @param int $fabrica Id da Fábrica
     * @param int $id Id da Familia
     * @param array $data Array de Dados para salvar
     * @return mixed
     */
    public function update($id, $data) {
        $update = $this->sql->update();
        $update->set($data)
                ->where(array( $this->primary_key => $id));

        $statement = $this->sql->prepareStatementForSqlObject($update);
        
        $result = $statement->execute();

        return $result;
    }

    /**
     * delete - Deleta a Familia
     * @param int $fabrica Id da Fábrica
     * @param int $id Id da Familia
     * @return mixed
     */
    public function delete($id) {

        $delete = $this->sql->delete();
        $delete->where(array($this->primary_key => $id));
        $statement = $this->sql->prepareStatementForSqlObject($delete);
        $result = $statement->execute();

        return $result;
    }


}