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
          <h3>Profile</h3>
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
              <h5>Edit Profile</h5>
              <?php echo form_open('user/update_profile'); ?>
                <div class="form-group">
                  <small class="form-text text-muted">Full Name</small>
                  <input name="fullname" type="text" class="form-control" value="<?php if (isset($post['fullname'])) echo $post['fullname']; else echo $user->fullname; ?>">
                </div>
                <div class="form-group">
                  <small class="form-text text-muted">Address</small>
                  <textarea name="address" class="form-control" rows="5"><?php if (isset($post['address'])) echo $post['address']; else echo $user->address ?></textarea>
                </div>
                <input type="submit" class="btn btn-primary" value="Update">
              </form>
            </div>
            <div class="col-md-6">
              <h5>Change Password</h5>
              <div style="padding: .5em"></div>
              <?php echo form_open('user/change_password'); ?>
                <div class="form-group">
                  <input class="form-control" type="password" name="password" placeholder="New Password" required>
                </div>
                <div class="form-group">
                  <input class="form-control" type="password" name="confirm-password" placeholder="Confirm Password" required>
                </div>
                <input type="submit" class="btn btn-primary" value="Change">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
