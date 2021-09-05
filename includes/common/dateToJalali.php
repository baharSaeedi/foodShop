<?php
date_default_timezone_set("Asia/Tehran");
function dateToJalali( $date = null ){
    $array = explode(" ",$date);
    list($year,$month,$day) = explode("-",$array[0]);
    list($hour,$minute,$second) = explode(":",$array[1]);
    $timestamp = mktime($hour,$minute,$second,$month,$day,$year);
    return jdate("ساعت: H:i:s _ تاریخ: Y/m/d",$timestamp);
}

?>