<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inquiry extends CI_Controller {
  public function __construct() {
    parent::__construct();

    $this->load->model('Inquiry_model', 'inquiry');
  }

  public function edit($id) {
    if ($this->input->method() != 'post') {
      $user = $this->session->userdata('user');

      $data = [
        'page' => 'user/inquiries',
        'title' => 'User Inquiries',
        'current' => $this->inquiry->getById($id)[0],
        'inquiries' => $this->inquiry->allByEmail($user->email)
      ];

      $this->load->view('inquiry/edit', $data);
    }
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['title']) < 10)
        array_push($msg, 'Makes sure the title clear enough.');

      if (strlen($post['body']) < 25)
        array_push($msg, 'Describe the issue as clear as possible.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $this->load->model('Inquiry_model', 'inquiry');
        $post['email'] = $this->session->userdata('user')->email;

        $query = $this->inquiry->update($id, $post);

        if ($query) {
          $this->session->set_flashdata('success', 'Inquiry updated.');
          redirect('user/inquiries');
        }
        else
          array_push($msg, 'Can\'t update. Internal error.');

        $this->session->set_flashdata('msg', $msg);
      }

      $this->session->set_flashdata('post', $post);
      redirect('inquiry/edit/'. $id);
    }
  }
}
