<?php

    header("Status: 301 Moved Permanently");
    header("Location: http://carsharecoop.ca/members/calendar/index.php?". $_SERVER['QUERY_STRING']);
    exit;

?>