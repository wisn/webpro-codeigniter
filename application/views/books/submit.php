<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$post = [];

if ($this->session->flashdata('post') != NULL)
  $post = $this->session->flashdata('post');
?>

<?php $this->view('partials/head'); ?>
<body class="sell-book-page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="poster big-poster">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/book-lineart.png" class="cover" />
            <div class="divider"></div>
            <div align="center">
              <?php echo form_open_multipart('book/submit'); ?>
                <label for="cover" class="special-button">Select Cover</label>
                <input type="file" id="cover" name="cover" accept=".jpg, .jpeg, .png" />
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div align="right">
              <h1>Sell Book</h1>
              <p>Sell your old book that</p>
              <p class="sub">has not used anymore</p>

              <?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
                <div class="alert alert-danger" style="margin-top: 2em; width: 60%; text-align: left">
                  Error occurred:
                  <ul>
                    <?php foreach ($msg as $m): ?>
                      <li><?php echo $m; ?></li>
                    <?php endforeach; ?>
                  </ul>
                </div>
              <?php endif; ?>

              <?php echo form_open_multipart('book/submit'); ?>
                <input type="text" name="title" placeholder="Title" value="<?php if (isset($post['title'])) echo $post['title']; ?>" required>
                <input type="text" name="author" placeholder="Author" value="<?php if (isset($post['author'])) echo $post['author']; ?>" required>
                <input type="text" name="price" placeholder="Price" value="<?php if (isset($post['price'])) echo $post['price']; ?>" required>
                <input type="submit" value="Sell" class="special-button">
              </form>
              <div class="alert alert-light"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
