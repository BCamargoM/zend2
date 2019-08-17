<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FormAddUsuarios;
class EjemploController extends AbstractActionController {

    protected $usuariosTable;

    protected function getUsuariosTable() {
        if (!$this->usuariosTable) {
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get("Application\Model\UsuariosTable");
        }
        return $this->usuariosTable;
    }

    public function indexAction() {

        $usuarios = $this->getUsuariosTable()->fetchAll();
        return new ViewModel(
                array(
            "usuarios" => $usuarios
        ));
    }
    public function addAction() {
        
        $form = new FormAddUsuarios("AddUsuarios");
        
        $view = array(
            "form" => $form
        );

            
        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());       
                
            if (!$form->isValid()) {
                $errors = $form->getMessages();
                $view["errors"] = $errors;                
            } else {
                $usuario = new \Application\Model\Usuario();
                       
                $data = array(
                    "name" => $this->request->getPost("name"),
                    "surname" => $this->request->getPost("surname"),
                    "description" => $this->request->getPost("description"),
                    "email" => $this->request->getPost("email"),
                    "password" => $this->request->getPost("password"),
                    "image" => "null",
                    "alternative" => "null"
                );
                                
                $usuario->exchangeArray($data);                

                $usuario_by_email = $this->getUsuariosTable()->getUsuarioByEmail($data["email"]);
                

                if ($usuario_by_email) {
                    $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . "/ejemplo");
                } else {
                    $save = $this->getUsuariosTable()->saveUsuario($usuario);  
                    $this->redirect()->toUrl($this->getRequest()->getBaseUrl() . "/ejemplo/add");
                }
            }
        }
        return new ViewModel($view);
    }

}
