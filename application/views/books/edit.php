<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$post = [];

if ($this->session->flashdata('post') != NULL)
  $post = $this->session->flashdata('post');
?>

<?php $this->view('partials/head'); ?>
<body class="page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="container">
      <div class="row">
        <div class="col-md-2">
          <?php $this->view('partials/dashboard_header'); ?>
        </div>
        <div class="col-md-10">
          <h3>Books</h3>
          <div style="padding: .5em"></div>
          <?php if (($msg = $this->session->flashdata('success')) != NULL): ?>
            <div class="alert alert-success" style="margin: 0 0 1em">
              <?php echo $msg; ?>
            </div>
          <?php endif; ?>
          <?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
            <div class="alert alert-danger" style="margin: 0 0 1em">
              Error occurred:
              <ul>
                <?php foreach ($msg as $m): ?>
                  <li><?php echo $m; ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-md-6">
              <h5>Book List</h5>
              <div style="padding: .5em"></div>
              <?php if (count(@$books) < 1): ?>
                There is no book from you.
              <?php else: ?>
                <?php foreach ($books as $book): ?>
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        <?php echo $book->title; ?>
                      </h5>
                      <h6 class="card-subtitle mb-2 text-muted">
                        <?php echo $book->created_at; ?>&nbsp;
                        <?php if ($book->stock > 0): ?>
                          <span class="badge badge-success"><?php echo $book->stock; ?> available</span>
                        <?php else: ?>
                          <span class="badge badge-danger">not available</span>
                        <?php endif; ?>
                      </h6>
                      <p class="card-text">
                        <?php echo $book->author; ?>
                      </p>
                      <a href="<?php echo base_url(); ?>book/edit/<?php echo $book->book_id; ?>">Edit</a>
                      <?php if ($book->stock < 1): ?>
                        &nbsp;
                        <a href="<?php echo base_url(); ?>book/remove/<?php echo $book->book_id; ?>" style="color: #ff0000" onclick="javascript: if(!confirm('Are you sure?')) return false;">Remove</a>
                      <?php endif; ?>
                    </div>
                  </div>
                  <br>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <h5>Sell Book</h5>
              <?php echo form_open('book/edit/'. $current->book_id); ?>
                <div class="form-group">
                  <small class="form-text text-muted">Title</small>
                  <input name="title" type="text" class="form-control" value="<?php if (isset($post['title'])) echo $post['title']; else echo $current->title; ?>" required>
                </div>
                <div class="form-group">
                  <small class="form-text text-muted">Author</small>
                  <input name="author" type="text" class="form-control" value="<?php if (isset($post['author'])) echo $post['author']; else echo $current->author; ?>" required>
                </div>
                <div class="row">
                  <div class="col-md-6 form-group">
                    <small class="form-text text-muted">Price</small>
                    <input name="price" type="text" class="form-control" value="<?php if (isset($post['price'])) echo $post['price']; else echo $current->price; ?>" required>
                  </div>
                  <div class="col-md-6 form-group">
                    <small class="form-text text-muted">Stock</small>
                    <input name="stock" type="text" class="form-control" value="<?php if (isset($post['stock'])) echo $post['stock']; else echo $current->stock; ?>" required>
                  </div>
                </div>
                <input type="submit" class="btn btn-primary" value="Update">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
