<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
  public function isEmailExists($email) {
    $this->db->where('email', $email);
    $result = $this->db->get('users')->num_rows();

    if ($result < 1) return false;

    return true;
  }

  public function isUsernameExists($username) {
    $this->db->where('username', $username);
    $result = $this->db->get('users')->num_rows();

    if ($result < 1) return false;

    return true;
  }

  public function signup($data) {
    $query = $this->db->insert('users', $data);

    if ($query) return true;

    return false;
  }

  public function signin($data) {
    $query = 'SELECT * FROM users WHERE ';
    $query .= '(email = \''. $data['identifier'] .'\' ';
    $query .= 'OR username = \''. $data['identifier'] .'\') ';
    $query .= 'AND password = \''. $data['password'] .'\'';

    $result = $this->db->query($query)->result();

    return $result;
  }

  public function getById($id) {
    $this->db->where('user_id', $id);
    return $this->db->get('users')->result();
  }

  public function replacePassword($id, $password) {
    $this->db->where('user_id', $id);
    return $this->db->set('users', ['password' => $password]);
  }

  public function updateProfile($id, $data) {
    $this->db->where('user_id', $id);
    $this->db->set('fullname', $data['fullname']);
    $this->db->set('address', $data['address']);
    return $this->db->update('users');
  }
}