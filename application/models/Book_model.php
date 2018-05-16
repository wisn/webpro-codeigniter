<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book_model extends CI_Model {
  public function all($id = 0) {
    $this->db->select('books.*, users.fullname');
    $this->db->where('stock >', '0');
    $this->db->join('users', 'books.user_id = users.user_id');
    $this->db->order_by('price', 'ASC');
    if ($id > 0) $this->db->where('books.user_id !=', $id);

    return $this->db->get('books')->result();
  }

  public function new($book) {
    $this->db->where('user_id', $book['user_id']);
    return $this->db->insert('books', $book);
  }

  public function remove($id) {
    $this->db->where('book_id', $id);
    return $this->db->delete('books');
  }

  public function getById($id) {
    $this->db->where('book_id', $id);
    return $this->db->get('books')->result();
  }

  public function allByUserId($id) {
    $this->db->where('user_id', $id);
    $this->db->order_by('stock', 'ASC');
    return $this->db->get('books')->result();
  }

  public function update($id, $data) {
    $this->db->where('book_id', $id);
    $this->db->set('title', $data['title']);
    $this->db->set('author', $data['author']);
    $this->db->set('price', $data['price']);
    $this->db->set('stock', $data['stock']);

    return $this->db->update('books');
  }
}
