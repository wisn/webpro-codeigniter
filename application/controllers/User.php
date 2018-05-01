<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('User_model', 'user');
  }

  public function signup() {
    $data = [
      'title' => 'Sign up to Bukube'
    ];

    if ($this->input->method() != 'post')
      $this->load->view('user/signup', $data);
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      $email = $post['email'];
      if (strlen($email) < 5)
        array_push($msg, 'Email doesn\'t valid.');
      else if ($this->user->isEmailExists($post['email']))
        array_push($msg, 'Email has been used.');

      $username = $post['username'];
      if (strlen($username) < 3)
        array_push($msg, 'Username at least three characters.');
      else if ($this->user->isUsernameExists($username))
        array_push($msg, 'Username has been used.');

      if (strlen($post['password']) < 4)
        array_push($msg, 'Password at least four characters.');
        
      if (!empty($msg)) {
        $this->session->set_flashdata('msg', $msg);

        redirect('user/signup');
      }
      else {
        $action = $this->user->signup($post);

        if ($action) {
          if (($book = $this->session->userdata('book')) != NULL) {
            $this->load->model('Book_model', 'book');
            $query = $this->book->new($book);

            if ($query)
              $this->session->unset_userdata('book');
            else
              $this->session->set_flashdata('msg', [
                'Fail to submit your book. Please signin then re-submit it.'
              ]);
          }

          redirect('user/signin');
        }
        else {
          $this->session->set_flashdata('msg', ['Ooops! Internal error.']);

          redirect('user/signup');
        }
      }
    }
  }

  public function signin() {
    $data = [
      'title' => 'Sign in to Bukube'
    ];

    if ($this->input->method() != 'post')
      $this->load->view('user/signin', $data);
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['identifier']) < 1)
        array_push($msg, 'Identifier still empty.');

      if (strlen($post['password']) < 1)
        array_push($msg, 'Password still empty.');

      if (!empty($msg)) {
        $this->session->set_flashdata('msg', $msg);

        redirect('user/signin');
      }
      else {
        $user = $this->user->signin($post);

        if (empty($user)) {
          array_push($msg, 'Credentials does\'t match.');
          $this->session->set_flashdata('msg', $msg);

          redirect('user/signin');
        }
        else {
          $this->session->set_userdata('user', $user[0]);

          redirect('user/profile');
        }
      }
    }
  }
}
