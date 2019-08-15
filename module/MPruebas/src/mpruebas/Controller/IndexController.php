<?php 

namespace MPruebas\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
    public function helloWorldAction(){
        echo    "Hello world! Welcome  to the course from Zend Framework 2";
        die();
    }
}
