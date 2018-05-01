<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry_model extends CI_Model {
  public function all() {
    return $this->db->get('inquiries')->result();
  }

  public function isAlreadyOpened($data) {
    $email = $data['email'];
    $title = $data['title'];

    $this->db->where(['email' => $email, 'title' => $title]);
    $result = $this->db->get('inquiries')->num_rows();

    if ($result < 1) return false;

    return true;
  }

  public function new($data) {
    $query = $this->db->insert('inquiries', $data);

    if ($query) return true;

    return false;
  }

  public function open($id) {
    $this->db->set('resolved', 0);
    $this->db->where('id', $id);
    $query = $this->db->update('inquiries');

    if ($query) return true;

    return false;
  }

  public function close($id) {
    $this->db->set('resolved', 1);
    $this->db->where('id', $id);
    $query = $this->db->update('inquiries');

    if ($query) return true;

    return false;
  }
}
