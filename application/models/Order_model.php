<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {
  public function new($books) {
    $books_id = '';
    $sellers;

    $i = 0;
    $n = count($books);
    foreach ($books as $id => $book) {
      $books_id .= (string) $book['book_id'];

      if (!isset($sellers[$book['seller_id']]))
        $sellers[$book['seller_id']] = [];

      array_push($sellers[$book['seller_id']], $book['book_id']);

      if ($i < $n - 1) $books_id .= ' ';
      $i += 1;
    }

    $data = [
      'type' => 'out',
      'user_id' => $this->session->userdata('user')->user_id,
      'books_id' => $books_id
    ];

    $out = $this->db->insert('orders', $data);

    foreach ($sellers as $seller_id => $book_id) {
      $data = [
        'type' => 'in',
        'user_id' => $seller_id,
        'books_id' => join(' ', $book_id)
      ];

      $this->db->insert('orders', $data);
    }

    return $out;
  }

  public function in() {
    $user_id = $this->session->userdata('user')->user_id;
    $this->db->where('user_id', $user_id);
    $this->db->where('type', 'in');
    $orders = $this->db->get('orders')->result();

    foreach ($orders as $i => $order) {
      $array = preg_split('/ /', $order->books_id);
      $query = 'SELECT title FROM books WHERE book_id IN (';
      $query .= join(', ', $array). ')';
      $orders[$i]->books = $this->db->query($query)->result();
    }

    return $orders;
  }

  public function out() {
    $user_id = $this->session->userdata('user')->user_id;
    $this->db->where('user_id', $user_id);
    $this->db->where('type', 'out');
    $orders = $this->db->get('orders')->result();

    foreach ($orders as $i => $order) {
      $array = preg_split('/ /', $order->books_id);
      $query = 'SELECT title FROM books WHERE book_id IN (';
      $query .= join(', ', $array). ')';
      $orders[$i]->books = $this->db->query($query)->result();
    }

    return $orders;
  }
}
