<?php
class Items extends CI_Controller
{
    public function create()
    {
        $this->load->model('Item_model', 'item');

        $data = [
            "name" => $this->input->post('name'),
            "type" => $this->input->post('type'),
            "description" => $this->input->post('description')
        ];

        $this->item->insert($data);

        $message = 'success';

        echo $message;
        die();

    }

    public function edit()
    {
        $this->load->model('Item_model', 'item');
        $id = $this->input->post('item_id');
        $item = $this->item->get_single_item($id);
        $types = $this->item->get_all_item_types();

        // send view to ajax
        $form = $this->load->view('admin/items/update', ['item' => $item, 'types' => $types], TRUE);
        echo $form;
        die();
    }

    public function update()
    {
        $this->load->model('Item_model', 'item');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required|trim');

        $message = '';

        if ($this->form_validation->run() == false) {
            $message = validation_errors();

        } else {
            $data = [
                "id" => $this->input->post('id'),
                "name" => $this->input->post('name'),
                "email" => $this->input->post('email'),
                "role_id" => $this->input->post('role_id'),
                "active" => $this->input->post('active')
            ];
            
            $this->user->update($data);
            $message = 'success';
        }
        // Send response to ajax
        echo $message;
    }
}