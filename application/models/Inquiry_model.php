<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry_model extends CI_Model {
  public function allByEmail($email) {
    $this->db->where('email', $email);
    $this->db->order_by('inquiry_id', 'DESC');
    return $this->db->get('inquiries')->result();
  }

  public function getById($id) {
    $this->db->where('inquiry_id', $id);
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

  public function update($id, $data) {
    $this->db->where('inquiry_id', $id);
    $this->db->set('title', $data['title']);
    $this->db->set('body', $data['body']);
    $this->db->set('resolved', $data['resolved']);

    $query = $this->db->update('inquiries');
    if ($query) return true;

    return false;
  }
}
