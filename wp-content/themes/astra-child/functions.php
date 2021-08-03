<?php
/**
 * Astra Child Theme Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Astra Child Theme
 * @since 1.0.0
 */

/**
 * Define Constants
 */
define( 'CHILD_THEME_ASTRA_CHILD_THEME_VERSION', '1.0.0' );

/**
 * Enqueue styles
 */
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_THEME_VERSION, 'all' );
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );


/******************************************************************************************/
// OSIR project code
/******************************************************************************************/


// Custom navigation menus
require "my-nav-menus.php";

// GF & mepr custom hooks
require "my-custom-hooks.php";

// Astra theme custom config
require "my-astra-theme-config.php";

//----------------------------------------------------------------------------------------
// Survey Logic

// https://www.wpbeginner.com/wp-tutorials/how-to-properly-add-javascripts-and-styles-in-wordpress/
// Gravity Forms custom JS (loaded in footer)
function gf_adding_scripts(){
	wp_register_script('gf_custom_js', get_stylesheet_directory_uri().'/js/gf_custom.js', array('jquery'), '1.1', true);
	wp_enqueue_script('gf_custom_js');
}
add_action('wp_enqueue_scripts', 'gf_adding_scripts');

// GF survey form submissions hook
add_action( 'gform_after_submission_'.$my_gform_id, 'gf_after_submission', 10, 2);
function gf_after_submission($entry, $form ) {
	global $survey_entry;
	global $survey_form;
	$survey_entry = $entry;
	$survey_form = $form;

	add_action( 'astra_entry_content_after', 'add_my_script_astra_entry_content_after');
}

// Astra theme hook
function add_my_script_astra_entry_content_after() {
	global $survey_entry;
	global $survey_form;

	$total_osir_score = 0;
	$total_outlook_score = 0;
	$demographic_vocation = '';
	$osir_years_of_service = 0;
	$absenteeism_osir_profile = 0;
	$number_trauma_events = 0;
	$tobacco_use = '';
	$clinically_diagnosed_mental_illness = '';
	$short_term_disability = '';
	$wcb_claim = '';

	// Create GFSurvey instance
	if ( ! class_exists( 'GFSurvey' ) ) {
		require_once ABSPATH . 'wp-content/plugins/gravityformssurvey/class-gf-survey.php';
	}
	$GFSurveyInstance = GFSurvey::get_instance();

	// Survey fields
	foreach ( $survey_form['fields'] as $field ) {

		// ---------------------------------------------------------------------

		// GF Form ID
		if ($field->get_input_type() === 'hidden' && $field->cssClass === 'my_gform_id') {
			$my_gform_id = $field->defaultValue;
		}

		// Corporate Parent Account Moderator ID (1 parent account per each membership)
		if ($field->get_input_type() === 'hidden' && $field->cssClass === 'corporate_parent_account_moderator_id') {
			$gf_moderator_uid = $field->defaultValue;
		}

		// ---------------------------------------------------------------------
		// likert fields
		if ( $field->get_input_type() == 'likert' && $field->gsurveyLikertEnableScoring ) {

			// OSIR Profile Pie Chart
			if ($field->cssClass === 'osir') {
				// echo "<br><br>field: ". $field->id. ", ". $field->cssClass. ", ". $field->label;
				// echo "<br>OSIR score: ". $GFSurveyInstance:: get_field_score($field, $survey_entry);
				$total_osir_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}
			// General Mental Outlook Score (Average score by vulnerability profile)
			else if ($field->cssClass === 'outlook') {	
				$total_outlook_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}
		}

		// ---------------------------------------------------------------------
		// Radio button fields
		if ( $field->get_input_type() == 'radio' ) {

			// Demographic and Bio Data Questions

			// What is your current vocation?
			if ($field->cssClass === 'demographic_vocation') {
				$demographic_vocation = GFFormsModel::get_field_value($field);
			}

			// How many total years of service have you spent as a First Responder (in all applicable roles)?
			if ($field->cssClass === 'osir_years_of_service') {
				$osir_years_of_service = GFFormsModel::get_field_value($field);
			}

			// 1.	Attendance – number of days missed work due to illness
			if ($field->cssClass === 'absenteeism_osir_profile') {
				$absenteeism_osir_profile = GFFormsModel::get_field_value($field);
			}
			
			// 6.	Trauma/Very stressful situation exposures – Please estimate how many events have you 
			// deal with that you have found traumatic/very stressful in the past 12 months
			if ($field->cssClass === 'number_trauma_events') {
				$number_trauma_events = GFFormsModel::get_field_value($field);
			}

			// Do you use tobacco products? This includes smoking cigarettes and cigars as well as using chewing tobacco
			if ($field->cssClass === 'tobacco_use') {
				$tobacco_use = GFFormsModel::get_field_value($field);
			}

			// Have you ever been clinically diagnosed with a mental illness or addictive disorder?
			if ($field->cssClass === 'clinically_diagnosed_mental_illness') {
				$clinically_diagnosed_mental_illness = GFFormsModel::get_field_value($field);
			}

			// 3.	Short term disability – Over the past 12 months, have you been off work for a mental 
			// health-related matter?
			if ($field->cssClass === 'short_term_disability') {
				$short_term_disability = GFFormsModel::get_field_value($field);
			}

			// 4.	WCB claim – Over the past 12 months, have you made a worker’s compensation claim related
			// to an Occupational Stress Injury (such as PTSD and other similar mental illnesses)?
			if ($field->cssClass === 'wcb_claim') {
				$wcb_claim = GFFormsModel::get_field_value($field);
			}
	
		}
	}

	// Debug
	// echo '<br><br>Entry ID: '.$survey_entry['id'];
	// echo '<h4>Survey Total Score: ' . $survey_entry['gsurvey_score'].'</h4>';
	// echo '<h4>OSIR Score: ' . $total_osir_score.'</h4>';
	// echo '<h4>Outlook Score: ' . $total_outlook_score;
	// echo '<h4>OSIR Profile: ' . getUserProfile($total_osir_score).'</h4>';

	// Survey submission confirmation messages
	echo getUserProfileGenericMsg();
	echo getUserProfileMsg(getUserProfile($total_osir_score));

	// Add dynamic charts meta data to DB
	gform_add_meta_entry_survey( $GFSurveyInstance, $survey_entry, $total_osir_score,
		$total_outlook_score, $demographic_vocation, $osir_years_of_service, $absenteeism_osir_profile,
		$number_trauma_events, $tobacco_use, $clinically_diagnosed_mental_illness, $short_term_disability, 
		$wcb_claim, $my_gform_id, $gf_moderator_uid );
}

