<?php
    class Post_model extends CI_Model
    {
        public function get_list()
        {
            $result = [];
            $sql = 'SELECT * FROM posts';
            $query = $this->db->query($sql);

            if($query->num_rows()) {
                $result = $query->result_array();
            } else {
                $result = FALSE;
            }

            return $result;
        }

        public function get_single_post_by_id($id)
        {
            $result = [];
            $sql = 'SELECT * FROM posts WHERE id = ?';
            $query = $this->db->query($sql, [$id]);

            if($query->num_rows()) {
                
                $result = $query->row_array();
            } else {
                $result = FALSE;
            }

            return $result;
        }

        public function create_post($data)
        {
            $sql = 'INSERT INTO posts (title, content) VALUES (?, ?)';
            $query = $this->db->query($sql, [$data['title'], $data['content']]);
            $last_post_id = $this->db->insert_id();
            return $last_post_id;

        }

        public function insert_tags($post_id, $tags)
        {
            $sql = 'INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)';

            foreach($tags as $tag) {
                $query = $this->db->query($sql, [$post_id, $tag]);
            };
        }

        public function update_post($data)
        {
            $sql = 'UPDATE posts SET title = ?, content = ? WHERE id = ?';
            $query = $this->db->query($sql, [$data['title'], $data['content'], $data['id']]);

        }

        public function delete_post_tags($id)
        {
            $sql = 'DELETE FROM post_tags WHERE post_id = ?';
            $query = $this->db->query($sql, [$id]);
        }

        public function delete_post($id)
        {
            $sql = 'DELETE FROM posts WHERE id = ?';
            $query = $this->db->query($sql, [$id]);
        }

        public function posts_by_tag($id)
        {
            $result = [];
            $posts = [];
            $sql = 'SELECT post_id FROM post_tags WHERE tag_id = ?';
            $query = $this->db->query($sql, [$id]);

            if($query->num_rows()) {
                $result = $query->result_array();
                foreach($result as $post) {
                    $posts[] = $post['post_id'];
                }
            }
            return $posts;
        }

        public function get_posts_by_param($posts_array)
        {
            $results = [];
            // $sql = 'SELECT * FROM posts WHERE id IN (?)';
            // $posts_array = implode(", ", $posts_array);
            // $query = $this->db->query($sql, [$posts_array]);
            // $results = $query->result_array();
            
            if(!empty($posts_array)) {
                $this->db->select("*");
                $this->db->where_in('id', $posts_array);
                $query = $this->db->get('posts');

                if($query->num_rows()) {
                    $results = $query->result_array();
                }
    
                return $results;
            } else {
                return $results;
            }
        }
    }