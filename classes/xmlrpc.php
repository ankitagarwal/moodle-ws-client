<?php

/**
 * Class xmlrpc
 */
class xmlrpc extends wsclient {
    public $prot = "XMLRPC";

    public function callwsapi($func, $params) {

        $serverurl = $this->domain . '/webservice/xmlrpc/server.php'. '?wstoken=' . $this->token;
        $post = xmlrpc_encode_request($func, array($params));
        $resp = $this->curl->post($serverurl, $post);
        $result = xmlrpc_decode($resp);

        $data = "<pre>".PHP_EOL.
                           "Serverurl: $serverurl".PHP_EOL.
                           "Params:".PHP_EOL.
                           print_r($params, true).
                           PHP_EOL."Result (Raw):".
                           print_r($resp, true).
                           PHP_EOL."Result (Decoded):".
                           print_r($result, true).
                           PHP_EOL."</pre>";
        $this->set_debugdata($data);
        return $resp;
    }

    /**
     * Set header for the content.
     */
    protected function set_content_header() {
        header('Content-Type: text/xml');
    }
}
