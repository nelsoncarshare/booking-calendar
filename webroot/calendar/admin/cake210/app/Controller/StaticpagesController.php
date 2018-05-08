<?php
App::uses('AppController', 'Controller');

class StaticpagesController extends AppController{

    function beforeFilter()
    {
        $this->checkSession();
    }
    
    function index (){    
 
    }
}
?>