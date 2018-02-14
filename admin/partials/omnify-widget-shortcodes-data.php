<div id="active-widgets"></div>
<div class="col-md-12">
    <div class="onboard-flow">
        <div class="onboard-body top-padding">
            <?php
            $args = array(
                'post_type' => 'omnify_widget',
                'orderby' => 'ID',
                'order'   => 'DESC',
            );
            $loop = new WP_Query($args);
            if ($loop->have_posts()) {
                ?>
                <h2 class="settings-heading">Active Widgets</h2>
                <p>Press 'Copy' button to copy the identifier of the particular widget. Paste the identifier
                    wherever you want in
                    the Wordpress page you created. The button/iframe will show once the page is published.</p>
                <?php
                $count = 0;
                while ($loop->have_posts()) {
                    global $post;
                    $count++;
                    $loop->the_post();
                    $omnifyId = htmlentities(get_post_meta($post->ID, 'omnify_id', true));
                    ?>
                    <div class="web-settings-wrapper alt-card">
                        <div class="web-settings-heading-wrapper alt-flex">
                            <div class="website-settings-text-wrapper">
                                <div class="web-settings-heading alt-changes"><?php echo htmlentities(get_post_meta($post->ID, 'widget-title', true)) ?: $post->post_title; ?></div>
                                <div class="addn-info-text">Widget Type : <?php echo $post->post_title; ?> - <?php
                                    $in = ucfirst($post->post_excerpt);
                                    echo strlen($in) > 20 ? substr($in, 0, 17) . "..." : $in;
                                    ?></div>
                                <div class="addn-info-text">Last edited
                                    : <?php echo date('d F Y', strtotime($post->post_modified)); ?></div>
                            </div>
                            <div class="btn-control-wrapper">
                                <div class="btn-shortcode">
                                    <div class="input-group">
                                        <input type="text" class="form-control shortcode"
                                               id="shortcode-<?php echo $post->ID; ?>"
                                               value="<?php echo htmlentities(get_post_meta($post->ID, 'shortcode', true)); ?>"
                                               readonly/>
                                        <div class="input-group-btn copy-shortcode">
                                            <button type="button" class="btn btn-primary copy-shortcode-btn"
                                                    data-clipboard-target="#shortcode-<?php echo $post->ID; ?>">
                                                Copy
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if (strlen($omnifyId) > 2) { ?>
                                    <a href="<?php echo admin_url('options-general.php?page=omnify-widget&step=update-iframe&widget=' . $post->ID); ?>" class="add-website-filter-btn widget-edit enabled w-button">Edit</a>
                                <?php } ?> <?php
                                $textColor = htmlentities(get_post_meta($post->ID, 'service-category', true));
                                if ($textColor) { ?>
                                    <a href="<?php echo admin_url('options-general.php?page=omnify-widget&step=update-button&widget=' . $post->ID); ?>" class="add-website-filter-btn widget-edit enabled w-button">Edit</a>
                                <?php } ?>
                                <textarea class="widget-code"
                                          id="<?php echo "code-" . $post->ID; ?>"><?php echo htmlentities($post->post_content); ?></textarea>
                                <a href="#"
                                   class="add-website-filter-btn widget-edit delete-btn w-button delete-widget-btn"
                                   id="<?php echo "delete-" . $post->ID ?>" data-key="<?php echo $omnifyId; ?>">Delete</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
