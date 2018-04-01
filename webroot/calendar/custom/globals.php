<?php
if ( !defined('IN_PHPC') ) {
       die("Hacking attempt");
}

$TAX_CODES['PST_ONLY'] = 1;
$TAX_CODES['GST_ONLY'] = 2;
$TAX_CODES['PST_GST'] = 3;
$TAX_CODES['EXEMPT'] = 4;

$OPERATION['CREATE'] = 1;
$OPERATION['MODIFY'] = 2;
$OPERATION['CANCEL'] = 3;
$OPERATION['CANCELED_WITHIN_NO_REFUND_PERIOD'] = 4;
$OPERATION['LOGIN'] = 8;

$MEMBER_PLANS['LOW'] = 1;
$MEMBER_PLANS['MED'] = 2;
$MEMBER_PLANS['HIGH'] = 3;
$MEMBER_PLANS['GROUP'] = 4;

$HOURS_CUTOFF = 8.0; //number of hours where high rate switches to low

?>
