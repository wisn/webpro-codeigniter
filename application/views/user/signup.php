<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

Signup

<?php echo form_open('user/signup'); ?>
  <input type="text" name="email" placeholder="email" required />
  <input type="text" name="username" placeholder="username" required />
  <input type="text" name="fullname" placeholder="fullname" />
  <input type="password" name="password" placeholder="password" required />
  <input type="submit" />
</form>

<br>

<?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
<?php   print_r($msg); ?>
<?php endif; ?>
