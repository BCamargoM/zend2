<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;
class UsuariosTable{
    
    protected $tableGateway;
    protected $dbAdapter;


    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $tableGateway->adapter;
    }     
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function fetchAllSql(){
        
        $sql = new Sql ($this->dbAdapter);
        $select = $sql->select();
        $select->from ("usuarios");
        
        $statement = $sql->prepareStatementForSqlObject($select);
        $data = $statement->execute();
        /* Igual las lines de codigo arriba hacen lo mismo que aqui solo que nosotros construimos el builder
        $query = $this->dbAdapter->query("SELECT * FROM usuarios",Adapter::QUERY_MODE_EXECUTE);
        $data = $query->toArray();        
         * */
         
        /* esto es hace lo mismo que las lineas de arriba
        $query = $this->dbAdapter->createStatement("SELECT * FROM usuarios");
        $data = $query->execute();
         * 
         */
        
        // array en un array de objetos
        
        $resultSet = new ResultSet();
        $data = $resultSet->initialize($data);
        return $data;
    }
    
    public function getUsuario($id){
        
        $id = (int)$id;
        
        $rowset = $this->tableGateway->select(array("id" => $id));
        $row = $rowset->current();
        
        return $row;
    }
    
     public function getUsuarioByEmail($email){        
        $rowset = $this->tableGateway->select(array("email" => $email));
        $row = $rowset->current();
        
        return $row;
    }
    
    public function saveUsuario (Usuario $usuario){      
       
        $data = array(
            "name" => $usuario->name,
            "surname" => $usuario->surname,
            "description" => $usuario->description,
            "email" => $usuario->email,
            "password" => $usuario->password,
            "image" => $usuario->image,
            "alternative" => $usuario->alternative
        );
        
        $id = (int)$usuario->id;
        
        if($id == 0){
            $return = $this->tableGateway->insert($data);
        }else{
            if($this->getUsuario($id)){
               $return= $this->tableGateway->update($data);
            }else{
                throw new \Exception("El usuario  no existe");
            }
        }        
        return $return;
    }
    
    public function deleteUsuario($id){        
        $delete = $this->tableGateway->delete(array("id" => (int)$id));
        return $delete;
    }
}



