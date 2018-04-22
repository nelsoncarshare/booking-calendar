<?php
global $SQL_PREFIX, $CANCELED, $EVENT_TYPE_BOOKING, $GROUP_FOR_INDIVIDUALS, $TAX_CODES, $OPERATION, $MEMBER_PLANS, $HOURS_CUTOFF;
global $LIGHT_ROW_COLOR, $DARK_ROW_COLOR, $CALENDAR_ROOT, $GOOGLE_MAPS_API_KEY;

date_default_timezone_set('Canada/Pacific');

define('SQL_HOST',     'localhost');
define('SQL_USER',     'database_user');
define('SQL_PASSWD',   'database_password');
define('SQL_DATABASE', 'booking_calendar');
define('SQL_PREFIX',   'phpc_');
define('SQL_TYPE',     'mysql');

define('USER_HOME',    'c:/bitnami/carshare-users/');
define('LOG_FILE',     'c:/bitnami/calendar-log.txt');
define('GOOGLE_MAPS_API_KEY1', 'ABQIAAAAk0n9TBAUpGw6Bnr5n1vPkRQkm_5lpumf1IOMviWLJPtrf11AdBS8oSSVcpF1O8wb5iYHXwy27BAABA');

$ADMIN_EMAIL = "carsharecoop@gmail.com";
$USER_GUIDE_URL = 'http://www.carsharecoop.ca/how-it-works/';
$GOOGLE_MAPS_API_KEY = Array('nelsoncar.com' => 'ABQIAAAAk0n9TBAUpGw6Bnr5n1vPkRTl6f1iR-bEtr-8QU6UrPAJah2JsBQpIG5pe-daCV92UQT-vDERP0CJFg', 'carsharecoop.ca' => 'ABQIAAAAk0n9TBAUpGw6Bnr5n1vPkRT3Sed5rwkTZDzgqWbfV3qgL9tp0RRbYGbshBXFC2rjwrUr27WPvCogJw', 'carsharecoop.com' =>'ABQIAAAAk0n9TBAUpGw6Bnr5n1vPkRT5EjKub4eRDenpQfycG2ZTzYNRBxT7Pu-GXrdTlerG5ge3ATEIyt_gfw');
							
$HOURS_CUTOFF = 8.0; //number of hours where high rate switches to low

$CALENDAR_ROOT = "http://localhost/calendar/"; //use full URL

# ======================================== end configuration

$LIGHT_ROW_COLOR="#FFFFFF";
$DARK_ROW_COLOR="#EEEEEE";

$TAX_CODES['PST_ONLY'] = 1;
$TAX_CODES['GST_ONLY'] = 2;
$TAX_CODES['PST_GST'] = 3;
$TAX_CODES['EXEMPT'] = 4;

$CANCELED['NORMAL']=0;
$CANCELED['CANCELED']=1;
$CANCELED['CANCELED_WITHIN_NO_REFUND_PERIOD']=2;

$OPERATION['CREATE'] = 1;
$OPERATION['MODIFY'] = 2;
$OPERATION['CANCEL'] = 3;
$OPERATION['CANCELED_WITHIN_NO_REFUND_PERIOD'] = 4;
$OPERATION['LOGIN'] = 8;

$MEMBER_PLANS['LOW'] = 1;
$MEMBER_PLANS['MED'] = 2;
$MEMBER_PLANS['HIGH'] = 3;
$MEMBER_PLANS['GROUP'] = 4;

$EVENT_TYPE_BOOKING = 1;
$EVENT_TYPE_RESERVATION = 2;

$GROUP_FOR_INDIVIDUALS = 1;

function get_google_maps_api_key1()
{
	global $GOOGLE_MAPS_API_KEY;

    foreach( $GOOGLE_MAPS_API_KEY as $servername => $k){
        if (substr_count($_SERVER["SERVER_NAME"], $servername )){
            return $k;
        }
    }   
    return "";
}

if(isset($_COOKIE["PHPSESSID"])){ 
        session_id($_COOKIE["PHPSESSID"]); 
} 
?>