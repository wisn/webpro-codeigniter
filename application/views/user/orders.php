<?php
defined('BASEPATH') OR exit('No direct script access allowed');
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
          <h3>Orders</h3>
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
              <h5>Orders In</h5>
              <div style="padding: .5em"></div>
              <?php if (count($in) < 1): ?>
                There is no order.
              <?php else: ?>
                <?php foreach ($in as $in): ?>
                  <div class="card">
                    <div class="card-body">
                      <h6 class="card-subtitle mb-2 text-muted">
                        <?php echo $in->created_at; ?>
                      </h6>
                      <div class="card-text">
                        <ol>
                          <?php foreach ($in->books as $book): ?>
                            <li><?php echo $book->title; ?></li>
                          <?php endforeach; ?>
                        </ol>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
            <div class="col-md-6">
              <h5>Orders Out</h5>
              <div style="padding: .5em"></div>
              <?php if (count($out) < 1): ?>
                There is no order.
              <?php else: ?>
                <?php foreach ($out as $out): ?>
                  <div class="card">
                    <div class="card-body">
                      <h6 class="card-subtitle mb-2 text-muted">
                        <?php echo $out->created_at; ?>
                      </h6>
                      <div class="card-text">
                        <ol>
                          <?php foreach ($out->books as $book): ?>
                            <li><?php echo $book->title; ?></li>
                          <?php endforeach; ?>
                        </ol>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>
