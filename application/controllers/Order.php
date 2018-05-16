<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Order_model', 'order');
  }

  public function out() {
    if ($this->input->method() != 'post')
      redirect('book/list');
    else {
      $carts = $this->session->userdata('carts');

      if (count($carts) > 0) {
        if ($this->order->new($carts)) {
          $this->load->model('Cart_model', 'cart');
          $this->cart->clear($this->session->userdata('user')->user_id);
          $this->session->set_userdata('carts', []);

          $this->session->set_flashdata('success', 'Order success.');
        }
        else
          $this->session->set_flashdata('msg', [
            'Can\'t order. Internal error.'
          ]);
      }

      redirect('user/orders');
    }
  }
}