// Add survey meta DB entry for each user submission
function gform_add_meta_entry_survey( $GFSurveyInstance, $survey_entry, $total_osir_score, 
	$total_outlook_score, $demographic_vocation, $osir_years_of_service, $absenteeism_osir_profile, 
	$number_trauma_events, $tobacco_use, $clinically_diagnosed_mental_illness, $short_term_disability,
	$wcb_claim, $my_gform_id, $gf_moderator_uid ){
	global $survey_entry;

	// save gf submission user meta entry
	add_user_meta( get_current_user_id(), 'gf_survey_entry', $survey_entry['id']);

	// add gf meta entries
	gform_add_meta( $survey_entry['id'], 'gf_subscriber_uid', get_current_user_id() );
	gform_add_meta( $survey_entry['id'], 'gf_moderator_uid', $gf_moderator_uid );
	gform_add_meta( $survey_entry['id'], 'my_gform_id', $my_gform_id );
	gform_add_meta( $survey_entry['id'], 'total_osir_score', $total_osir_score );
	gform_add_meta( $survey_entry['id'], 'osir_profile', getUserProfile($total_osir_score) );
	gform_add_meta( $survey_entry['id'], 'total_outlook_score', $total_outlook_score );
	gform_add_meta( $survey_entry['id'], 'demographic_vocation', $demographic_vocation );
	gform_add_meta( $survey_entry['id'], 'osir_years_of_service', $osir_years_of_service );
	gform_add_meta( $survey_entry['id'], 'absenteeism_osir_profile', $absenteeism_osir_profile );
	gform_add_meta( $survey_entry['id'], 'number_trauma_events', $number_trauma_events );
	gform_add_meta( $survey_entry['id'], 'tobacco_use', $tobacco_use );
	gform_add_meta( $survey_entry['id'], 'clinically_diagnosed_mental_illness', $clinically_diagnosed_mental_illness );
	gform_add_meta( $survey_entry['id'], 'short_term_disability', $short_term_disability );
	gform_add_meta( $survey_entry['id'], 'wcb_claim', $wcb_claim );
	
	// Track number of user submissions instead of relying on GF entry_id
	gform_add_meta( $survey_entry['id'], 'is_survey_entry_submitted_by_user', 'yes' );
}

//----------------------------------------------------------------------------------------

// Survey submission confirmation messages
require "my-survey-confirmation-messages.php";

// Visualizer configuration params
require "my-visualizer-config.php";

// Visualizer charts calculations & data
require "my-visualizer-data.php";

// Charts helper functions
require "my-survey-charts-shortcodes.php";
