<?php
/**
 * Webservice test client for Moodle
 * @author Ankit Agarwal
 *
 */
abstract class wsclient {
    protected $token;
    protected $domain;
    public $func;
    protected $debug;
    public $prot;
    protected $debugdata;
    protected $curl;

    /**
     * Constructor
     *
     * @param $token
     * @param $domain
     * @param bool $debug
     */
    public function __construct($domain, $token, $debug = true) {
        $this->token = $token;
        $this->domain = $domain;
        $this->debug = $debug;
        $this->curl = new curl();
        if ($this->debug) {
            @ini_set('display_errors', '1');
            error_reporting(-1);
        }
    }

    /**
     * Make the ws api call
     *
     * @param $func
     * @param $params
     */
    public function wscall ($func, $params) {

        $post = $this->callwsapi($func, $params);
        if ($this->debug) {
            $this->set_debug_header();
            echo $this->debugdata;
        } else {
            $this->set_content_header();
            echo $post;
        }
    }

    /**
     * @param $func
     * @param $params
     *
     * @return bool
     */
    public abstract function callwsapi ($func, $params);

    /**
     * Set header for the response from ws.
     *
     * @return mixed
     */
    protected abstract function set_content_header();

    /**
     * Set header for debugging content.
     */
    protected function set_debug_header() {
        header('Content-Type: text/html');
    }

    /**
     * Set debug data.
     *
     * @param $data
     */
    protected function set_debugdata($data) {
        $this->debugdata = $data;
    }
}