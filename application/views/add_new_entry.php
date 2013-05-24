<!DOCTYPE html>
  <html>
  <head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Blog</title>
</head>
 
<body>
  <h2>Add new entry</h2>
  <?php echo validation_errors(); ?>
  <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');}?>
  <?php $this->load->view('blog/menu'); echo form_open('blog/add_new_entry');?>
  <p>Title:<br />
  <input type="text" name="entry_name" />
  </p>
  <p>Body:<br />
  <textarea name="entry_body" rows="5" cols="50" style="resize:none;"></textarea>
  </p>
  <input type="submit" value="Submit" />
  <?php echo form_close();?>
  </body>
  </html>
