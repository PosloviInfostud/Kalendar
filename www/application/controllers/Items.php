<?php
class Items extends CI_Controller
{
    public function __construct()
    {
            parent::__construct();
            $this->load->model('Item_model', 'item');
            $this->load->library('form_validation');
            $this->load->library('alerts');
    }

    public function insert_room()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('capacity', 'Capacity', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $message = '';

        if($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "name" => $this->input->post('name'),
                "capacity" => $this->input->post('capacity'),
                "description" => $this->input->post('description'),
                "color" => $this->input->post('color')
            ];

        $this->item->insert_room($data);
        $message = 'success';
        // Notification
        $msg = $this->alerts->render('green', 'Success', 'New room added.');
        $this->session->set_flashdata('flash_message', $msg);
        
        }

        echo $message;
        die();
    }

    public function edit_room()
    {
        $id = $this->input->post('room_id');
        $room = $this->item->get_single_room($id);

        // send view to ajax
        $form = $this->load->view('admin/items/update_room', ['room' => $room], TRUE);
        echo $form;
        die();
    }

    public function update_room()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('capacity', 'Capacity', 'required');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "id" => $this->input->post('id'),
                "name" => $this->input->post('name'),
                "capacity" => $this->input->post('capacity'),
                "description" => $this->input->post('description'),
                "color" => $this->input->post('color')
            ];

            $this->item->update_room($data);
            $message = 'success';
            // Notification
            $msg = $this->alerts->render('green', 'Success', 'Room updated.');
            $this->session->set_flashdata('flash_message', $msg);
        }

        // Send response to ajax
        echo $message;
        die();
    }

    public function insert_equipment()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('barcode', 'Barcode', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $message = '';

        if($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "name" => $this->input->post('name'),
                "barcode" => $this->input->post('barcode'),
                "type" => $this->input->post('type'),
                "description" => $this->input->post('description')
            ];

        $this->item->insert_equipment($data);
        $message = 'success';
        // Notification
        $msg = $this->alerts->render('green', 'Success', 'New item added.');
        $this->session->set_flashdata('flash_message', $msg);
        }

        echo $message;
        die();
    }

    public function edit_equipment()
    {
        $id = $this->input->post('equipment_id');
        $data = [
            'equipment' => $this->item->get_single_equipment($id),
            'types' => $this->item->get_all_equipment_types()
        ];

        // send view to ajax
        $form = $this->load->view('admin/items/update_equipment', $data, TRUE);
        echo $form;
        die();
    }

    public function update_equipment()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('barcode', 'Barcode', 'required|trim');
        $this->form_validation->set_rules('description', 'Description', 'trim');

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "id" => $this->input->post('id'),
                "name" => $this->input->post('name'),
                "barcode" => $this->input->post('barcode'),
                "type" => $this->input->post('type'),
                "description" => $this->input->post('description')
            ];

            $this->item->update_equipment($data);
            $message = 'success';
            // Notification
            $msg = $this->alerts->render('green', 'Success', 'Item updated.');
            $this->session->set_flashdata('flash_message', $msg);
        }

        // Send response to ajax
        echo $message;
        die();
    }

    public function insert_type()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $message = '';

        if($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "name" => $this->input->post('name'),
            ];
        $this->item->insert_type($data);
        $message = 'success';
        }

        echo $message;
        die();
    }

    public function edit_type()
    {
        $id = $this->input->post('type_id');
        $data = [
            'type' => $this->item->get_single_equipment_type($id)
        ];

        // send view to ajax
        $form = $this->load->view('admin/items/update_type', $data, TRUE);
        echo $form;
        die();
    }

    public function update_type()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
        } else {
            $data = [
                "id" => $this->input->post('id'),
                "name" => $this->input->post('name'),
            ];

            $this->item->update_type($data);
            $message = 'success';
        }
        // Send response to ajax
        echo $message;
        die();
    }
}