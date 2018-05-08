<?php

class AppController extends Controller
{
    function checkSession()
    {   

        global $CALENDAR_ROOT;
		$session = $this -> Session -> read();
        if ( !isset($session['permission']) )
        {
	         $this->redirect($CALENDAR_ROOT);
	         exit();
        }
        if ( strstr($session['permission'],"ADMIN_USER") == FALSE ){
	         $this->redirect($CALENDAR_ROOT);
	         exit();
	    }   
    }
}
?>