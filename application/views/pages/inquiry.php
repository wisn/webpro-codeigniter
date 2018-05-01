<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$data = [];

if ($this->session->flashdata('data') != NULL)
  $data = $this->session->flashdata('data');
?>

Inquiry

<?php echo form_open('page/inquiry'); ?>
  <input type="email" name="email" placeholder="email" value="<?php if (isset($data['email'])) echo $data['email']; ?>" required>
  <input type="text" name="title" placeholder="title" value="<?php if (isset($data['title'])) echo $data['title']; ?>" required>
  <textarea name="body" required><?php if (isset($data['body'])) echo $data['body']; ?></textarea>
  <input type="submit">
</form>

<?php if (($msg = $this->session->flashdata('msg')) != NULL): ?>
<?php   print_r($msg); ?>
<?php endif; ?>
