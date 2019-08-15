<?php
 
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class PruebasController extends AbstractActionController
{
    public function indexAction()
    {
        $id = $this->params()->fromRoute("id","POR DEFECTO");
        $id2= $this->params()->fromRoute("id2","POR DEFECTO 2");
        
        $this->layout("layout/prueba");
        
        $this->layout()->parametro="Hola que tal";
        $this->layout()->title="Plantilla de Zend FRamework 2";
        /*
        if($id == "POR DEFECTO"){
            //ambos casos nos llevan a home
            //return $this->redirect()->toRoute("home"); 
            return $this->redirect()->toUrl(
                    //si indicamos alguna url nos debe redirigir a esa url
                    $this->getRequest()->getBaseUrl()
                    );
        }*/        
        return new ViewModel(array(
            "texto" => "Vista del nuevo metodo action del nuevo controlador",
            "id" => $id,
            "id2" => $id2
        ));
    }
    
    public function verDatosAjaxAction(){
        $view = new ViewModel();
        $view->setTerminal(true);
        return $view;
    }
     
}
