<?php
/**
 * Astra Child Theme functions and definitions
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
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 15 );
function child_enqueue_styles() {
	wp_enqueue_style( 'astra-child-theme-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_ASTRA_CHILD_THEME_VERSION, 'all' );
}

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
add_action('wp_enqueue_scripts', 'gf_adding_scripts');
function gf_adding_scripts(){
	wp_register_script('gf_custom_js', get_stylesheet_directory_uri().'/js/gf_custom.js', array('jquery'), '1.1', true);
	wp_enqueue_script('gf_custom_js');
}

// Validate survey membership before GF is rendered
// https://docs.gravityforms.com/gform_pre_render/
add_filter( 'gform_pre_render', 'gf_pre_render' );
function gf_pre_render($form ) {
	global $post;

	// Setup on memberpress membership URL back end page
	 if ( isset($_GET['my_gform_id']) ) {
		 $gf_id = $_GET['my_gform_id'];
	 }

	// Setup on gravity form back end field
	foreach( $form['fields'] as $field ) {
		if ($field->get_input_type() === 'hidden' && $field->cssClass === 'my_gform_id') {
			$gform_id = $field->defaultValue;
		}
	}

	// Get current page id
  if (isset($post->ID)) {
    // Added manually using advanced custom fields inside each visualizer word press page
    $page_gform_id = get_post_meta( $post->ID, 'my_gform_id', true );
  }

	// echo "<br>is_admin(): ".is_admin();
	// echo "<br>gf_id: ".$gf_id.", gform_id: ".$gform_id.", page_gform_id: ".$page_gform_id;

	// not back end page for gravity form
	if ( !is_admin() && isset($page_gform_id) ) {
		if ( !isset($gf_id) || !isset($gform_id) || $gf_id != $gform_id ) {
			echo "<a href='/'>&#60;&#60;Go Back</a><br><br><p style='color:#FF0000;font-weight:bold;'>Error! Invalid survey: my_gform_id parameter is missing or invalid. Please contact customer service.</p>";
			exit;
		}
	}

	return $form;
}

// GF survey form submissions hook
add_action( 'gform_after_submission_'.$my_gform_id, 'gf_after_submission', 10, 2 );
function gf_after_submission($entry, $form ) {
	global $survey_entry;
	global $survey_form;
	$survey_entry = $entry;
	$survey_form = $form;

	add_action( 'astra_entry_content_after', 'astra_entry_content_after_gform_submission');
}

// Astra theme hook
function astra_entry_content_after_gform_submission() {
	global $survey_entry;
	global $survey_form;

	$total_resiliency_behaviours_score = 0;
	$total_support_programs_score = 0;
	$total_supportive_leadership_score = 0;
	$total_supportive_environment_score = 0;
	$total_osir_score = 0;

	$mental_health_score = 0;
	$physical_health_score = 0;
	$health_fatigue_concerns_score = 0;
	$health_burnout_concerns_score = 0;
	$health_stress_concerns_score = 0;
	$health_alcohol_stress_score = 0;
	$health_cannabis_stress_score = 0;
	$health_tobacco_stress_score = 0;

	$impact_questions_attendance = 0;
	$impact_questions_presenteeism = 0;
	$impact_questions_motivation_score = 0;
	$impact_questions_disability = '';
	$impact_questions_wcb_claim = 0;
	$impact_questions_trauma_stress_exposures = 0;

	$demographics_vocation = '';
	$demographics_province = '';
	$demographics_gender = '';
	$demographics_age = 0;
	
	// Create GFSurvey instance
	if ( ! class_exists( 'GFSurvey' ) ) {
		require_once ABSPATH . 'wp-content/plugins/gravityformssurvey/class-gf-survey.php';
	}
	$GFSurveyInstance = GFSurvey::get_instance();

	// var_dump($survey_entry);

	// Survey fields
	foreach ( $survey_form['fields'] as $field ) {

		// ---------------------------------------------------------------------

		// GF Form ID
		if ($field->get_input_type() === 'hidden' && $field->cssClass === 'my_gform_id') {
			$my_gform_id = $field->defaultValue;
		}

		// Corporate Parent Account User ID (1 parent account per each membership)
		if ($field->get_input_type() === 'hidden' && $field->cssClass === 'corporate_parent_account_user_id') {
			$gf_corporate_parent_uid = $field->defaultValue;
		}

		// likert fields ---------------------------------------------------------------------
 
		if ( $field->get_input_type() == 'likert' && $field->gsurveyLikertEnableScoring ) {

			// 4 Sub Scales-------------------------------------------------------------------------

			// Resiliency Behaviours
			if ($field->cssClass === 'resiliency_behaviours') {	
				// echo "<br><br>field: ". $field->id. ", ". $field->cssClass. ", ". $field->label;
				// echo "<br>Resiliency Behaviours score: ". $GFSurveyInstance:: get_field_score($field, $survey_entry);
				$total_resiliency_behaviours_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}
			
			// Support Programs
			if ($field->cssClass === 'support_programs') {
				$total_support_programs_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Supportive Leadership
			if ($field->cssClass === 'supportive_leadership') {
				$total_supportive_leadership_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}
			
			// Supportive Environment
			if ($field->cssClass === 'supportive_environment') {
				$total_supportive_environment_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Health----------------------------------------------------------------------------------

			// Good mental health
			if ($field->cssClass === 'mental_health') {
				$mental_health_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Good physical health
			if ($field->cssClass === 'physical_health') {
				$physical_health_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Fatigue concerns
			if ($field->cssClass === 'health_fatigue_concerns') {
				$health_fatigue_concerns_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Burnout concerns
			if ($field->cssClass === 'health_burnout_concerns') {
				$health_burnout_concerns_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Stress concerns
			if ($field->cssClass === 'health_stress_concerns') {
				$health_stress_concerns_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// cope with substances
			if ($field->cssClass === 'health_alcohol_stress') {
				$health_alcohol_stress_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// cope with substances
			if ($field->cssClass === 'health_cannabis_stress') {
				$health_cannabis_stress_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// cope with substances
			if ($field->cssClass === 'health_tobacco_stress') {
				$health_tobacco_stress_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}

			// Impact Questions: Motivation
			if ($field->cssClass === 'impact_questions_motivation') {
				$impact_questions_motivation_score += $GFSurveyInstance:: get_field_score($field, $survey_entry);
			}
		}

		//  -----------------------------------------------------------------

		// Impact Questions: Attendance 
		if ($field->cssClass === 'impact_questions_attendance') {
			$impact_questions_attendance = GFFormsModel::get_field_value($field);
		}

		// Impact Questions: Presenteeism 
		if ($field->cssClass === 'impact_questions_presenteeism') {
			$impact_questions_presenteeism = GFFormsModel::get_field_value($field);
		}

		// Impact Questions: WCB claim
		if ($field->cssClass === 'impact_questions_wcb_claim') {
			$impact_questions_wcb_claim = GFFormsModel::get_field_value($field);
		}

		// Impact Questions: Trauma/Very stressful situation exposures
		if ($field->cssClass === 'impact_questions_trauma_stress_exposures') {
			$impact_questions_trauma_stress_exposures = GFFormsModel::get_field_value($field);
		}

		// Demographics: What is your age? 
		if ($field->cssClass === 'demographics_age') {
			$demographics_age = GFFormsModel::get_field_value($field);
		}

		// Radio button fields ------------------------------------------------------------

		if ( $field->get_input_type() == 'radio' ) {

			// Impact Questions: Short term disability
			if ($field->cssClass === 'impact_questions_disability') {
				$impact_questions_disability = GFFormsModel::get_field_value($field);
			}

			// Demographic and Bio Data Questions

			// What is your current vocation?
			if ($field->cssClass === 'demographics_vocation') {
				$demographics_vocation = GFFormsModel::get_field_value($field);
			}

			// In which province or territory do you live? 
			if ($field->cssClass === 'demographics_province') {
				$demographics_province = GFFormsModel::get_field_value($field);
			}

			// What gender do you identify with? 
			if ($field->cssClass === 'demographics_gender') {
				$demographics_gender = GFFormsModel::get_field_value($field);
			}
		}
	}
	
	$total_osir_score = $total_resiliency_behaviours_score + $total_support_programs_score +
		$total_supportive_leadership_score + $total_supportive_environment_score;

	// Debug
	// echo '<br><br>Entry ID: '.$survey_entry['id'];

	// https://docs.gravitypdf.com/v6/users/shortcodes-and-mergetags
	echo do_shortcode("[gravitypdf name='OSIR Participant Report PDF' id='610c1fba96028' entry=".$survey_entry['id']." text='Save As PDF']");
	echo " | ";
	echo do_shortcode("[gravitypdf name='OSIR Participant Report PDF' id='610c1fba96028' entry=".$survey_entry['id']." text='Print PDF' print='1']");

	// Survey submission confirmation messages
	echo getParticipantReportMsg();

	gform_add_meta_entry_survey( $survey_entry, $total_osir_score, $total_resiliency_behaviours_score,
		$total_support_programs_score, $total_supportive_leadership_score, $total_supportive_environment_score,
		$mental_health_score, $physical_health_score, $health_fatigue_concerns_score, $health_burnout_concerns_score,
		$health_stress_concerns_score, $health_alcohol_stress_score, $health_cannabis_stress_score,
		$health_tobacco_stress_score, $impact_questions_attendance, $impact_questions_presenteeism,
		$impact_questions_motivation_score, $impact_questions_disability, $impact_questions_wcb_claim,
		$impact_questions_trauma_stress_exposures, $demographics_vocation, $demographics_province, 
		$demographics_gender, $demographics_age, $my_gform_id, $gf_corporate_parent_uid );
}

// Add survey meta DB entry for each user submission
function gform_add_meta_entry_survey( $survey_entry, $total_osir_score, $total_resiliency_behaviours_score,
	$total_support_programs_score, $total_supportive_leadership_score, $total_supportive_environment_score,
	$mental_health_score, $physical_health_score, $health_fatigue_concerns_score, $health_burnout_concerns_score,
	$health_stress_concerns_score, $health_alcohol_stress_score, $health_cannabis_stress_score,
	$health_tobacco_stress_score, $impact_questions_attendance, $impact_questions_presenteeism,
	$impact_questions_motivation_score, $impact_questions_disability, $impact_questions_wcb_claim,
	$impact_questions_trauma_stress_exposures, $demographics_vocation, $demographics_province, 
	$demographics_gender, $demographics_age, $my_gform_id, $gf_corporate_parent_uid ){
	global $survey_entry;

	// save gf submission user meta entry
	add_user_meta( get_current_user_id(), 'gf_survey_entry', $survey_entry['id']);

	// add gf meta entries
	gform_add_meta( $survey_entry['id'], 'gf_subscriber_uid', get_current_user_id() );
	gform_add_meta( $survey_entry['id'], 'gf_corporate_parent_uid', $gf_corporate_parent_uid );
	gform_add_meta( $survey_entry['id'], 'my_gform_id', $my_gform_id );

	gform_add_meta( $survey_entry['id'], 'total_resiliency_behaviours_score', $total_resiliency_behaviours_score );
	gform_add_meta( $survey_entry['id'], 'total_support_programs_score', $total_support_programs_score );
	gform_add_meta( $survey_entry['id'], 'total_supportive_leadership_score', $total_supportive_leadership_score );
	gform_add_meta( $survey_entry['id'], 'total_supportive_environment_score', $total_supportive_environment_score );
	gform_add_meta( $survey_entry['id'], 'total_osir_score', $total_osir_score );
	gform_add_meta( $survey_entry['id'], 'osir_profile', getOSIRProfile($total_osir_score) );

	gform_add_meta( $survey_entry['id'], 'mental_health_score', $mental_health_score );
	gform_add_meta( $survey_entry['id'], 'physical_health_score', $physical_health_score );
	gform_add_meta( $survey_entry['id'], 'health_fatigue_concerns_score', $health_fatigue_concerns_score );
	gform_add_meta( $survey_entry['id'], 'health_burnout_concerns_score', $health_burnout_concerns_score );
	gform_add_meta( $survey_entry['id'], 'health_stress_concerns_score', $health_stress_concerns_score );
	gform_add_meta( $survey_entry['id'], 'health_alcohol_stress_score', $health_alcohol_stress_score);
	gform_add_meta( $survey_entry['id'], 'health_cannabis_stress_score', $health_cannabis_stress_score );
	gform_add_meta( $survey_entry['id'], 'health_tobacco_stress_score', $health_tobacco_stress_score );

	gform_add_meta( $survey_entry['id'], 'impact_questions_attendance', $impact_questions_attendance);
	gform_add_meta( $survey_entry['id'], 'impact_questions_presenteeism', $impact_questions_presenteeism );
	gform_add_meta( $survey_entry['id'], 'impact_questions_motivation_score', $impact_questions_motivation_score );
	gform_add_meta( $survey_entry['id'], 'impact_questions_disability', $impact_questions_disability );
	gform_add_meta( $survey_entry['id'], 'impact_questions_wcb_claim', $impact_questions_wcb_claim );
	gform_add_meta( $survey_entry['id'], 'impact_questions_trauma_stress_exposures', $impact_questions_trauma_stress_exposures );
	
	gform_add_meta( $survey_entry['id'], 'demographics_vocation', $demographics_vocation );
	gform_add_meta( $survey_entry['id'], 'demographics_province', $demographics_province );
	gform_add_meta( $survey_entry['id'], 'demographics_gender', $demographics_gender );
	gform_add_meta( $survey_entry['id'], 'demographics_age', $demographics_age );

	// Track number of user submissions instead of relying on GF entry_id
	gform_add_meta( $survey_entry['id'], 'is_survey_entry_submitted_by_user', 'yes' );

	// Save submission entry date/time (EST)
	date_default_timezone_set('America/New_York');
	gform_add_meta( $survey_entry['id'], 'survey_entry_submitted_date', date("Y-m-d") );
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
