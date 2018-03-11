<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://stoln.com
 * @since      1.0.0
 *
 * @package    Cont_Ed
 * @subpackage Cont_Ed/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
/*
function show_MCE_profile_fields( $user ) {

  echo 'show_MCE_profile_fields => cont-ed-admin-display.php';

	$mce_activity_list = get_mce_activity_list( $user->ID );

	if( $mce_activity_list ) {
		$mce_activities .='';
		foreach( $mce_activity_list as $s ) {

			$mce_activity_audit = get_post_meta( $s->ID, 'mce_activity_audit', true );

			if ($mce_activity_audit == 'yes') {
				$mce_activity_audit_lit = '  this activity has been audited';
			} else {
				$mce_activity_audit_lit = '';
			}

			$mce_activities .='<tr><td><a href="/wp-admin/post.php?post='.$s->ID.'&action=edit" title="edit this activity">'.$s->post_title.'</a></td><td>'.$mce_activity_audit_lit.'</td></tr>';
		}
	} else {
		$mce_activities .='<tr><td>No MCE Activities found for this user</td></tr>';
	}
	?>
	<h3><?php _e('MCE Activity Records', 'frontendprofile'); ?></h3>

	<table class="form-table">
		<?php echo $mce_activities; ?>
	</table>

<?php
 }
 */
