<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class UsuariosTable{
    
    protected $tableGateway;
    
    public function __construct(TableGateway $tableGateway) {
        $this->tableGateway = $tableGateway;
    }
    
    public function fetchAll(){
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
    public function getUsuario($id){
        
        $id = (int)$id;
        
        $rowset = $this->tableGateway->select(array("id" => $id));
        $row = $rowset->current();
        
        return $row;
    }
    
    public function saveUsuario (Usuario $usuario){
        
        $data = array(
            "name" => $usuario->name,
            "surname" => $usuario->surname,
            "descripcion" => $usuario->descripcion,
            "email" => $usuario->email,
            "password" => $usuario->password,
            "image" => $usuario->image,
            "alternative" => $alternative->alternative
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



