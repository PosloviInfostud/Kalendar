<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Alerts
{
    private $CI; // CodeIgniter instance 
    private $title_for_layout = NULL; // Title for the page
    private $title_separator = ' | '; // The title separator
    private $header_includes = []; // Stuff that will be included in the header
    private $footer_includes = []; // Stuff that will be included in the footer

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function render($color, $title, $text)
    {
        $alert = $this->CI->load->view('alerts/default', ['color' => $color, 'title' => $title, 'text' => $text], TRUE);
        return $alert;
    }
}