/*
function mce_activity_details() {
  echo 'mce_activity_details => cont-ed-admin-display.php';
  global $post;
  $custom = get_post_custom($post->ID);
  $mce_activity_cat_ID  = $custom["mce_activity_cat_ID"][0];
  $mce_report_period_ID = $custom["mce_report_period_ID"][0];
  $mce_activity_name    = $custom["mce_activity_name"][0];
  $mce_activity_date    = $custom["mce_activity_date"][0];
  $mce_activity_desc    = $custom["mce_activity_desc"][0];
  $mce_activity_hours   = $custom["mce_activity_hours"][0];
  $mce_activity_user_ID = $custom["mce_activity_user_ID"][0];
  $mce_activity_audit   = $custom["mce_activity_audit"][0];
  $mce_audit_note       = $custom["mce_audit_note"][0];
  $mce_activity_credits = $custom["mce_activity_credits"][0];

  $member_company = get_the_author_meta( 'member_company', $user->ID );
  $mce_cat_list = get_mce_cat_list();

  $select_opts ='<select name="mce_activity_cat_ID" id="mce_activity_cat_ID">';
  if( $mce_cat_list ) {
    $select_opts .='<option value="">Please choose a Category</option>';
    foreach( $mce_cat_list as $s ) {
      if( $s->ID == $mce_activity_cat_ID ) {
        $selected = ' selected="selected"';
      } else {
        $selected = '';
      }
      $select_opts .='<option value="'.$s->ID.'"'.$selected.'>'.$s->post_title.'</option>';
    }
  } else {
    $select_opts .='<option value="" disabled="disabled">No Categories Found</option>';
  }
  $select_opts .='</select>';
  ?>

  <table class="form-table">
    <tr>
      <th><label for="mce_category"><?php _e('MCE Category', 'frontendprofile'); ?>:</label></th>
      <td>
        <?php echo $select_opts; ?>
      </td>
    </tr>
  </table>

  <?php

  $mce_user_list = get_users( 'orderby=nicename&role=subscriber' );
  $select_opts ='<select name="mce_activity_user_ID" id="mce_activity_user_ID">';
  if( $mce_user_list ) {
    $select_opts .='<option value="">Please choose a Member</option>';
    foreach( $mce_user_list as $s ) {
      if( $s->ID == $mce_activity_user_ID ) {
        $selected = ' selected="selected"';
      } else {
        $selected = '';
      }
      $select_opts .='<option value="'.$s->ID.'"'.$selected.'>'.$s->display_name.'</option>';
    }
  } else {
    $select_opts .='<option value="" disabled="disabled">No Members Found</option>';
  }
  $select_opts .='</select>';

  ?>

  <table class="form-table">
    <tr>
      <th><label for="mce_user"><?php _e('User', 'frontendprofile'); ?>:</label></th>
      <td>
        <?php echo $select_opts; ?>
      </td>
    </tr>
  </table>

  <p><label>Activity Name:</label><br />
  <input name="mce_activity_name" value="<?php echo $mce_activity_name; ?>" size="125" /></p>
  <p><label>Activity Date:</label><br />
  <input name="mce_activity_date" value="<?php echo $mce_activity_date; ?>" size="25" /></p>
  <p><label>Activity Hours:</label><br />
  <input name="mce_activity_hours" value="<?php echo $mce_activity_hours; ?>" size="25" /></p>
  <p><label>Activity Credits:</label><br />
  <input name="mce_activity_credits" value="<?php echo $mce_activity_credits; ?>" size="15" /></p>
  <p><label>Activity Description:</label><br />
  <textarea cols="150" rows="5" name="mce_activity_desc"><?php echo $mce_activity_desc; ?></textarea></p>

  <?php
  $mce_reporting_list = get_mce_report_list();

  $select_opts ='<select name="mce_report_period_ID" id="mce_report_period_ID">';
  if( $mce_reporting_list ) {
    $select_opts .='<option value="">Please choose a Reporting Period</option>';
    foreach( $mce_reporting_list as $s ) {
      if( $s->ID == $mce_report_period_ID ) {
        $selected = ' selected="selected"';
      } else {
        $selected = '';
      }
      $select_opts .='<option value="'.$s->ID.'"'.$selected.'>'.$s->post_title.'</option>';
    }
  } else {
    $select_opts .='<option value="" disabled="disabled">No Categories Found</option>';
  }
  $select_opts .='</select>';
  ?>

  <table class="form-table">
    <tr>
      <th><label for="mce_category"><?php _e('MCE Reporting Period', 'frontendprofile'); ?>:</label></th>
      <td>
        <?php echo $select_opts; ?>
      </td>
    </tr>
  </table>

  <?php
  if ( $mce_activity_audit != 'yes' ) {
    $mce_audit_chk_n = 'checked="checked"';
    $mce_audit_chk_y = '';
  } else {
    $mce_audit_chk_y = 'checked="checked"';
    $mce_audit_chk_n = '';
  }
  ?>

  <fieldset>
  <legend>Activity Audited:</legend>
  <p><label for="radio1"><input type="radio" name="mce_activity_audit" value="yes" <?php echo $mce_audit_chk_y; ?> id="radio1">yes</label><br />
  <label for="radio2"><input type="radio" name="mce_activity_audit" value="no" <?php echo $mce_audit_chk_n; ?> id="radio2">no</label></p>
  </fieldset>

  <p><label>Audit Notes:</label><br />
  <textarea cols="150" rows="5" name="mce_audit_note"><?php echo $mce_audit_note; ?></textarea></p>


  <?php
}

function mce_category_details() {
  echo 'mce_category_details => cont-ed-admin-display.php';
  global $post;
  $custom = get_post_custom($post->ID);
  $mce_category_desc                 = $custom["mce_category_desc"][0];
  $mce_category_disp_num             = $custom["mce_category_disp_num"][0];
  $mce_activity_max_credits          = $custom["mce_activity_max_credits"][0];
  $mce_activity_credit_multiplier    = $custom["mce_activity_credit_multiplier"][0];
  ?>

  <p><label>Category Details (not displayed to users):</label><br />
  <textarea cols="150" rows="5" name="mce_category_desc"><?php echo $mce_category_desc; ?></textarea></p>
  <p><label>Category Display Number:</label><br />
  <input name="mce_category_disp_num" value="<?php echo $mce_category_disp_num; ?>" size="25" /></p>
  <p><label>Activity Max Credits:</label><br />
  <input name="mce_activity_max_credits" value="<?php echo $mce_activity_max_credits; ?>" size="25" /></p>
  <p><label>Activity Credit Value:</label><br />
  <input name="mce_activity_credit_multiplier" value="<?php echo $mce_activity_credit_multiplier; ?>" size="25" /></p>

  <?php
}
*/

