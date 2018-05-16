<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Book_model', 'book');
  }

  public function list() {
    $userId;
    if ($this->session->userdata('user') != NULL)
      $userId = $this->session->userdata('user')->user_id;
    else
      $userId = 0;

    $data = [
      'page' => 'book/list',
      'title' => 'Buy Used Book Online',
      'books' => $this->book->all($userId)
    ];

    $this->load->view('books/list', $data);
  }

  public function submit() {
    $data = [
      'page' => 'book/submit',
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

  public function edit($id) {
    if ($this->input->method() != 'post') {
      $user = $this->session->userdata('user');

      $data = [
        'page' => 'user/books',
        'title' => 'User Books',
        'current' => $this->book->getById($id)[0],
        'books' => $this->book->allByUserId($user->user_id)
      ];

      $this->load->view('books/edit', $data);
    }
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['title']) < 5)
        array_push($msg, 'Book title won\'t that short.');

      if (strlen($post['author']) < 3)
        array_push($msg, 'Book author is less than three characters.');

      $price = (int) $post['price'];
      $stock = (int) $post['stock'];

      if ($price < 1)
        array_push($msg, 'Book price does not valid.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $query = $this->book->update($id, $post);

        if ($query) {
          $this->session->set_flashdata('success', 'Book updated.');
          redirect('user/books');
        }
        else
          array_push($msg, 'Can\'t update. Internal error.');

        $this->session->set_flashdata('msg', $msg);
      }

      $this->session->set_flashdata('post', $post);
      redirect('book/edit/'. $id);
    }
  }

  public function remove($id) {
    if (!empty($this->book->getById($id))) {
      $query = $this->book->remove($id);

      if ($query)
        $this->session->set_flashdata('success', 'Book removed.');
      else
        $this->session->set_flashdata('msg', [
          'Can\'t remove book. Internal error.'
        ]);
    }
    else
      $this->session->set_flashdata('msg', [
        'Book does not exists.'
      ]);

    redirect('user/books');
  }
}