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
          <h3>Inquiries</h3>
          <div style="padding: .5em"></div>
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
              <h5>Inquiry List</h5>
              <div style="padding: .5em"></div>
              <?php if (count(@$inquiries) < 1): ?>
                There is no inquiry from you.
              <?php else: ?>
                <?php foreach ($inquiries as $inquiry): ?>
                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">
                        <?php echo $inquiry->title; ?>
                      </h5>
                      <h6 class="card-subtitle mb-2 text-muted">
                        <?php echo $inquiry->created_at; ?>&nbsp;
                        <?php if (!$inquiry->resolved): ?>
                          <span class="badge badge-success">opened</span>
                        <?php else: ?>
                          <span class="badge badge-danger">closed</span>
                        <?php endif; ?>
                      </h6>
                      <p class="card-text">
                        <?php echo $inquiry->body; ?>
                      </p>
                      <a href="<?php echo base_url(); ?>inquiry/edit/<?php echo $inquiry->inquiry_id; ?>">Edit</a>
                    </div>
                  </div>
                  <br>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <h5>Update Inquiry</h5>
              <?php echo form_open('inquiry/edit/'. $current->inquiry_id); ?>
                <div class="form-group">
                  <small class="form-text text-muted">Title</small>
                  <input name="title" type="text" class="form-control" value="<?php if (isset($post['title'])) echo $post['title']; else echo $current->title; ?>" required>
                </div>
                <div class="form-group">
                  <small class="form-text text-muted">Status</small>
                  <select class="form-control" name="resolved">
                    <option value="0" <?php if (!$current->resolved) echo 'selected'; ?>>Open</option>
                    <option value="1" <?php if ($current->resolved) echo 'selected'; ?>>Close</option>
                  </select>
                </div>
                <div class="form-group">
                  <small class="form-text text-muted">Description</small>
                  <textarea name="body" class="form-control" rows="5" required><?php if (isset($post['body'])) echo $post['body']; else echo $current->body; ?></textarea>
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
