<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('partials/head'); ?>
<body class="page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="container">
      <?php if (count($books) < 1): ?>
        <h6 align="center">
          Currently, there is no used book available.
        </h6>
      <?php else: ?>
        <div class="row">
          <?php foreach ($books as $book):
                  $img = $book->cover == NULL ? 'book-lineart.png' : $book->cover;
          ?>
            <div class="col-md-3">
              <div class="card" style="margin-bottom: 1em">
                <img class="card-img-top" src="<?php echo base_url(); ?>assets/img/<?php echo $img; ?>" href="<?php echo base_url(); ?>assets/img/<?php echo $img; ?>" alt="">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $book->title; ?></h5>
                  <h6 class="card-subtitle mb-2 text-muted">
                    <?php echo $book->created_at; ?>
                  </h6>
                  <p class="card-text">
                    Rp. <?php echo $book->price; ?><br>
                    By <?php echo $book->fullname; ?>
                  </p>
                  <div class="row">
                    <div class="col-sm-6">
                      <?php if ($this->session->userdata('carts') == NULL || !isset($this->session->userdata('carts')[$book->book_id])): ?>
                        <?php echo form_open('cart/add_book'); ?>
                          <input type="hidden" name="seller_id" value="<?php echo $book->user_id; ?>">
                          <input type="hidden" name="book_id" value="<?php echo $book->book_id; ?>">
                          <input type="hidden" name="title" value="<?php echo $book->title; ?>">
                          <input type="hidden" name="price" value="<?php echo $book->price; ?>">
                          <input type="hidden" name="fullname" value="<?php echo $book->fullname; ?>">
                          <input type="submit" class="btn btn-primary" value="Add Book">
                        </form>
                      <?php else: ?>
                        <a href="<?php echo base_url(); ?>cart/remove_book/<?php echo $book->book_id; ?>" class="btn btn-danger">Remove Book</a>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
