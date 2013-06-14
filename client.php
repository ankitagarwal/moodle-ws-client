<?php
/**
 * Webservice test client for Moodle
 * @author Ankit Agarwal
 *
 */
class wsclient {
    protected $token;
    protected $domain;
    public $func;
    protected $debug;
    public $prot;
    protected $debugdata;
    protected $curl;

    function __construct($token, $domain, $debug = true){
        require_once('curl.php');
        $this->token = $token;
        $this->domain = $domain;
        $this->debug = $debug;
        $this->curl = new curl;
        if ($this->debug) {
            @ini_set('display_errors', '1');
            error_reporting(-1);
        }
    }
    function wscall ($func, $params) {
        header('Content-Type: text/plain');
        $post = $this->callwsapi($func, $params);
        if ($this->debug) {
            echo $this->debugdata;
        }
    }
    function callwsapi ($func, $params) {
        // Child classes must extend.
        return true;
    }
}

class xmlrpc extends wsclient {
    public $prot = "XMLRPC";
    function callwsapi($func, $params) {

        $serverurl = $this->domain . '/webservice/xmlrpc/server.php'. '?wstoken=' . $this->token;
        $post = xmlrpc_encode_request($func, array($params));
        $resp = $this->curl->post($serverurl, $post);
        $result = xmlrpc_decode($resp);

        $this->debugdata = "<pre>".PHP_EOL.
            "Serverurl: $serverurl".PHP_EOL.
            "Params:".PHP_EOL.
            print_r($params, true).
            PHP_EOL."Result (Raw):".
            print_r($resp, true).
            PHP_EOL."Result (Decoded):".
            print_r($result, true).
            PHP_EOL."</pre>";

        return $result;

    }
}

$client = new xmlrpc("ebd1167dbf865ac5186c3157469f5764", "http://ankit.moodle.local/stable/master/moodle/");
$params = array (
                'roleid' => 3,
                'userid' => 31,
                'contextlevel' => "course",
                'instanceid' => 2
                );

$client->wscall("core_role_assign_roles", array($params));
