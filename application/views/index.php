<!DOCTYPE html>
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Blog</title>
  </head>
 
<body>
  <h2>This is my blog</h2>
  <?php $this->load->view('blog/menu'); if($query):foreach($query as $post):?>
  <h4><?php echo $post->entry_name;?> (<?php echo $post->entry_date;?>)</h4>
  <?php echo $post->entry_body;?>
  <?php endforeach; else:?>
  <h4>No entry yet!</h4>
  <?php endif;?>
  </body>
  </html>
