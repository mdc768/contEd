<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://stoln.com
 * @since      1.0.0
 *
 * @package    Cont_Ed
 * @subpackage Cont_Ed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Cont_Ed
 * @subpackage Cont_Ed/admin
 * @author     1304713 Ont Inc. <mdc.768@gmail.com>
 */
class Cont_Ed_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $cont_ed    The ID of this plugin.
	 */
	private $cont_ed;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $cont_ed       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $cont_ed, $version ) {

		$this->cont_ed = $cont_ed;
		$this->version = $version;

		$this->load_dependencies();
		$this->load_cust_post_types();
	  $this->load_taxonomies();
		$this->load_meta();
		$this->add_user_fields();
		$this->save_mce_fields();

		$this->add_mce_DBs();


	}
		/**
	 * Load the required dependencies for the Admin facing functionality.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wppb_Demo_Plugin_Admin_Settings. Registers the admin settings and page.
	 *
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) .  'admin/class-cont-ed-admin-settings.php';
	}

	/**
	 * Create some custom post types
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_cust_post_types() {
		add_action( 'init', 'create_MCE_post_types' );

		function create_MCE_post_types() {
			register_post_type( 'mce_activity',
				array(
						'labels' => array(
						'name' => __( 'MCE Activities' ),
						'singular_name' => __( 'MCE Activity' ),
						'add_new' => __( 'Add New' ),
						'add_new_item' => __( 'Add New MCE Activity' ),
						'edit' => __( 'Edit' ),
						'edit_item' => __( 'Edit MCE Activity' ),
						'new_item' => __( 'New MCE Activity' ),
						'view' => __( 'View MCE Activity' ),
						'view_item' => __( 'View MCE Activity' ),
						'search_items' => __( 'Search MCE Activities' ),
						'not_found' => __( 'No MCE Activities found' ),
						'not_found_in_trash' => __( 'No MCE Activities found in Trash' ),
						'parent' => __( 'Parent MCE Activity' ),
					),
					'public' => true,
					'show_ui' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => true,
					'menu_position' => 20,
					'hierarchical' => false,
					'supports' => array( 'title', 'editor', 'thumbnail' ),
					'description' => __('Create a new MCE Activity.'),
					'taxonomies' => array('post_tag','mce_activity'),
				)
			);
			register_post_type( 'mce_category',
				array(
						'labels' => array(
						'name' => __( 'MCE Categories' ),
						'singular_name' => __( 'MCE Category' ),
						'add_new' => __( 'Add New' ),
						'add_new_item' => __( 'Add New MCE Category' ),
						'edit' => __( 'Edit' ),
						'edit_item' => __( 'Edit MCE Category' ),
						'new_item' => __( 'New MCE Category' ),
						'view' => __( 'View MCE Category' ),
						'view_item' => __( 'View MCE Category' ),
						'search_items' => __( 'Search MCE Categories' ),
						'not_found' => __( 'No MCE Categories found' ),
						'not_found_in_trash' => __( 'No MCE Categories found in Trash' ),
						'parent' => __( 'Parent MCE Category' ),
					),
					'public' => true,
					'show_ui' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => true,
					'menu_position' => 20,
					'hierarchical' => true,
					'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
					'description' => __('Create a new MCE Category.'),
					'taxonomies' => array('post_tag','mce_category'),
				)
			);
			register_post_type( 'mce_report_period',
				array(
						'labels' => array(
						'name' => __( 'MCE Reporting Periods' ),
						'singular_name' => __( 'MCE Reporting Period' ),
						'add_new' => __( 'Add New' ),
						'add_new_item' => __( 'Add New MCE Reporting Period' ),
						'edit' => __( 'Edit' ),
						'edit_item' => __( 'Edit MCE Reporting Period' ),
						'new_item' => __( 'New MCE Reporting Period' ),
						'view' => __( 'View MCE Reporting Period' ),
						'view_item' => __( 'View MCE Reporting Period' ),
						'search_items' => __( 'Search MCE Reporting Periods' ),
						'not_found' => __( 'No MCE Reporting Periods found' ),
						'not_found_in_trash' => __( 'No MCE Reporting Periods found in Trash' ),
						'parent' => __( 'Parent MCE Reporting Period' ),
					),
					'public' => true,
					'show_ui' => true,
					'publicly_queryable' => true,
					'exclude_from_search' => true,
					'menu_position' => 20,
					'hierarchical' => false,
					'supports' => array( 'title', 'editor', 'thumbnail' ),
					'description' => __('Create a new MCE Reporting Period.'),
					'taxonomies' => array('post_tag','mce_report_period'),
				)
			);
		}
	}

	/**
	 * Load some taxonomies
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_taxonomies() {
		add_action( 'init', 'MCE_taxonomies' );

		function MCE_taxonomies(){
			register_taxonomy("mce_activity_type", array("mce_activity"), array("hierarchical" => true, "label" => "MCE Activity Types", "singular_label" => "MCE Activity Type", "rewrite" => true));
			register_taxonomy("mce_category_type", array("mce_category"), array("hierarchical" => true, "label" => "MCE Category Types", "singular_label" => "MCE Category Type", "rewrite" => true));
			register_taxonomy("mce_report_period_type", array("mce_report_period"), array("hierarchical" => true, "label" => "MCE Reporting Period Types", "singular_label" => "MCE Reporting Period Type", "rewrite" => true));
		}
	}

	/**
	 * Load the meta boxes
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	public function load_meta() {
		add_action("admin_init", "MCE_meta");

		function MCE_meta(){
			add_meta_box("mce_activity_meta", "Mandatory Continuing Ed. Activity Details", "mce_activity_details", "mce_activity", "normal", "low");
			add_meta_box("audit_date_meta", "Audit Date", "audit_date", "mce_activity", "side", "low");
			add_meta_box("mce_category_meta", "Mandatory Continuing Ed. Category Details", "mce_category_details", "mce_category", "normal", "low");
			add_meta_box("start_date_meta", "Start Date", "start_date", "mce_report_period", "side", "low");
			add_meta_box("end_date_meta", "End Date", "end_date", "mce_report_period", "side", "low");
			add_meta_box("att_thumb_meta", "Attached documents", "mce_attatched_img", "mce_activity", "side", "low");
			//add_filter('manage_edit-mce_activity_columns', 'add_new_mce_activity_columns');

			function mce_attatched_img() {
				global $post;
				$images =& get_children( array (
						'post_parent' => $post->ID,
						'post_type' => 'attachment',
						'post_mime_type' => 'image'
					));

					if ( empty($images) ) {
						// no attachments here
						echo "<p>Nope</p>";
					} else {
						foreach ( $images as $attachment_id => $attachment ) {
							echo wp_get_attachment_image( $attachment_id, 'thumbnail' );
						}
					}
			}

			function posting_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$posting_date = $custom["posting_date"][0];
				?>
				<label>Posting Date:</label>
				<input name="posting_date" id="picker_posting_date" value="<?php echo $posting_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_posting_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function deadline_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$deadline_date = $custom["deadline_date"][0];
				?>
				<label>Deadline Date:</label>
				<input name="deadline_date" id="picker_deadline_date" value="<?php echo $deadline_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_deadline_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function start_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$start_date = $custom["start_date"][0];
				?>
				<label>Start Date:</label>
				<input name="start_date" id="picker_start_date" value="<?php echo $start_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_start_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function end_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$end_date = $custom["end_date"][0];
				?>
				<label>End Date:</label>
				<input name="end_date" id="picker_end_date" value="<?php echo $end_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_end_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function expiry_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$expiry_date = $custom["expiry_date"][0];
				?>
				<label>End Date:</label>
				<input name="expiry_date" id="picker_expiry_date" value="<?php echo $expiry_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_expiry_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function audit_date(){
				global $post;
				$custom = get_post_custom($post->ID);
				$audit_date = $custom["audit_date"][0];
				?>
				<label>Audit Date:</label>
				<input name="audit_date" id="picker_audit_date" value="<?php echo $audit_date; ?>" />
				<script type="text/javascript">jQuery(document).ready(function(){jQuery("#picker_audit_date").datepicker({ dateFormat: 'yy-mm-dd' });});</script>
				<?php
			}

			function mce_activity_details() {
			  //echo 'mce_activity_details => cont-ed-admin-display. v0.1 ';
			  global $post;
			  $custom = get_post_custom($post->ID);
				//print_r($custom);

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

		}
	}

	/**
	 * Load the additional User fields
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function add_user_fields() {
		// this works
		 add_action( 'show_user_profile', 'show_MCE_profile_fields', 20 );
		 add_action( 'edit_user_profile', 'show_MCE_profile_fields', 20 );

		 function show_MCE_profile_fields( $user ) {

		  //echo 'show_MCE_profile_fields => class-cont-ed-admin.php';

		 	$mce_activity_list = get_mce_activity_list( $user->ID );

		 	if( $mce_activity_list ) {
		 		$mce_activities .='';

				$mce_activities .='<tr><th>Title</th><th>Name</th><th>Date</th><th>Description</th><th>Hours</th><th>Audited</th></tr>';

		 		foreach( $mce_activity_list as $s ) {

		 			$mce_activity_audit = get_post_meta( $s->ID, 'mce_activity_audit', true );

		 			if ($mce_activity_audit == 'yes') {
		 				$mce_activity_audit_lit = 'Yes';
		 			} else {
		 				$mce_activity_audit_lit = 'No';
		 			}

					$mce_activity_name  = get_post_meta( $s->ID, 'mce_activity_name', true );
					$mce_activity_date  = get_post_meta( $s->ID, 'mce_activity_date', true );
					$mce_activity_desc  = get_post_meta( $s->ID, 'mce_activity_desc', true );
					$mce_activity_hours = get_post_meta( $s->ID, 'mce_activity_hours', true );

					$mce_activities .='<tr><td><a href="/wp-admin/post.php?post='.$s->ID.'&action=edit" title="edit this activity">'.$s->post_title.'</a></td><td>'.$mce_activity_name.'</td><td>'.$mce_activity_date.'</td><td>'.$mce_activity_desc.'</td><td>'.$mce_activity_hours.'</td><td>'.$mce_activity_audit_lit.'</td></tr>';

		 			//$mce_activities .='<tr><td><a href="/wp-admin/post.php?post='.$s->ID.'&action=edit" title="edit this activity">'.$s->post_title.'</a></td><td>'.$mce_activity_audit_lit.'</td></tr>';
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

	}

	/**
	 * Save the additional MCE fields
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function save_mce_fields() {
		 add_action('save_post', 'save_mce_details');

		 function save_mce_details(){
 		   global $post;
 		   $post_id = $post->ID;

 		   if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
 		   return $post_id;

 		   if (isset($_POST["mce_activity_cat_ID"]) && $_POST["mce_activity_cat_ID"] <> '') update_post_meta($post->ID, "mce_activity_cat_ID", $_POST["mce_activity_cat_ID"]);
 		   if (isset($_POST["mce_report_period_ID"]) && $_POST["mce_report_period_ID"] <> '') update_post_meta($post->ID, "mce_report_period_ID", $_POST["mce_report_period_ID"]);
 		   if (isset($_POST["mce_activity_name"]) && $_POST["mce_activity_name"] <> '') update_post_meta($post->ID, "mce_activity_name", $_POST["mce_activity_name"]);
 		   if (isset($_POST["mce_activity_desc"]) && $_POST["mce_activity_desc"] <> '') update_post_meta($post->ID, "mce_activity_desc", $_POST["mce_activity_desc"]);
 		   if (isset($_POST["mce_activity_hours"]) && $_POST["mce_activity_hours"] <> '') update_post_meta($post->ID, "mce_activity_hours", $_POST["mce_activity_hours"]);
 		   if (isset($_POST["mce_activity_date"]) && $_POST["mce_activity_date"] <> '') update_post_meta($post->ID, "mce_activity_date", $_POST["mce_activity_date"]);
 		   if (isset($_POST["mce_activity_user_ID"]) && $_POST["mce_activity_user_ID"] <> '') update_post_meta($post->ID, "mce_activity_user_ID", $_POST["mce_activity_user_ID"]);
 		   if (isset($_POST["mce_activity_audit"]) && $_POST["mce_activity_audit"] <> '') update_post_meta($post->ID, "mce_activity_audit", $_POST["mce_activity_audit"]);
 		   if (isset($_POST["mce_audit_note"]) && $_POST["mce_audit_note"] <> '') update_post_meta($post->ID, "mce_audit_note", $_POST["mce_audit_note"]);
 		   if (isset($_POST["mce_activity_credits"]) && $_POST["mce_activity_credits"] <> '') update_post_meta($post->ID, "mce_activity_credits", $_POST["mce_activity_credits"]);

 		   if (isset($_POST["mce_category_desc"]) && $_POST["mce_category_desc"] <> '') update_post_meta($post->ID, "mce_category_desc", $_POST["mce_category_desc"]);
 		   if (isset($_POST["mce_category_disp_num"]) && $_POST["mce_category_disp_num"] <> '') update_post_meta($post->ID, "mce_category_disp_num", $_POST["mce_category_disp_num"]);
 		   if (isset($_POST["mce_activity_max_credits"]) && $_POST["mce_activity_max_credits"] <> '') update_post_meta($post->ID, "mce_activity_max_credits", $_POST["mce_activity_max_credits"]);
 		   if (isset($_POST["mce_activity_credit_multiplier"]) && $_POST["mce_activity_credit_multiplier"] <> '') update_post_meta($post->ID, "mce_activity_credit_multiplier", $_POST["mce_activity_credit_multiplier"]);

			 if (isset($_POST["posting_date"]) && $_POST["posting_date"] <> '') update_post_meta($post->ID, "posting_date", $_POST["posting_date"]);
			 if (isset($_POST["deadline_date"]) && $_POST["deadline_date"] <> '') update_post_meta($post->ID, "deadline_date", $_POST["deadline_date"]);
			 if (isset($_POST["start_date"]) && $_POST["start_date"] <> '') update_post_meta($post->ID, "start_date", $_POST["start_date"]);
			 if (isset($_POST["end_date"]) && $_POST["end_date"] <> '') update_post_meta($post->ID, "end_date", $_POST["end_date"]);
			 if (isset($_POST["expiry_date"]) && $_POST["expiry_date"] <> '') update_post_meta($post->ID, "expiry_date", $_POST["expiry_date"]);
			 if (isset($_POST["audit_date"]) && $_POST["audit_date"] <> '') update_post_meta($post->ID, "audit_date", $_POST["audit_date"]);

		}
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cont_Ed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cont_Ed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->cont_ed, plugin_dir_url( __FILE__ ) . 'css/cont-ed-admin.css', array(), $this->version, 'all' );

		wp_enqueue_style('jquery-style', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Cont_Ed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Cont_Ed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->cont_ed, plugin_dir_url( __FILE__ ) . 'js/cont-ed-admin.js', array( 'jquery' ), $this->version, false );

		wp_enqueue_script('jquery-ui-datepicker');

	}




	/**
	 * MCE DB functions
	 */
	 /**
 	 * Load the MCE DB functions
 	 *
 	 * @since    1.0.0
 	 * @access   public
 	 */
 	public function add_mce_DBs() {

		function get_mce_cat_list() {

			global $wpdb;

			$now = current_time('mysql', 1);

			$querystr = "
				SELECT wposts.ID, wposts.post_title, wposts.post_content
				FROM $wpdb->posts AS wposts
				WHERE wposts.post_type = 'mce_category'
				AND wposts.post_status = 'publish'
				AND wposts.post_title != 'Auto Draft'
				AND wposts.post_date <= '$now'
				ORDER BY wposts.post_title ASC
			";

			$category_list = $wpdb->get_results($querystr, OBJECT);

		 // echo $querystr;

			return $category_list;
		}

		function get_mce_report_list() {

		 global $wpdb;

		 $now = current_time('mysql', 1);

		 $querystr = "
			 SELECT wposts.ID, wposts.post_title, wposts.post_content
			 FROM $wpdb->posts AS wposts
			 WHERE wposts.post_type = 'mce_report_period'
			 AND wposts.post_status = 'publish'
			 AND wposts.post_title != 'Auto Draft'
			 AND wposts.post_date <= '$now'
			 ORDER BY wposts.post_title ASC
		 ";

		 $report_period_list = $wpdb->get_results($querystr, OBJECT);

		 return $report_period_list;
	 }

	 /**
 	 */
 	function get_mce_credits( $hours, $cat ) {

			$mce_credits                    = 0;

			if ( is_null( $hours ) ) {
				$mce_hours                     = 1;
			}
			if ( is_null( $cat ) ) {
				return 0;
			}

			$mce_activity_max_credits       = get_post_meta( $cat, 'mce_activity_max_credits', true );
			$mce_activity_credit_multiplier = get_post_meta( $cat, 'mce_activity_credit_multiplier', true );

			$mce_credits                    = $mce_activity_credit_multiplier * $hours;

			if ( is_numeric( $mce_activity_credit_multiplier ) ) {
				$mce_credits                   = $mce_activity_credit_multiplier * $hours;
				if ( is_numeric( $mce_activity_max_credits ) ) {
					if ( $mce_credits > $mce_activity_max_credits ) {
						$mce_credits                 = $mce_activity_max_credits;
					}
					if ( $mce_credits > 22.5 ) {
						$mce_credits                 = 22.5;
					}
				}
			}

		    return $mce_credits;
		}

		/**
		 */
		function get_mce_activity_list( $user_id = null, $date = null ) {

		global $wpdb;

		$now = current_time('mysql', 1);

		if ( is_numeric( $user_id ) ) {
			$mce_user_sql = " AND wpostmeta2.meta_key = 'mce_activity_user_ID' AND wpostmeta2.meta_value = '" . $user_id . "'";
	    } else {
	        $mce_user_sql = "";
	    }

	    if ( is_null( $date ) ) {
			$curr_report_period = get_mce_report_period();
			$mce_date_sql = " AND wpostmeta3.meta_key = 'mce_report_period_ID' AND wpostmeta3.meta_value = '" . $curr_report_period[0]->ID . "'";
	    } else {
	    	list( $data_year, $data_month, $data_day, $hour, $minute, $second ) = split( '([^0-9])', $date );
			$date_yyyy_mm_dd = $data_year . "-" . $data_month . "-" . $data_day;
			$curr_report_period = get_mce_report_period( $date_yyyy_mm_dd );
			$mce_date_sql = " AND wpostmeta3.meta_key = 'mce_report_period_ID' AND wpostmeta3.meta_value = '" . $curr_report_period[0]->ID . "'";
	    }

		$querystr = "
			SELECT DISTINCT wposts.*
			FROM $wpdb->posts AS wposts, $wpdb->postmeta AS wpostmeta, $wpdb->postmeta AS wpostmeta2, $wpdb->postmeta AS wpostmeta3
			WHERE wposts.ID = wpostmeta.post_id
			AND wposts.ID = wpostmeta2.post_id
			AND wposts.ID = wpostmeta3.post_id
			AND wposts.post_type = 'mce_activity'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			" . $mce_user_sql . "
			" . $mce_date_sql . "
			ORDER BY wposts.post_title ASC
		";

	  //echo $querystr;

		$activity_list = $wpdb->get_results($querystr, OBJECT);

		//print_r($activity_list);

		return $activity_list;
	}

	/**
	 */
	function get_mce_activity_list2( $user_id = null, $date = null ) {

		if ( is_null( $date ) ) {
			$curr_report_period = get_mce_report_period();
	    } else {
	    	list( $data_year, $data_month, $data_day, $hour, $minute, $second ) = split( '([^0-9])', $date );
			$date_yyyy_mm_dd = $data_year . "-" . $data_month . "-" . $data_day;
			$curr_report_period = get_mce_report_period( $date_yyyy_mm_dd );
	    }

		$args = array(
			'post_type'       => 'mce_activity',
			'meta_key'        => 'mce_activity_cat_ID',
			'orderby'         => 'meta_value_num',
			'order'           => 'ASC',
			'post_status'     => 'publish',
			'posts_per_page'  => -1,
			'meta_query' => array(
				array(
					'key'     => 'mce_activity_user_ID',
					'value'   => $user_id,
					'compare' => '=',
				),
				array(
					'key' => 'mce_report_period_ID',
					'value'   => $curr_report_period[0]->ID,
					'compare' => '=',
				),
			),
		);

		$activity_list =  get_posts( $args );

		return $activity_list;

	}

	/**
	 */

	/*
	public function get_mce_cat_list() {

		echo 'in get_mce_cat_list';

		global $wpdb;

		$now = current_time('mysql', 1);

		$querystr = "
			SELECT wposts.ID, wposts.post_title, wposts.post_content
			FROM $wpdb->posts AS wposts
			WHERE wposts.post_type = 'mce_category'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			ORDER BY wposts.post_title ASC
		";

		$category_list = $wpdb->get_results($querystr, OBJECT);

	  echo $querystr;

		return $category_list;
	}
	*/

	/**
	 */
	function get_mce_cat_list2() {

		$type = 'mce_category';
		$args=array(
			'post_type' => $type,
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'post_parent'=> 0,
			'orderby' => 'meta_value_num',
			'meta_key' => 'mce_category_disp_num',
			'order' => 'ASC');

		$mce_cat_array = array();
		$query = null;
		$query = new WP_Query($args);
		$posts = $query->get_posts();

		foreach($posts as $post) {
			$args=array(
			'post_type'      => $type,
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'post_parent'    => $post->ID,
			'orderby'        => 'post_title',
			'order'          => 'ASC');
			$sub_query = new WP_Query($args);
			$child_posts = $sub_query->get_posts();

			$post_child = array();
			if ($child_posts) {
				foreach($child_posts as $child_post) {
					$post_child[] = array(
										"post_ID" => $child_post->ID,
										"post_title" => $child_post->post_title,
							  			"post_content" => $child_post->post_content);
				}
			}

			$mce_cat_array[] = array(
									"post_ID" => $post->ID,
									"post_title" => $post->post_title,
									"post_content" => $post->post_content,
									"post_child" => $post_child);

		}

		return $mce_cat_array;
	}

	/**
	 */
	 /*
	public function get_mce_report_list() {

		global $wpdb;

		$now = current_time('mysql', 1);

		$querystr = "
			SELECT wposts.ID, wposts.post_title, wposts.post_content
			FROM $wpdb->posts AS wposts
			WHERE wposts.post_type = 'mce_report_period'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			ORDER BY wposts.post_title ASC
		";

		$report_period_list = $wpdb->get_results($querystr, OBJECT);

		return $report_period_list;
	}
*/
	/**
	 */
	function get_mce_report_period( $date_yyyy_mm_dd = null ) {

		global $wpdb;

		$now = current_time('mysql', 1);

		if ( is_null( $date_yyyy_mm_dd ) ) {
			list( $data_year, $data_month, $data_day, $hour, $minute, $second ) = split( '([^0-9])', $now );
			$date_yyyy_mm_dd = $data_year . "-" . $data_month . "-" . $data_day;
	    }

		//list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $now );
		//$now_yyyy_mm_dd = $today_year . "-" . $today_month . "-" . $today_day;

		$start_date_sql = " AND wpostmeta2.meta_key = 'start_date' AND wpostmeta2.meta_value <= '" . $date_yyyy_mm_dd . "'";
		$end_date_sql = " AND wpostmeta3.meta_key = 'end_date' AND wpostmeta3.meta_value >= '" . $date_yyyy_mm_dd . "'";

		$querystr = "
			SELECT DISTINCT wposts.ID
			FROM $wpdb->posts AS wposts, $wpdb->postmeta AS wpostmeta, $wpdb->postmeta AS wpostmeta2, $wpdb->postmeta AS wpostmeta3
			WHERE wposts.ID = wpostmeta.post_id
			AND wposts.ID = wpostmeta2.post_id
			AND wposts.ID = wpostmeta3.post_id
			AND wposts.post_type = 'mce_report_period'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			" . $start_date_sql . "
			" . $end_date_sql . "
			ORDER BY wposts.post_title ASC
		";

		//echo $querystr;

		$mce_report_period = $wpdb->get_results($querystr, OBJECT);

		return $mce_report_period;
	}

	/**
	 */
	function get_mce_curr_audits( $user_id = null ) {

		global $wpdb;

		$now = current_time('mysql', 1);

		list( $today_year, $today_month, $today_day, $hour, $minute, $second ) = split( '([^0-9])', $now );
		$now_yyyy_mm_dd = $today_year . "-" . $today_month . "-" . $today_day;

		$audit_start_date_sql = " AND wpostmeta2.meta_key = 'start_date' AND wpostmeta2.meta_value <= '" . $now_yyyy_mm_dd . "'";
		$audit_end_date_sql = " AND wpostmeta3.meta_key = 'end_date' AND wpostmeta3.meta_value >= '" . $now_yyyy_mm_dd . "'";

		$querystr = "
			SELECT DISTINCT wposts.ID
			FROM $wpdb->posts AS wposts, $wpdb->postmeta AS wpostmeta, $wpdb->postmeta AS wpostmeta2, $wpdb->postmeta AS wpostmeta3
			WHERE wposts.ID = wpostmeta.post_id
			AND wposts.ID = wpostmeta2.post_id
			AND wposts.ID = wpostmeta3.post_id
			AND wposts.post_type = 'mce_report_period'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			" . $audit_start_date_sql . "
			" . $audit_end_date_sql . "
			ORDER BY wposts.post_title ASC
		";

		$audit_period = $wpdb->get_results($querystr, OBJECT);

		if ( is_numeric( $user_id ) )
			$activity_user_sql = " AND wpostmeta2.meta_key = 'mce_activity_user_ID' AND wpostmeta2.meta_value = '" . $user_id . "'";
	    else
	        $activity_user_sql = " AND wpostmeta2.meta_key = 'mce_activity_user_ID' AND wpostmeta2.meta_value = '" . get_current_user_id() . "'";


		$activity_report_period_sql = " AND wpostmeta3.meta_key = 'mce_report_period_ID' AND wpostmeta3.meta_value >= '" . $audit_period[0]->ID . "'";

		$querystr = "
			SELECT DISTINCT wposts.ID
			FROM $wpdb->posts AS wposts, $wpdb->postmeta AS wpostmeta, $wpdb->postmeta AS wpostmeta2, $wpdb->postmeta AS wpostmeta3
			WHERE wposts.ID = wpostmeta.post_id
			AND wposts.ID = wpostmeta2.post_id
			AND wposts.ID = wpostmeta3.post_id
			AND wposts.post_type = 'mce_activity'
			AND wposts.post_status = 'publish'
			AND wposts.post_title != 'Auto Draft'
			AND wposts.post_date <= '$now'
			" . $activity_user_sql . "
			" . $activity_report_period_sql . "
			ORDER BY wposts.post_title ASC
		";

		$activity_reports = $wpdb->get_results($querystr, OBJECT);

		return $activity_reports;
	}

}

}
