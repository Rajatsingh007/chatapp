<?php 
if (str_contains($_SERVER["SERVER_NAME"], "localhost")){
    define("BASE_URL","http://localhost/myapp/");
}else{
    define("BASE_URL","http://helloindiagroup.com/myapp/");
}
?>