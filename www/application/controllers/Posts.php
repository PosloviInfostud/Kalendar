<?php
class Posts extends CI_Controller
{
    public function index()
    {
        if (isset($this->session->userdata['user_name'])) {

            $this->load->model('Post_model', 'post');

            $data = [
                'posts' => $this->post->get_list(),
                'title' => 'Latest Blog Posts',
            ];

            $this->load->view('templates/header');
            $this->load->view('posts/main', $data);
            $this->load->view('templates/footer');

        } else {
            $this->load->view('templates/header');
            $this->load->view('templates/not-allowed');
            $this->load->view('templates/footer');
        }
    }

    public function single_post($id)
    {
        $this->load->model('Post_model', 'post');
        $this->load->model('Tag_model', 'tags');

        $tag_ids = $this->tags->get_tag_ids_by_post($id);
        $tag_names = $this->tags->get_tags_by_param($tag_ids);

        $data = [
            'post' => $this->post->get_single_post_by_id($id),
            'tags' => $tag_names
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('posts/single', $data);
        $this->load->view('templates/footer');
    }

    public function create()
    {
        $this->load->model('Tag_model', 'tags');
        $data = [
            'tags' => $this->tags->get_list()
        ];

        $this->load->view('templates/header');
        $this->load->view('posts/create', $data);
        $this->load->view('templates/footer');

    }

    public function insert()
    {
        $data = [
            'title' => $this->input->post('post_title'),
            'content' => $this->input->post('post_content')
        ];

        $this->load->model('Post_model', 'post');

        $post_id = $this->post->create_post($data);
        $tags = $this->input->post('post_tags');

        $this->post->insert_tags($post_id, $tags);

        $this->load->helper('link_helper');
        url_redirect('/posts');

    }

    public function update($id)
    {
        $this->load->model('Post_model', 'post');
        $this->load->model('Tag_model', 'tags');

        $data = [
            'post' => $this->post->get_single_post_by_id($id),
            'tags' => $this->tags->get_tag_ids_by_post($id),
            'all_tags' => $this->tags->get_list()
        ];

        $this->load->view('templates/header');
        $this->load->view('posts/update', $data);
        $this->load->view('templates/footer');
    }

    public function update_post($id)
    {
        $this->load->model('Post_model', 'post');
        $this->load->model('Tag_model', 'tags');

        $data = [
            'title' => $this->input->post('post_title'),
            'content' => $this->input->post('post_content'),
            'tags' => $this->input->post('post_tags'),
            'id' => $id
        ];

        $this->post->update_post($data);
        $this->post->delete_post_tags($id);
        $this->post->insert_tags($id, $data['tags']);
        $this->load->helper('link_helper');
        url_redirect('/posts');
    }

    public function delete($id)
    {
        $this->load->model('Post_model', 'post');
        $this->post->delete_post($id);

        $this->load->helper('link_helper');
        url_redirect('/posts');
    }

    public function tags_index()
    {
        $this->load->model('Tag_model', 'tags');

        $data = ['tags' => $this->tags->get_list()];

        $this->load->view('templates/header');
        $this->load->view('/posts/tags/main', $data);
        $this->load->view('templates/footer');
    }

    public function posts_by_tag($id)
    {
        $this->load->model('Post_model', 'posts');
        $this->load->model('Tag_model', 'tags');
        $post_ids = $this->posts->posts_by_tag($id);

        $data = [
            'posts' => $this->posts->get_posts_by_param($post_ids),
            'tag' => $this->tags->get_tags_by_param($id)
        ];

        if ($this->input->is_ajax_request()) {
            echo json_encode($data);
            die();
        }
        $this->load->view('templates/header');
        $this->load->view('/posts/tags/single', $data);
        $this->load->view('templates/footer');
    }

}