<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php $this->view('partials/head'); ?>
<body class="home-page">
  <?php $this->view('partials/header'); ?>
  <main>
    <div class="poster big-poster">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/books-lineart.png" /></div>
          <div class="col-md-6">
            <div align="right">
              <h1>Buy Books</h1>
              <p>Buy high quality used book</p>
              <p class="sub">with a cheap price</p>
              <a href="<?php echo base_url(); ?>shop" class="special-button">Search Book</a>
              <div class="divider"></div>
              <div class="labels">
                <a href="<?php echo base_url(); ?>shop" class="label">Mathematics</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Physics</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Chemistry</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Biology</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Computer Science</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Economy</a>
                <a href="<?php echo base_url(); ?>shop" class="label">Sociology</a></div>
            </div>
          </div>
        </div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="row">
          <div class="col-md-6">
            <h1>Sell Book</h1>
            <p>Sell your old book that</p>
            <p class="sub">has not used anymore</p>
            <a href="<?php echo base_url(); ?>book/submit" class="special-button">Select Book</a></div>
          <div class="col-md-6">
            <img src="<?php echo base_url(); ?>assets/img/book-lineart.png" class="left" /></div>
        </div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="divider"></div>
        <div class="divider"></div>
        <h2 align="center">Love to write?</h2>
        <div align="center">
          <a href="javascript:;" class="special-button">Write Book</a></div>
        <div class="divider"></div>
        <div class="divider"></div>
      </div>
    </div>
    <?php $this->view('partials/carts'); ?>
  </main>
<?php $this->view('partials/footer'); ?>