<?php
class CalendarController extends AppController {
   var $name = 'Calendar';
   var $layout = 'memberpages';

    function beforeFilter()
    {
        $this->checkSession();
    }   
   
	function index($id=null) {
		global $vars, $calendar_name, $month, $year, $day;
		$id = 0;
		//if (!$id) {
		//	$this->Session->setFlash('Invalid id for Calendar.');
		//	$this->redirect('/calendar/index');
		//}
		
		App::import('Vendor','adodb/adodbinc');
		App::import('Vendor','calendar/setup');
		App::import('Vendor','calendar/html');
		App::import('Vendor','calendar/url_match');
		App::import('Vendor','calendar/calendar');
		App::import('Vendor','calendar/rules');
		App::import('Vendor','calendar/display');

		$month = 11;
		$year = 2008;

		$calendar_name=$id;
		$this->set('calid', $id);
		$this->set('calendar', display());
	}

   
   
}
?>