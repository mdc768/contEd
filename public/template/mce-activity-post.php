<?php

// =============================================================================
// MCE-ACTIVITY-POST.PHP
// -----------------------------------------------------------------------------
// Single MCE post output.
// =============================================================================

$fullwidth = get_post_meta( get_the_ID(), '_x_post_layout', true );

?>

<?php get_header(); ?>

<!-- template/mce-activity-post.php -->

<style>
  .mce-more { text-align: center; }
</style>

<?php
    /* Get user info. */
    global $current_user, $wp_roles;
    $current_user = wp_get_current_user();

    if(is_user_logged_in()) {
      ?>
      <style>
      .mce-rec p span {
        width: 35%;
        display: inline-block;
      }
      @media print {
        .x-navbar-wrap, .x-sidebar.right, footer, .mce-img-upload {
          display:none;
        }
      }
      </style>
      <div class="x-container max width offset">
        <div class="<?php x_main_content_class(); ?>" role="main">

          <?php while ( have_posts() ) : the_post(); ?>

	          <?php if ($current_user->ID == $post->post_author) { ?>
              <div class="entry-wrap">

                <header class="entry-header">
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <p class="p-meta">
                      <span><i class="x-icon-pencil" data-x-icon=""></i> Michael Clarke</span>
                      <span><time class="entry-date" datetime="<?php echo get_post_time('c', true);?>"><i class="x-icon-calendar" data-x-icon=""></i> <?php the_time('F jS, Y'); ?></time></span>
                    </p>
                </header>


                <div class="entry-content content mce-rec">


                  <p><?php the_content(); ?></p>

                  <?php
                  $post_custom_cat                   = get_post_custom($mce_activity_cat_ID);
                  $post_custom_period                = get_post_custom($mce_report_period_ID);
                  ?>

                  <p><span>Activity Name:</span><?php echo get_post_meta($post->ID, 'mce_activity_name', true); ?></p>
                  <p><span>Activity Hours/Instances:</span><?php echo get_post_meta($post->ID, 'mce_activity_hours', true); ?></p>
                  <p><span>Activity Date:</span><?php echo get_post_meta($post->ID, 'mce_activity_date', true); ?></p>
                  <p><span>Activity Description:</span><?php echo get_post_meta($post->ID, 'mce_activity_desc', true); ?></p>
                  <p><span>Activity Cat:</span><?php echo get_post_meta($mce_activity_cat_ID, 'mce_activity_cat_ID', true); ?></p>
                  <p><span>Activity Period:</span><?php echo get_post_meta($post->ID, 'mce_report_period_ID', true); ?></p>
                  <p><span>User:</span><?php echo get_post_meta($post->ID, 'mce_activity_user_ID', true); ?></p>
                  <p><span>Activity Audited:</span><?php echo get_post_meta($post->ID, 'mce_activity_audit', true); ?></p>

                  <?php echo mce_get_images(); ?>

                </div>

                <div class="mce-img-upload">
                  <?php echo do_shortcode( '[fu-upload-form form_layout="media" title="Upload your supporting documents" append_to_post="true"]' ); ?>
                </div>

                <p class="mce-more"><a href="/web/continuing-education/" title="go to Cont Ed listing page">Return to Continuing Education page</a></p>

              </div>
            <?php } else { ?>
              <h3>Unauthorised Post Access</h3>
              <p>This activity belongs to a different user, you may only view your own activities</p>
            <?php } ?>

          <?php endwhile; ?>

        </div>

        <?php if ( $fullwidth != 'on' ) : ?>
          <?php get_sidebar(); ?>
        <?php endif; ?>

      </div>

    <?php } else { ?>
      <div class="x-container max width offset">
        <h3>We are sorry but this area is for OALA members only</h3>
        <p>This is the members area of the OALA. If you are a member please use the "MEMBER LOGIN" link at the top of the page or here, <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="OALA member login">Login now.</a></p>
      </div>
      <?php if ( $fullwidth != 'on' ) : ?>
        <?php get_sidebar(); ?>
      <?php endif; ?>
    <?php } ?>

    <?php get_footer(); ?>
