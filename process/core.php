<?php

error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 'On');
//set_error_handler("var_dump");
//set_error_handler("E_ALL");
session_start();
#-------------------------------------------------START:

    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', '');
    define('DB_PASSWORD', '');
    define('DB_DATABASE', 'hellocms');

#-------------------------------------------------END.
#               DATABASE [_DB]
#-------------------------------------------------START:

##-----Link Database-----
function LinkDB($sql) {
   $rb_name = DB_DATABASE;
   $rb_user = DB_USERNAME;
   $rb_pwd = DB_PASSWORD;
   $rb_host = DB_HOSTNAME;
   $con_db = mysqli_connect($rb_host, $rb_user, $rb_pwd, $rb_name) or die ('Cannot connect to server');
   mysqli_set_charset($con_db, 'utf8');
   mb_internal_encoding('UTF-8');
   mb_http_output('UTF-8');
   mb_http_input('UTF-8');
   mb_language('uni');
   mb_regex_encoding('UTF-8');
   ob_start('mb_output_handler');
   if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error();}
   $retval = mysqli_query($con_db,$sql) or die('Could not look up user information; ' . mysqli_error($con_db));
   return $retval;
}
##-----Escape Database-----
function EscapeString($string) {
   $rb_name = DB_DATABASE;
   $rb_user = DB_USERNAME;
   $rb_pwd = DB_PASSWORD;
   $rb_host = DB_HOSTNAME;
   $con_db = mysqli_connect($rb_host, $rb_user, $rb_pwd, $rb_name) or die ('Cannot connect to server');
   mysqli_set_charset($con_db, 'utf8');
   mb_internal_encoding('UTF-8');
   mb_http_output('UTF-8');
   mb_http_input('UTF-8');
   mb_language('uni');
   mb_regex_encoding('UTF-8');
   ob_start('mb_output_handler');
   if (mysqli_connect_errno()) {echo "Failed to connect to MySQL: " . mysqli_connect_error();}
   $retval = mysqli_real_escape_string($con_db,$string) or die('Could not look up user information; ' . mysqli_error($con_db));
   return $retval;
}
##-----Query Database-----
function QDB($sql,$order,$limit){
    if (!empty($sql)){
        if ($order!=0){
            $sql.=" ORDER BY $order ";
        }
        if ($limit!=0){
            $sql.=" limit $limit";
        }
        $retval = LinkDB($sql);
        while($row = mysqli_fetch_array($retval, MYSQLI_ASSOC)) {
            $output[] = $row;
        }
        if (!empty($output)){
            if ($limit==1){
                return $output['0'];
            }else{
                return $output;
            }
        }
        return False;
    }else{
        return False;
    }
}
##-----Database Size-----
function GetTablesSize() {
    $tables = array();
    $rb_name = DB_DATABASE;
    $rb_user = DB_USERNAME;
    $rb_pwd = DB_PASSWORD;
    $rb_host = DB_HOSTNAME;
    $con_db = mysqli_connect($rb_host, $rb_user, $rb_pwd, $rb_name) or die ('Cannot connect to server');
    mysqli_select_db($con_db, $rb_name);
    $result = mysqli_query($con_db,"SHOW TABLE STATUS");
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $total_size = ($row[ "Data_length" ] +
                       $row[ "Index_length" ]) / 1024;
        $tables[$row['Name']] = sprintf("%.2f", $total_size);
    }
    return $tables;
}
function GetDBSize() {
    $tables = GetTablesSize();
    $sum = array_sum($tables)/1024;
    $output = number_format($sum, 2, '.', ' ');
    return $output;
}
