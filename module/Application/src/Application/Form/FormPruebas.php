<?php 
namespace Application\Form;

use Zend\Captcha\AdapterInterface as CaptchaAdapter;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\Captcha;
use Zend\Form\Factory;

class FormPruebas extends Form{
    protected $adapter;
    public function __construct($dbAdapter=null,$name = null) {
        parent::__construct($name);
        
        // Asignamos el adaptador al atributo $adapter de la clase
        $this->adapter = $dbAdapter;
        
        
        $this->setInputFilter(new \Application\Form\FormPruebasValidator());
        $this->add(array(
            "name" => "nombre",
            "options" => array(
            "label" => "Nombre: "
            ),
            "attributes" => array(
            "type" => "text",
            "class" => "form-control"
        )
    ));
        $this->add(array(
            "name" => "email",
            "options" => array(
            "label" => "Email: "
            ),
            "attributes" => array(
            "type" => "email",
            "class" => "form-control"
        )
        ));
        /* Añadimos un campo select y como value options en lugar de
        tener unas opciones fijas invocamos al método $this->getCategories() para que
        saque los resultados de la base de datos y los recorra
         */
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'categoria',
            "options" => array(
            'label' => 'Categoría',
            'empty_option' => 'Selecciona una categoria',
            'value_options' => $this->getCategories(),
            ),
           "attributes" => array(
           "class" => "form-control"
        )
        ));
        
        $this->add(array(
            "name" => "submit",
            "attributes" => array(
            "type" => "submit",
            "value" => "Enviar",
            "title" => "Enviar"
        )
        ));
        }
// Este método se encarga de sacar los datos de la BBDD
public function getCategories(){
 // Hacemos una consulta normal o con el Query Builder como queramos
 $dbAdapter = $this->adapter;
 $statement = $dbAdapter->query("SELECT id, nombre FROM categorias");
 $result = $statement->execute();
 $select = array();
 foreach ($result as $r) {
    $select[$r['id']] = $r['nombre'];
 }
    return $select;
 }
}
