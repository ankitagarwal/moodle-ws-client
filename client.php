<?php

require_once('config.php');

$domain = "http://localhost/stable_master";
$token = "8dfa20ee5b16f4dcf0f40fab26045aed";
$function = "core_notes_delete_notes";
$params = array (4);

// Make the call.
$client = new xmlrpc($domain, $token, true);
$client->wscall($function, $params);
