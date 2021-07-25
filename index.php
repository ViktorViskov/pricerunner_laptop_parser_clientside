<?php

// show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// show errors

// import db lib
require "./core/request.php";

// make request processing
new Request_Process($_SERVER['REQUEST_URI']);