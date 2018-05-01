<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

Signin

<?php echo form_open('user/signin'); ?>
  <input type="text" name="identifier" placholder="identifier" required>
  <input type="password" name="password" placholder="password" required>
  <input type="submit">
</form>

<?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
<?php   print_r($msg); ?>
<?php endif; ?>
