<?php

#-----Load Functions-----


#-----Login Status-----
if(!isset($_SESSION['is_U_login'])){
    $_SESSION['is_U_login'] = False;
}
if($_SESSION['is_U_login']==False){
    $U_logedin = False;
    $U_login='';
}else{
    $U_logedin = True;
}
