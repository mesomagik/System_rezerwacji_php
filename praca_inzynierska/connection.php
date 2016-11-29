<?php

define('host','mysql1.ugu.pl');
define('user','db686283');
define('password','bartek123');
define('databaseName','db686283');

$connect = mysqli_connect(host,user,password,databaseName);
mysqli_set_charset($connect, "utf8")
?>