add_action("admin_init", "mce_activity_filters");

add_action( 'admin_init', 'edit_mce_activity_load' );

function edit_mce_activity_load() {
  //add_filter('manage_edit-mce_activity_columns', 'add_new_mce_activity_columns');
  add_filter( 'manage_edit-mce_activity_sortable_columns', 'my_mce_activity_sortable_columns' );
}

function my_mce_activity_sortable_columns( $columns ) {

  $columns['author']  = 'author';

  $columns['mce_report_period']  = 'mce_report_period_ID';
  $columns['mce_activity_audit'] = 'mce_activity_audit';
  $columns['mce_activity_hours'] = 'mce_activity_hours';
  $columns['mce_activity_cat_ID'] = 'mce_activity_cat_ID';

  return $columns;
}
/*
function add_new_mce_activity_columns($reporting_columns) {
  echo 'add_new_mce_activity_columns => cont-ed-admin-display.php';
  $new_columns['cb'] = '<input type="checkbox" />';

  $new_columns['title'] = _x('Activity Name', 'column name');
  $new_columns['author'] = __('Author');

  $new_columns['mce_activity_cat_ID'] = _x('Activity Category ID', 'column name');

  $new_columns['mce_activity_audit'] = _x('Audit', 'column name');
  $new_columns['mce_report_period'] = _x('Reporting Period', 'column name');

  $new_columns['mce_activity_hours'] = _x('Reported Hours', 'column name');

  $new_columns['date'] = _x('Date', 'column name');

  return $new_columns;
}
*/
add_action('manage_mce_activity_posts_custom_column', 'manage_mce_activity_columns', 10, 2);

function manage_mce_activity_columns($column_name, $post_id) {
  echo 'manage_mce_activity_columns => cont-ed-admin-display.php';
    global $wpdb;
    switch ($column_name) {
    case 'mce_activity_audit':
      echo get_post_meta( $post_id , 'mce_activity_audit' , true );
      break;
    case 'mce_activity_hours':
      echo get_post_meta( $post_id , 'mce_activity_hours' , true );
      break;
    case 'mce_report_period':
      $mce_report_period_ID = get_post_meta( $post_id , 'mce_report_period_ID' , true );
      $querystr = "
        SELECT wposts.post_title
        FROM $wpdb->posts AS wposts
        WHERE wposts.ID = $mce_report_period_ID
      ";
      $mce_report_period = $wpdb->get_results($querystr, OBJECT);
      echo $mce_report_period[0]->post_title;
      break;
    case 'mce_activity_cat_ID':
      echo get_post_meta( $post_id , 'mce_activity_cat_ID' , true );
      break;
    default:
      break;
    } // end switch
}

add_action( 'load-edit.php', 'edit_mce_activity_load' );

function edit_mce_activity_load() {
  add_filter( 'request', 'sort_mce_activity' );
}

function sort_mce_activity( $vars ) {
  if ( isset( $vars['post_type'] ) && 'mce_activity' == $vars['post_type'] ) {
    if ( isset( $vars['orderby'] ) && 'mce_report_period_ID' == $vars['orderby'] ) {
      $vars = array_merge(
        $vars,
        array(
          'meta_key' => 'mce_report_period_ID',
          'orderby' => 'meta_value_num'
        )
      );
    }
    if ( isset( $vars['orderby'] ) && 'mce_activity_audit' == $vars['orderby'] ) {
      $vars = array_merge(
        $vars,
        array(
          'meta_key' => 'mce_activity_audit',
          'orderby' => 'meta_value'
        )
      );
    }
    if ( isset( $vars['orderby'] ) && 'mce_activity_hours' == $vars['orderby'] ) {
      $vars = array_merge(
        $vars,
        array(
          'meta_key' => 'mce_activity_hours',
          'orderby' => 'meta_value_num'
        )
      );
    }
  }

  return $vars;
}
