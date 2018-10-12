<?php
class Errors extends MY_Controller
{
    public function index()
    {
        $this->load->view('404');
    }
}