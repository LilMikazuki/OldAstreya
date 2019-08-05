<?php
require_once "php/session_start.php";
session_unset();
session_destroy();
header( 'Location: /index.php', true, 303 );