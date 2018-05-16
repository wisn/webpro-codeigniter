<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart_model extends CI_Model {
  public function new($post) {
    return $this->db->insert('carts', $post);
  }

  public function remove($post) {
    $this->db->where('book_id', $post['book_id']);
    $this->db->where('user_id', $post['user_id']);
    return $this->db->delete('carts');
  }

  public function clear($user_id) {
    $this->db->where('user_id', $user_id);
    return $this->db->delete('carts');
  }

  public function exists($post) {
    $this->db->where('user_id', $post['user_id']);
    $this->db->where('book_id', $post['book_id']);
    $count = $this->db->get('carts')->num_rows();

    return $count > 0;
  }
}
