<?php
class StaticpagesController extends AppController{

    function beforeFilter()
    {
        $this->checkSession();
    }
    
    function index (){    
 
    }
}
?>