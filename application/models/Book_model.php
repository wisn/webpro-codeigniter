<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {
  public function new($book) {
    $query = $this->db->insert('books', $book);

    if ($query) return true;

    return false;
  }
}
