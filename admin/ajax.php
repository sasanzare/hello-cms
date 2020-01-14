<?php
   if (file_exists('../process/core.php')) {
       require_once('../process/core.php');
   } else {
       die('Common File is Missing !');
   }
   if (!isset($_POST["a"]))  {
       $called_action = '';
   } else {
       $called_action = $_POST["a"];
   }
switch ($called_action) {
   case "alogin":
##-----A Login-----
       if (!isset($_POST["fadmin"])) {
           die("No Username !");
       } else  {
           $fadmin = $_POST["fadmin"];
       }
       if (!isset($_POST["fpass"])) {
           die("No Password !");
       } else  {
           $fpass = $_POST["fpass"];
       }
       LoginUser($fadmin,$fpass);
   break;
   case "logout":
##-----Logout-----
       LogoutUser();
   break;
   default:
       echo " ";
   }
?>
