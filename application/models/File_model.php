<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
 class File_model extends CI_Model {

    public function uploadImage($filename, $path, $username, $title) {

        $data = array(
            'filename' => $filename,
            'imagepath' => $path,
            'username' => $username,
            'title' => $title
        );
        $query = $this->db->insert('images', $data);
    }

    public function uploadVideo($filename, $path, $username, $title) {

        $data = array(
            'filename' => $filename,
            'videopath' => $path,
            'username' => $username,
            'title' => $title
        );
        $query = $this->db->insert('videos', $data);
    }

    function fetch_data($query) {
        if($query == '')
        {
            return null;
        }else{
            $this->db->select("*");
            $this->db->from("videos");
            $this->db->like('title', $query);
            $this->db->order_by('title', 'DESC');
            return $this->db->get();
        }
    }

    public function push() {
        $this->db->select("V.id, V.title, V.videopath, I.imagepath");
        $this->db->from("videos V");
        $this->db->join('images I', 'V.title = I.title');
        $this->db->order_by('V.id', 'DESC');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return "";
        } else {
            return $query->result_array();
        }
        
    }

    public function detail($id) {
        $this->db->select("id, title, videopath");
        $this->db->from("videos");
        $this->db->where('id', $id);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function validateTitle($title) {
        $this->db->select("*");
        $this->db->from("videos");
        $this->db->where('title', $title);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function comment($id) {
        $this->db->select("C.id, C.username, C.content, V.title");
        $this->db->from("comments C");
        $this->db->join('videos V', 'V.id = C.video_id');
        $this->db->where('video_id', $id);
        $this->db->order_by('C.id', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return "";
        } else {
            return $query->result_array();
        }
    }

    public function addComment($username, $video_id, $content) {
        $data = array(
            'username' => $username,
            'video_id' => $video_id,
            'content' => $content
        );
        $query = $this->db->insert('comments', $data);
    }
}
?>
