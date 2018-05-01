<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {
  public function index() {
    $this->load->view('pages/home');
  }

  public function inquiry() {
    if ($this->input->method() != 'post')
      $this->load->view('pages/inquiry');
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['email']) < 5)
        array_push($msg, 'Email doesn\'t valid.');

      if (strlen($post['title']) < 10)
        array_push($msg, 'Makes sure the title clear enough.');

      if (strlen($post['body']) < 25)
        array_push($msg, 'Describe the issue as clear as possible.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $this->load->model('Inquiry_model', 'inquiry');

        if ($this->inquiry->isAlreadyOpened($post))
          $this->session->set_flashdata('msg', [
            'This inquiry already opened before.'
          ]);
        else {
          $query = $this->inquiry->new($post);

          if ($query)
            array_push($msg, 'Inquiry has been sent.');
          else
            array_push($msg, 'Can\'t send it. Internal error.');

          $this->session->set_flashdata('msg', $msg);
          $post = [];
        }
      }

      $this->session->set_flashdata('data', $post);
      redirect('page/inquiry');
    }
  }
}
