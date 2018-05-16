<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('User_model', 'user');
  }

  public function signup() {
    if ($this->session->userdata('user') != NULL)
      redirect('user/profile');

    $data = [
      'page' => 'user/signup',
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
    if ($this->session->userdata('user') != NULL)
      redirect('user/profile');

    $data = [
      'page' => 'user/signin',
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

  public function signout() {
    $this->session->unset_userdata('user');

    redirect('/');
  }

  public function profile() {
    $data = [
      'page' => 'user/profile',
      'title' => 'User Profile',
      'user' => $this->session->userdata('user')
    ];

    $this->load->view('user/profile', $data);
  }

  public function inquiries() {
    if ($this->session->userdata('user') == NULL)
      redirect('user/signin');

    $this->load->model('Inquiry_model', 'inquiry');

    $user = $this->session->userdata('user');

    $data = [
      'page' => 'user/inquiries',
      'title' => 'User Inquiries',
      'inquiries' => $this->inquiry->allByEmail($user->email)
    ];

    $this->load->view('user/inquiries', $data);
  }

  public function change_password() {
    if ($this->input->method() != 'post')
      redirect('user/signin');
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['password']) < 4)
        array_push($msg, 'Password at least four characters.');

      if ($post['password'] != $post['confirm-password'])
        array_push($msg, 'New Password and Confirm Password does not match.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $id = $this->session->userdata('user')['user_id'];
        $action = $this->user->replacePassword($id, $post['password']);

        if (!$action)
          $this->session->set_flashdata('msg', [
            'There is problem when updating your password. Please try again.'
          ]);
        else
          $this->session->set_flashdata('success', 'Password updated');
      }

      redirect('user/profile');
    }
  }

  public function update_profile() {
    if ($this->input->method() != 'post')
      redirect('user/signin');
    else {
      $msg = [];
      $post = $this->input->post(NULL, TRUE);

      if (strlen($post['fullname']) < 3)
        array_push($msg, 'Full Name at least three characters.');

      if (strlen($post['address']) < 10)
        array_push($msg, 'Address at least ten characters.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $id = $this->session->userdata('user')->user_id;
        $action = $this->user->updateProfile($id, $post);

        if (!$action)
          $this->session->set_flashdata('msg', [
            'There is problem when updating your password. Please try again.'
          ]);
        else {
          $this->session->set_userdata('user', $this->user->getById($id)[0]);
          $this->session->set_flashdata('success', 'Profile updated');
        }
      }

      redirect('user/profile');
    }
  }

  public function open_inquiry() {
    if ($this->input->method() != 'post')
      redirect('user/signin');
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

        if ($this->inquiry->isAlreadyOpened($post))
          $this->session->set_flashdata('msg', [
            'This inquiry already opened before.'
          ]);
        else {
          $query = $this->inquiry->new($post);

          if ($query)
            $this->session->set_flashdata('success', 'Inquiry has been sent.');
          else
            array_push($msg, 'Can\'t send it. Internal error.');

          $this->session->set_flashdata('msg', $msg);
        }
      }

      $this->session->set_flashdata('post', $post);
      redirect('user/inquiries');
    }
  }

  public function books() {
    if ($this->session->userdata('user') == NULL)
      redirect('user/signin');

    $this->load->model('Book_model', 'book');

    $user = $this->session->userdata('user');

    $data = [
      'page' => 'user/books',
      'title' => 'User Books',
      'books' => $this->book->allByUserId($user->user_id)
    ];

    $this->load->view('user/books', $data);
  }

  public function sell_book() {
    if ($this->input->method() != 'post')
      redirect('user/signin');
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

      if ($stock < 1)
        array_push($msg, 'Book stock at least must be one.');

      if (!empty($msg))
        $this->session->set_flashdata('msg', $msg);
      else {
        $this->load->model('Book_model', 'book');
        $post['user_id'] = $this->session->userdata('user')->user_id;

        $query = $this->book->new($post);

        if ($query) {
          $this->session->set_flashdata('success', 'Book added.');
          $post = [];
        }
        else
          array_push($msg, 'Can\'t send it. Internal error.');

        $this->session->set_flashdata('msg', $msg);
      }

      $this->session->set_flashdata('post', $post);
      redirect('user/books');
    }
  }

  public function orders() {
    $this->load->model('Order_model', 'order');
    $data = [
      'page' => 'user/orders',
      'title' => 'User Orders',
      'in' => $this->order->in(),
      'out' => $this->order->out()
    ];

    $this->load->view('user/orders', $data);
  }
}
