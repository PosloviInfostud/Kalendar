<?php
    class Tag_model extends CI_Model
    {
        public function get_list()
        {
            $result = [];
            $sql = 'SELECT * FROM tags';
            $query = $this->db->query($sql);

            if($query->num_rows()) {
                $result = $query->result_array();
            };

            return $result;
        }

        public function get_tag_ids_by_post($id)
        {
            $result = [];
            $tags = [];
            $sql = 'SELECT * FROM post_tags WHERE post_id = ?';
            $query = $this->db->query($sql, [$id]);
            
            if($query->num_rows()) {
                $result = $query->result_array();
                foreach($result as $tag) {
                    $tags[] = $tag['tag_id'];
                }
            }
         return $tags;
        }
        public function get_tags_by_param($tags_array) 
        {
            // $results = [];
            // $sql = 'SELECT * FROM tags WHERE id IN (?)';
            // $tags_array = implode(", ", $tags_array);
            // $query = $this->db->query($sql, [$tags_array]);

            $results = [];
            $this->db->select("*");
            $this->db->where_in('id', $tags_array);
            $query = $this->db->get('tags');

            if($query->num_rows()) {
                $results = $query->result_array();
            }

            return $results;
        }
    }