<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Form\FormPruebas;
use Zend\Validator;
use Zend\I18n\Validator as I18Validator;

class IndexController extends AbstractActionController
{
    
    protected  $usuariosTable;
    
    protected  function  getUsuariosTable(){
        
        if(!$this->usuariosTable){
            $sm = $this->getServiceLocator();
            $this->usuariosTable = $sm->get("Application\Model\UsuariosTable");
        }
        return $this->usuariosTable;
    } 
    
    public function indexAction()
    {
        return new ViewModel();
    }
    public function helloWorldAction(){
        echo    "Hello world! Welcome  to the course from Zend Framework 2";
        die();
    }
    
    public function formAction(){
        //Conseguimos el dbAdapter para conectarnos a la base de datos
        $dbAdapter = $this->getServiceLocator()->get("Zend\Db\Adapter\Adapter");
        
         // Creamos el objeto del formulario y le pasamos el adaptador
        $form = new FormPruebas($dbAdapter,"form");

        //$form = New FormPruebas("form");
        
        $view = array(
            "title" => "Formularios con Zend  Framework 2",
            "form" => $form
        );
        
        if($this->request->isPost()){
            $form->setData($this->request->getPost());
            
            if(!$form->isValid()){
                $errors = $form->getMessages();
                $view["errors"] = $errors;
            }
        }
        
        return new ViewModel($view);        
    }
    
    public function getFormDataAction(){
        if($this->request->getPost("submit")){
            $data = $this->request->getPost();            
            $email = new Validator\EmailAddress();
            $email->setMessage("El email'%value%' no es correcto");
            $validate_email = $email->isValid($this->request->getPost("email"));
            
            $alpha = new I18Validator\Alpha();
            $alpha->setMessage("El nombre '%value%' no son solo letras");
            $validate_alpha= $alpha->isValid($this->request->getPost("nombre"));  
            
            if($validate_email == true || $validate_alpha ==true ){
                $validate = "validación de datos correcta";
            }else{
                $validate = array(
                    $email->getMessages(),
                    $alpha->getMessages()
                );
                var_dump($validate);            }
            var_dump($data);
            die();
        }else{
            $this->redirect()->toUrl($this->getRequest()->getBaseUrl()."/application/index/form");
        }
    }
    
    public function listarAction(){
        $usuarios = $this->getUsuariosTable()->fetchAll();
        foreach($usuarios as $usuario){
            var_dump($usuario);
        }
        
        die();
    }
}
