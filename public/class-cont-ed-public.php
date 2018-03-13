<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://stoln.com
 * @since      1.0.0
 *
 * @package    Cont_Ed
 * @subpackage Cont_Ed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Cont_Ed
 * @subpackage Cont_Ed/public
 * @author     1304713 Ont Inc. <mdc.768@gmail.com>
 */
class Cont_Ed_Public {

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
	 * @param      string    $cont_ed       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $cont_ed, $version ) {

		$this->cont_ed = $cont_ed;
		$this->version = $version;

		$this->mce_shortcodes();
		$this->mce_templates();
		$this->mce_functions();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->cont_ed, plugin_dir_url( __FILE__ ) . 'css/cont-ed-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->cont_ed, plugin_dir_url( __FILE__ ) . 'js/cont-ed-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the functions
	 *
	 * @since    1.0.0
	 */
		public function mce_functions() {

			/**
     * Gets all images attached to a post
     * @return string
     */
	    function mce_get_images() {
	        global $post;
	        $id = intval( $post->ID );
	        $size = 'medium';
	        $attachments = get_children( array(
	                'post_parent' => $id,
	                'post_status' => 'inherit',
	                'post_type' => 'attachment',
	                'post_mime_type' => 'image',
	                'order' => 'ASC',
	                'orderby' => 'menu_order'
	            ) );
	        if ( empty( $attachments ) )
	                    return '';

	        $output = "\n";
	    /**
	     * Loop through each attachment
	     */
	    foreach ( $attachments as $id  => $attachment ) :

	        $title = esc_html( $attachment->post_title, 1 );
	        $img = wp_get_attachment_image_src( $id, $size );

	        $output .= '<a class="selector thumb" href="' . esc_url( wp_get_attachment_url( $id ) ) . '" title="' . esc_attr( $title ) . '">';
	        $output .= '<img class="aligncenter" src="' . esc_url( $img[0] ) . '" alt="' . esc_attr( $title ) . '" title="' . esc_attr( $title ) . '" />';
	        $output .= '</a>';

	    endforeach;

	        return $output;
	    }

		}

	/**
	 * Add the templates
	 *
	 * @since    1.0.0
	 */
		public function mce_templates() {

			add_filter('single_template', 'single_mce_templates');

			function single_mce_templates($single) {
			    global $wp_query, $post;
			    if ( $post->post_type == 'mce_activity' ) {
			        if ( file_exists( plugin_dir_path( __FILE__ ) . 'template/mce-activity-post.php' ) ) {
			            return plugin_dir_path( __FILE__ ) . 'template/mce-activity-post.php';
			        }
			    }
			    return $single;
			}
		}
	/**
	 * Add the shortcodes
	 *
	 * @since    1.0.0
	 */
	public function mce_shortcodes() {

		function get_mce_recs(){
			/* Get user info. */
			global $current_user, $wp_roles;
			$current_user = wp_get_current_user();

 				if(is_user_logged_in()) { ?>

          <div id="member_content">

            <h3>MCE Records for <?php echo $current_user->display_name; ?></h3>
            <?php
            $now                = current_time('mysql', 1);
            $mce_activity_list = get_mce_activity_list2( get_current_user_id() );           //will return current report period
            //$mce_activity_list = get_mce_activity_list2( get_current_user_id(), $now );

            //echo "<!--";
            //var_dump ($mce_activity_list);
            //echo "-->";

            $mce_report_period_ID = get_mce_report_period();
            $mce_report_period    = get_post( $mce_report_period_ID[0]->ID );

            $mce_report_period_title = $mce_activity_cat->post_title;

            //echo "<!-- mce_report_period=".$mce_report_period->post_title;
            //var_dump ($mce_report_period);
            //echo "-->";

            $mce_cat_list = get_mce_cat_list2();

            //echo "<!--";
            //var_dump ($mce_cat_list);
            //echo "-->";

            echo "<h4>Reporting Period: ".$mce_report_period->post_title."</h4><p class='mce_text'>A total of 75% (22.5) of your required 30 credits may be obtained in any single category.</p>";

            $mce_cats ="<table id='mce_activity_listings'><col style='width:15%'><col style='width:60%'><col style='width:20%'><thead><th>Category</th><th>Title</th><th>Category Total</th></thead>";

            //$mce_cats ="<dl id='mce_activity_list'>";

            $mce_activity_credits_total  = 0;

            foreach( $mce_cat_list as $c ) {
              // process each category
              $mce_cat_total  = 0;
              $mce_cat        = "";
              $mce_activities = "";
              $mce_cat_meta   = get_post_custom($c['post_ID']);
              $mce_activity_max_credits       = $mce_cat_meta["mce_activity_max_credits"][0];
              $mce_activity_credit_multiplier = $mce_cat_meta["mce_activity_credit_multiplier"][0];
              $mce_category_disp_num          = $mce_cat_meta["mce_category_disp_num"][0];

              // save cat ID and sub-cat ID's
              $cat_ids = array($c['post_ID']);
              foreach( $c['post_child'] as $pc ) {
                $cat_ids[] = $pc['post_ID'];
              }

              $mce_activity_count = 1;


              echo "<!--cat_ids";
              var_dump ($cat_ids);
              echo "-->";

              foreach( $mce_activity_list as $a ) {
                // check if activity is owned by cat or child of cat (kitten?)
                $mce_activity_meta   = get_post_custom($a->ID);
                $mce_activity_cat_ID = $mce_activity_meta["mce_activity_cat_ID"][0];
                $mce_activity        = "";
                if (in_array($mce_activity_cat_ID, $cat_ids)) {

                  //$mce_activity_meta["mce_activity_credits"][0];
                  //$mce_activity_meta["mce_activity_name"][0];
                  //$mce_activity_meta["mce_activity_date"][0];

                  $mce_cat_total += $mce_activity_meta["mce_activity_credits"][0];
                  $mce_activity_count++;

                  $mce_activity ="<tr class='mce_activity'><td colspan='2'><a href='".$a->guid."' title='link for this activity'>".$mce_activity_meta["mce_activity_date"][0].": ".$mce_activity_meta["mce_activity_name"][0].": ".$mce_activity_meta["mce_activity_credits"][0]." CE</a></td></tr>";

                  //$mce_activity ="<dd><a href='".$a->guid."' title='link for this activity'>".$mce_activity_meta["mce_activity_date"][0].": ".$mce_activity_meta["mce_activity_name"][0].": ".$mce_activity_meta["mce_activity_credits"][0]." CE</a></dd>";

                }
                $mce_activities .= $mce_activity;
              }

              if ( $mce_cat_total > $mce_activity_max_credits ) {
                $mce_cat_total = $mce_activity_max_credits;
              }

              $mce_cat ="<tr>";
              $mce_cat .="<td rowspan='".$mce_activity_count."'>".$mce_category_disp_num."</td>";
              $mce_cat .="<td>".$c['post_title']."</td><td>".$mce_cat_total." Credits</td>";

              $mce_cat .=$mce_activities."</tr>";

              //$mce_cat ="<dt>".$c['post_title']." - ".$mce_cat_total." Credits (of ".$mce_activity_max_credits." category maximum)</dt>";

              $mce_cats .= $mce_cat;

              $mce_activity_credits_total += $mce_cat_total;

            }

            //$mce_cats .="</dl>";

            $mce_cats .="</table>";

            echo $mce_cats;

            if ( $mce_activity_credits_total < 30 ) {
              $mce_credits_remain = $mce_activity_credits_total - 30;

              if ( $mce_credits_remain < 0 ) {
                $mce_credits_remain = $mce_credits_remain * -1;
              }

              $mce_credits_remain_lit = 'You have <strong>'.$mce_credits_remain.'</strong> credits remaining to complete your current Mandatory Continuing Education requirement.';
            } else {
              $mce_activity_credits_total = 30;
              $mce_credits_remain_lit = 'You have finished your current Mandatory Continuing Education requirement.';
            }
            echo '<p id="mce_totals"><span>Total Credits (of 30 required): '.$mce_activity_credits_total.'</span><br>'.$mce_credits_remain_lit;
            ?>

          </div>
				<?php } else { ?>
					<h3>We are sorry but this area is for OALA members only</h3>
					<p>This is the members area of the OALA. If you are a member please use the "MEMBER LOGIN" link at the top of the page or here, <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="OALA member login">Login now.</a></p>
				<?php }
		}

		function add_new_mce_rec(){
			echo "<!-- add_new_mce_rec -->";
			/* Get user info. */
			global $current_user, $wp_roles;
			$current_user = wp_get_current_user();

			if(is_user_logged_in()) {
				$date_time = date("F j, Y, g:i a");
				$postActivityError = array();
				global $current_user;
				get_currentuserinfo();
				date_default_timezone_set("America/Toronto");
				$date_time = date("F j, Y, g:i a");

				if(isset($_POST['submitted']) && isset($_POST['post_nonce_field']) && wp_verify_nonce($_POST['post_nonce_field'], 'post_nonce')) {

					if(trim($_POST['mce_activity_name']) === '') {
						$postActivityError[] = 'Please enter an activity name.';
						$hasError = true;
					} else {
						$mce_activity_name = trim($_POST['mce_activity_name']);
					}

					if(trim($_POST['mce_activity_hours']) === '') {
						$postActivityError[] = 'Please enter your hours for this activity.';
						$hasError = true;
					} else {
						$mce_activity_hours = trim($_POST['mce_activity_hours']);
					}

					if(trim($_POST['mce_activity_date']) === '') {
						$postActivityError[] = 'Please enter the date for this activity.';
						$hasError = true;
					} else {
						$mce_activity_date = trim($_POST['mce_activity_date']);
					}

					if(trim($_POST['mce_activity_credits']) === '') {
						$postActivityError[] = 'Please enter your hours and select a category for this activity.';
						$hasError = true;
					} else {
						$mce_activity_credits = trim($_POST['mce_activity_credits']);
					}

					if(trim($_POST['mce_activity_desc']) === '') {
						$postActivityError[] = 'Please enter a description of this activity.';
						$hasError = true;
					} else {
						$mce_activity_desc = trim($_POST['mce_activity_desc']);
					}

					if(isset($_POST['mce_activity_cat_ID'])) {
						if($_POST['mce_activity_cat_ID'] == '') {
							$postActivityError[] = 'Please select a category for this activity.';
							$hasError = true;
						}
						else {
							$mce_activity_cat_ID = trim($_POST['mce_activity_cat_ID']);
						}
					}

					if(isset($_POST['mce_report_period_ID'])) {
						if($_POST['mce_report_period_ID'] == '') {
							$postActivityError[] = 'Please select a reporting period for this activity.';
							$hasError = true;
						}
						else {
							$mce_report_period_ID = trim($_POST['mce_report_period_ID']);
						}
					}

					if (!$hasError) {
						$post_information = array(
							'post_title'    => $current_user->display_name.' - '.$date_time.' - '.$mce_activity_name,
							'post_content'  => 'This MCE Activity post was created by '.$current_user->user_login.', it was created '.$date_time,
							'post_status'   => 'publish',
							'post_author'   => $current_user->ID,
							'post_type'     => 'mce_activity'
						);

						$post_id = wp_insert_post($post_information);

						if ($post_id) {
							// insert post meta
							add_post_meta($post_id, 'mce_activity_name', $mce_activity_name);
							add_post_meta($post_id, 'mce_activity_hours', $mce_activity_hours);
							add_post_meta($post_id, 'mce_activity_date', $mce_activity_date);
							add_post_meta($post_id, 'mce_activity_desc', $mce_activity_desc);
							add_post_meta($post_id, 'mce_activity_cat_ID', $mce_activity_cat_ID);
							add_post_meta($post_id, 'mce_report_period_ID', $mce_report_period_ID);
							add_post_meta($post_id, 'mce_activity_user_ID', $current_user->ID);
							add_post_meta($post_id, 'mce_activity_audit', 'no');
							$post_custom                    = get_post_custom($mce_activity_cat_ID);
							$mce_activity_credit_multiplier = $post_custom["mce_activity_credit_multiplier"][0];
							$mce_activity_max_credits       = $post_custom["mce_activity_max_credits"][0];

							if ( $mce_activity_max_credits == "" ) {
								$mce_activity_max_credits = 22.5;
							}
							if ( $mce_activity_credit_multiplier == "" ) {
								$mce_activity_credit_multiplier = 1;
							}

							$mce_activity_credits  = $mce_activity_hours * $mce_activity_credit_multiplier;
							if ( $mce_activity_credits > $mce_activity_max_credits ) {
								$mce_activity_credits = $mce_activity_max_credits;
							}
							if ( $mce_activity_credits > 22.5 ) {
								$mce_activity_credits = 22.5;
							}
							add_post_meta($post_id, 'mce_activity_credits', $mce_activity_credits);
							wp_redirect(site_url('/mce_activity/?p='.$post_id.'&edit=true', 'http'));
						}
					}
				}
			}

			if(is_user_logged_in()) {
			  $mce_activity_name = '';
			  $mce_activity_hours ='';
			  $mce_activity_desc = '';
			  $mce_activity_cat_ID = '';

			  if(isset($_POST['mce_activity_name'])) {
			    if(function_exists('stripslashes')) {
			      $mce_activity_name = stripslashes($_POST['mce_activity_name']);
			    } else {
			      $mce_activity_name = $_POST['mce_activity_name'];
			    }
			  }

			  if(isset($_POST['mce_activity_hours'])) {
			    if(function_exists('stripslashes')) {
			      $mce_activity_hours = stripslashes($_POST['mce_activity_hours']);
			    } else {
			      $mce_activity_hours = $_POST['mce_activity_hours'];
			    }
			  }

			  if(isset($_POST['mce_activity_date'])) {
			    if(function_exists('stripslashes')) {
			      $mce_activity_date = stripslashes($_POST['mce_activity_date']);
			    } else {
			      $mce_activity_date = $_POST['mce_activity_date'];
			    }
			  }

			  if(isset($_POST['mce_activity_desc'])) {
			    if(function_exists('stripslashes')) {
			      $mce_activity_desc = stripslashes($_POST['mce_activity_desc']);
			    } else {
			      $mce_activity_desc = $_POST['mce_activity_desc'];
			    }
			  }

			  if(isset($_POST['mce_activity_cat_ID'])) {
			    $mce_activity_cat_ID = $_POST['mce_activity_cat_ID'];
			  }

			  if(isset($_POST['mce_report_period_ID'])) {
			    $mce_activity_cat_ID = $_POST['mce_report_period_ID'];
			  }

			  $mce_cat_list2 = get_mce_cat_list2();

			  // categories with parent/child
			  $cat_select_opts2 ='<select name="mce_activity_cat_ID" id="mce_activity_cat_ID">';
			  if( $mce_cat_list2 ) {
			    $cat_select_opts2 .='<option value="">Please choose a Category</option>';
			    foreach( $mce_cat_list2 as $s ) {
			      //echo "in it       ";
			      //print_r ($s);
			      //echo "******************  ";
			      if( empty( $s["post_child"] ) ) {
			        //no child records
			        //echo $s["post_ID"];
			        //echo "no child records       ";

			        if( $s["post_ID"] == $mce_activity_cat_ID ) {
			          $selected = ' selected="selected"';
			        } else {
			          $selected = '';
			        }
			        $post_custom = get_post_custom($s["post_ID"]);
			        $mce_activity_credit_multiplier = "data-mce_activity_credit_multiplier=".$post_custom["mce_activity_credit_multiplier"][0];
			        $mce_activity_max_credits       = "data-mce_activity_max_credits=".$post_custom["mce_activity_max_credits"][0];
			        $cat_select_opts2 .='<option value="'.$s["post_ID"].'"'.$selected.' title="'.$s["post_content"].'" '.$mce_activity_credit_multiplier.' '.$mce_activity_max_credits.'>'.$s["post_title"].'</option>';
			      } else {
			        //has child records
			        //echo $s["post_ID"];
			        //echo "has child records       ";

			        $post_custom = get_post_custom($s["post_ID"]);
			        $mce_activity_credit_multiplier = "data-mce_activity_credit_multiplier=".$post_custom["mce_activity_credit_multiplier"][0];
			        $mce_activity_max_credits       = "data-mce_activity_max_credits=".$post_custom["mce_activity_max_credits"][0];
			        $cat_select_opts2 .='<optgroup label="'.$s["post_title"].'" title="'.$s["post_content"].'" '.$mce_activity_credit_multiplier.' '.$mce_activity_max_credits.'>';
			        foreach( $s["post_child"] as $c ) {

			          //echo $c["post_ID"];
			          //echo "is child record       ";

			          $post_custom = get_post_custom($c["post_ID"]);
			          $mce_activity_credit_multiplier = "data-mce_activity_credit_multiplier=".$post_custom["mce_activity_credit_multiplier"][0];
			          $mce_activity_max_credits       = "data-mce_activity_max_credits=".$post_custom["mce_activity_max_credits"][0];
			          $cat_select_opts2 .='<option value="'.$c["post_ID"].'"'.$selected.' title="'.$c["post_content"].'" '.$mce_activity_credit_multiplier.' '.$mce_activity_max_credits.'>'.$c["post_title"].'</option>';
			        }
			        $cat_select_opts2 .='</optgroup>';
			      }
			    }
			  } else {
			    $cat_select_opts2 .='<option value="" disabled="disabled">No Categories Found</option>';
			  }
			  $cat_select_opts2 .='</select>';

			  $mce_reporting_list = get_mce_report_list();

			  $report_select_opts ='<select name="mce_report_period_ID" id="mce_report_period_ID">';
			  if( $mce_reporting_list ) {
			    $report_select_opts .='<option value="">Please choose a Reporting Period</option>';
			    foreach( $mce_reporting_list as $s ) {
			      if( $s->ID == $mce_report_period_ID ) {
			        $selected = ' selected="selected"';
			      } else {
			        $selected = '';
			      }
			      $report_select_opts .='<option value="'.$s->ID.'"'.$selected.'>'.strip_tags($s->post_title).'</option>';
			    }
			  } else {
			    $report_select_opts .='<option value="" disabled="disabled">No Categories Found</option>';
			  }
			  $report_select_opts .='</select>';
			}

			?>

			<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
			<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
			<script>
			jQuery(document).ready(function($){
				$( "#mce_activity_date" ).datepicker();

			  $("#mce_activity_cat_ID").change(function() {
			    activityCredits();
			  });

			  $("#mce_activity_hours").change(function() {
			    activityCredits();
			  });

			  $( "#mce_activity_hours" ).change(function() {
			    var mce_hours = jQuery( this ).val();
			    var mce_hours_rnd = (Math.round(mce_hours * 2) / 2).toFixed(1);
			    $( this ).val(mce_hours_rnd);
			  });

			  $('a.email').each(function(){
			    e = this.rel.replace('/','@');
			    this.href = 'mailto:' + e;
			    $(this).text(e);
			  });
			})
			</script>

			<script>
  		function activityCredits(){
		  	//alert("inIt");
		  	var optionSelected = jQuery("#mce_activity_cat_ID option:selected");
		  	var hoursSelected  = jQuery("#mce_activity_hours");
		  	var optionValueSelected = optionSelected.val();
		  	var mceActivityHours    = hoursSelected.val();
		  	var mceActivityMaxCredits       = optionSelected.data("mce_activity_max_credits");
		  	var mceActivityCreditMultiplier = optionSelected.data("mce_activity_credit_multiplier");

		  	if ( mceActivityMaxCredits == "" || mceActivityMaxCredits == null ) {
		  		mceActivityMaxCredits = 22.5;
		  	}
		  	if ( mceActivityCreditMultiplier == "" || mceActivityCreditMultiplier == null ) {
		  		mceActivityCreditMultiplier = 1;
		  	}

		  	if ( mceActivityHours != "" && optionValueSelected != "" ) {
		  		var mceActivityCredits  = mceActivityHours * mceActivityCreditMultiplier;
		  		if ( mceActivityCredits > mceActivityMaxCredits ) {
		  			mceActivityCredits = mceActivityMaxCredits;
		  		}
		  		if ( mceActivityCredits > 22.5 ) {
		  			mceActivityCredits = 22.5;
		  		}
		  		jQuery("input#mce_activity_credits").val( mceActivityCredits );

		  		//alert ('optionValueSelected = '+optionValueSelected+' mceActivityHours = '+mceActivityHours+' mceActivityMaxCredits = '+mceActivityMaxCredits+' mceActivityCreditMultiplier = '+mceActivityCreditMultiplier);
		  	}
		  };
  		</script>

			<style>
				#mce_add form input, #mce_add form select, #mce_add form textarea {width:100%;}
			</style>
			<main id="mce_add" role="main">

			<?php if(is_user_logged_in()) { ?>

				<div id="post-mce-activity">

					<div id="member_content">

						<h3>Add an Activity</h3>

						<?php
						if ($postActivityError) {
							$errorList = '<ul class="error">';
							foreach ($postActivityError as $err) {
								$errorList .= '<li>'.$err.'</li>';
							}
							$errorList .= '</ul>'.$err.'</li>';
							echo $errorList;
						}
						?>

						<form action="" id="activityPostForm" class="mceform" method="POST">
							<p class="note">hint: moving your mouse over the titles of the form will display help for that field.</p>

							<fieldset>
								<label for="mce_activity_name">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1" title="Activity Title:
									Enter the title of Authorship, study, certificate, license, credential(s), course, event, or activity">Activity Title:</span>
								</label>
								<input type="text" name="mce_activity_name" id="mce_activity_name" size="125" value="<?php echo $mce_activity_name; ?>" />
							</fieldset>

							<fieldset>
								<label for="mce_activity_date">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="2" title="Activity Date:
									Enter the date that the activity took place, if the activity took place over a range of days please enter the start and ending dates">Activity Date:</span>
								</label>
								<input type="text" name="mce_activity_date" id="mce_activity_date" size="125" value="<?php echo $mce_activity_date; ?>" />
							</fieldset>

							<fieldset>
								<label for="mce_category">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="3" title="MCE Category:
									See pages 5 to 7 of the MCE Program Guide for category descriptions">MCE Category:</span>
								</label>
								<?php echo $cat_select_opts2; ?>
							</fieldset>

							<fieldset>
								<label for="mce_activity_hours">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="4" title="Hours/# of Occurrences:
									Enter the number of hours spent on the CE endeavor to the nearest 0.5 OR Number of a Type of Document Published (for authorship category) OR Number of Occurrences (for Long-term Volunteer)">Hours/# of Occurrences:</span>
								</label>
								<input type="text" name="mce_activity_hours" id="mce_activity_hours" size="125" value="<?php echo $mce_activity_hours; ?>" />
							</fieldset>

							<fieldset>
								<label for="mce_activity_desc">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="4" title="Description:
									Briefly describe the activity and how it improves and/or advances you as a Landscape Architect, your company, or Landscape Architecture as a profession">Description:</span>
								</label>
								<textarea name="mce_activity_desc" id="mce_activity_desc" rows="8" cols="30" ><?php echo $mce_activity_desc; ?></textarea>
							</fieldset>

							<fieldset>
								<label for="mce_reporting">MCE Reporting Period:</label>
								<?php echo $report_select_opts; ?>
							</fieldset>

							<fieldset>
								<label for="mce_activity_credits">
									<span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="4" title="Credits:
									Credits are calculated automatically based on number of activities or hours input above.  Refer to the MCE Program Guide pages 5 to 7 for credit earning rates of each category">Credits:</span>
								</label>
								<input type="text" name="mce_activity_credits" id="mce_activity_credits" size="125" value="<?php echo $mce_activity_credits; ?>" readonly  />
							</fieldset>

							<fieldset>
								<?php wp_nonce_field('post_nonce', 'post_nonce_field'); ?>
								<input type="hidden" name="submitted" id="submitted" value="true" />
								<button type="submit" class="submit button">Add Activity</button>
							</fieldset>

							<p>For each of your new activities, please use this form to add the activity name, the number of hours spent on the activity, a description of the activity and which of the Mandatory Continuing Education categories it belongs to.</p><p>When you are satisfied with your information add your activity and you will be taken to a page where you can upload any supporting documents for this activity that you may have.</p>

						</form>

					</div>
				</div>

				<?php } else { ?>
					<h2 class="entry-title">Members Area</h2>
					<h3>We are sorry but this area is for OALA members only</h3>
					<p>This is the members area of the OALA. If you are a member please use the "MEMBER LOGIN" link at the top of the page or here, <a href="<?php echo wp_login_url( get_permalink() ); ?>" title="OALA member login">Login now.</a></p>
				<?php } ?>

			</main>

<?php

		}

			add_shortcode('mce-show', 'get_mce_recs');
			add_shortcode('mce-add', 'add_new_mce_rec');

	}

}
