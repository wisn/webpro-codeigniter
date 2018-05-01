<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {
  public function submit() {
    $data = [
      'title' => 'Sell Your Unsued Book'
    ];

    if ($this->input->method() != 'post')
      $this->load->view('books/submit', $data);
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['title']) < 1)
        array_push($msg, 'Book title still empty.');

      if (strlen($post['author']) < 1)
        array_push($msg, 'Book author still empty.');

      $price = (int) $post['price'];
      if ($price < 1)
        array_push($msg, 'Book price either empty or invalid.');

      if (!empty($msg)) {
        $this->session->set_flashdata('msg', $msg);
        $this->session->set_flashdata('post', $post);

        redirect('book/submit');
      }
      else {
        $config = [
          'upload_path' => './assets/img/',
          'allowed_types' => 'jpg|png',
          'max_size' => 1024,
          'file_name' => 'tmp-'. $post['cover']
        ];

        $this->load->library('upload', $config);

        if ($post['cover'] != '' && !$this->upload->do_upload('cover')) {
          $this->session->set_flashdata('msg', [
            'Problem when uploading book cover. '.
            strip_tags($this->upload->display_errors())
          ]);
          $this->session->set_flashdata('post', $post);

          redirect('book/submit');
        }
        else {
          $this->session->set_userdata('book', $post);

          redirect('user/signup');
        }
      }
    }
  }
}