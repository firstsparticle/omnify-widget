<br/>
<br/>
<br/>
<hr/>

<div class="container" style="width:70%;">
  <h2>Your Widgets</h2>
  <hr>
  <p>Press 'Copy' button to copy the identifier of the particular widget. Paste the identifier wherever you want in the Wordpress page you created. The button/iframe will show once the page is published.</p>
  <div class="panel panel-default">
    <div class="panel-body">
      <table class="table" style="margin-top: 10px">
        <thead>
          <tr>
            <th>#</th>
            <th>Action</th>
            <th>Widget</th>
            <th>Shortcode</th>
            <th>Widget Controls</th>
          </tr>
        </thead>
        <tbody>
<?php
    
$args = array(
    'post_type' => 'omnify_widget'
);

$loop = new WP_Query($args);

while($loop->have_posts()) {
    global $post;
    $loop->the_post();
?>
          <tr>
            <td><b>1</b></td>
            <td><?php echo $post->post_excerpt; ?></td>
            <td><?php echo $post->post_title; ?></td>
            <td>
              <div class="row">
                <div class="col-lg-12">
                  <div class="input-group">
                    <input type="text" class="form-control shortcode" value="<?php echo get_post_meta($post->ID, 'shortcode', true); ?>" disabled />
                    <div class="input-group-btn copy-shortcode">
                      <button type="button" class="btn btn-primary">
                        Copy
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <td>
              <button class="btn btn-warning">View Code</button>
              <button class="btn btn-danger">Delete</button>
            </td>
          </tr>
<?php
}
?>
        </tbody>
      </table>
    </div>
  </div>
</div>
