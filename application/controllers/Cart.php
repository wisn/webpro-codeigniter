<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Cart_model', 'cart');
  }

  public function add_book() {
    if ($this->input->method() == 'post') {
      $post = $this->input->post(NULL, TRUE);

      if ($this->session->userdata('user') != NULL) {
        $data = [
          'book_id' => $post['book_id'],
          'user_id' => $this->session->userdata('user')->user_id,
          'seller_id' => $post['seller_id']
        ];

        if (!$this->cart->exists($data))
          $this->cart->new($data);
      }

      $carts = [];
      if ($this->session->userdata('carts') != NULL)
        $carts = $this->session->userdata('carts');

      $cart = [
        'title' => $post['title'],
        'price' => $post['price'],
        'fullname' => $post['fullname'],
        'book_id' => $post['book_id']
      ];
      $carts[$post['book_id']] = $cart;

      $this->session->set_userdata('carts', $carts);
    }

    redirect('book/list');
  }

  public function remove_book($book_id) {
    $carts = [];
    if ($this->session->userdata('carts') != NULL)
      $carts = $this->session->userdata('carts');

    unset($carts[$book_id]);
    if ($this->session->userdata('user') != NULL) {
      $data = [
        'book_id' => $book_id,
        'user_id' => $this->session->userdata('user')->user_id,
      ];

      if ($this->cart->exists($data))
        $this->cart->remove($data);
    }

    $this->session->set_userdata('carts', $carts);

    redirect('book/list');
  }
}