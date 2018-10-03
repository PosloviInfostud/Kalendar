<?php

class Reservations extends CI_Controller
{
    public function index()
    {
        $this->load->model('Reservation_model','reservations');
        $this->reservations->invite_members(1);
    }

}