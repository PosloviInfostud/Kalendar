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

        $data = [
            "id" => $this->input->post('id'),
            "name" => $this->input->post('name'),
            "type" => $this->input->post('type'),
            "description" => $this->input->post('description')
        ];
        
        $this->item->update($data);
        $message = 'success';

        // Send response to ajax
        echo $message;
        die();
    }
}