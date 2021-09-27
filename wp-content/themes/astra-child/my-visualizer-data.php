<?php

//----------------------------------------------------------------------------------------
// Visualizer charts calculations & data

// https://developers.google.com/chart/interactive/docs/gallery/columnchart
// https://docs.themeisle.com/category/657-visualizer
// https://docs.themeisle.com/article/728-manual-configuration
// https://docs.themeisle.com/article/605-how-can-i-populate-chart-series-and-data-dynamically
// https://docs.themeisle.com/article/970-visualizer-sample-queries-to-generate-charts


// 1. Charts Columns(Series) Hook
add_filter( 'visualizer-get-chart-series', 'myplugin_filter_charts_series', 10, 3 );
function myplugin_filter_charts_series( $series, $chart_id, $type ) {

  // The overall ratio of people within each vulnerability profile
  if ( ($chart_id === 59 || $chart_id === 297 ) && $type === 'pie'){
		return OSIRPieChartHeader();
	}

  // General Mental Outlook Score (Coping with Substances)
	if (($chart_id === 95 || $chart_id === 800 || $chart_id === 802 || $chart_id === 208 ) && $type === 'column'){
		 return outlookMentalScoreCopingChartHeader();
	}

	// What is your current vocation? (OSIR Index Score by Department). Percentage of employees per vulnerability profile
	if ( ($chart_id === 66 || $chart_id === 328 ) && $type === 'column'){
		 return OSIRByDepartmentChartHeader();
	}

	// How many total years of service have you spent as a First Responder (in all applicable roles)?
  //Average OSIR Index score by years of service
	if ( ($chart_id === 69 || $chart_id === 344) && $type === 'column'){
		 return OSIRByYearsOfServiceChartHeader();
	}

	// Trauma/Very stressful situation exposures – Please estimate how many events have you 
	// deal with that you have found traumatic/very stressful in the past 12 months
	if ( ($chart_id === 73 || $chart_id === 365) && $type === 'column'){
		 return traumaAvgScorebyProfileChartHeader();
	}

	// Attendance – number of days missed work due to illness
	/* if ($chart_id === 463 && $type === 'column'){
		 return absenteeismProfileChartHeader();
	} */

  return $series;
}

//----------------------------------------------------------------------------------------
// 2. Charts Data Hook

add_filter( 'visualizer-get-chart-data', 'myplugin_filter_charts_data', 10, 3 );
function myplugin_filter_charts_data( $data, $chart_id, $type ) {
  global $post;
  $my_gform_id = 0; // fall back

  // Get current page id
  if (isset($post->ID)) {
    // Added manually using advanced custom fields inside each visualizer word press page
    $my_gform_id = get_post_meta( $post->ID, 'my_gform_id', true );
    // echo "<br><br>page id: ".$post->ID.", my_gform_id: ".$my_gform_id;
  }

  // The overall ratio of people within each vulnerability profile
  if ( $chart_id === 297 && $type === 'pie' && $my_gform_id == 18){
		return OSIRPieChartData($my_gform_id);
	}

	// General Mental Outlook Score (Coping with Substances: I cope with stress using alcohol)
	if ( $chart_id === 95 && $type === 'column' && $my_gform_id == 18){
		 return outlookMentalScoreCopingAlcoholChartData($my_gform_id);
	}

	// General Mental Outlook Score (Coping with Substances: I cope with stress using cannabis)
	if ( $chart_id === 800 && $type === 'column' && $my_gform_id == 18){
		 return outlookMentalScoreCopingCannabisChartData($my_gform_id);
	}

	// General Mental Outlook Score (Coping with Substances: I cope with stress using tobacco products)
	if ( $chart_id === 802 && $type === 'column' && $my_gform_id == 18){
		 return outlookMentalScoreCopingTobaccoChartData($my_gform_id);
	}

	// Short term disability – Over past year, have you been off work for a mental health-related matter?
	if ( $chart_id === 84 && $type === 'column' && $my_gform_id == 18){
		return OSIRDisabilityChartData($my_gform_id);
	}

	// Worker’s compensation claim – Over past year, have you made a worker’s compensation claim
	if ( $chart_id === 91 && $type === 'column' && $my_gform_id == 18){
		return OSIRWCCChartData($my_gform_id);
	}

  // Occupational Stress Injury Resiliency (OSIR) Index Score
  if ( $chart_id === 59 && $type === 'pie' && $my_gform_id == 17){
		return OSIRPieChartData($my_gform_id);
	}

  // General Mental Outlook Score (Coping with Substances)
	if ( $chart_id === 208 && $type === 'column' && $my_gform_id == 17){
		 return outlookMentalScoreCopingChartData($my_gform_id);
	}

	// What is your current vocation? (OSIR Index Score by Department). Percentage of employees per vulnerability profile
	if ( $chart_id === 66 && $type === 'column' && $my_gform_id == 10 || 
      $chart_id === 120 && $type === 'tabular' && $my_gform_id == 10 ){
		return OSIRByDepartmentChartData($my_gform_id);
	}

  // What is your current vocation? (OSIR Index Score by Department). Percentage of employees per vulnerability profile
	if ( $chart_id === 328 && $type === 'column' && $my_gform_id == 17 || 
    $chart_id === 448 && $type === 'tabular' && $my_gform_id == 17 ){
		return OSIRByDepartmentChartData($my_gform_id);
	}

	// How many total years of service have you spent as a First Responder (in all applicable roles)?
	if ( $chart_id === 69 && $type === 'column' && $my_gform_id == 10 ){
		 return OSIRByYearsOfServiceChartData($my_gform_id);
	}

  // How many total years of service have you spent as a First Responder (in all applicable roles)?
	if ( $chart_id === 344 && $type === 'column' && $my_gform_id == 17 ){
		 return OSIRByYearsOfServiceChartData($my_gform_id);
	}

	// Trauma/Very stressful situation exposures – Please estimate how many events have you 
	// deal with that you have found traumatic/very stressful in the past 12 months
	// Average number of traumatic/stressful events employees have dealt in the past 12 months
	if ( $chart_id === 73 && $type === 'column' && $my_gform_id == 10 ){
		 return traumaAvgScorebyProfileChartData($my_gform_id);
	}

  // Trauma/Very stressful situation exposures – Please estimate how many events have you 
	// deal with that you have found traumatic/very stressful in the past 12 months
	// Average number of traumatic/stressful events employees have dealt in the past 12 months
	if ( $chart_id === 365 && $type === 'column' && $my_gform_id == 17 ){
		 return traumaAvgScorebyProfileChartData($my_gform_id);
	}

	// Attendance – number of days missed work due to illness
	/* if ($chart_id === 463 && $type === 'column'){
		 return absenteeismProfileChartData();
	} */

/* 	echo "<br><br>data:<br>";
	print_r($data);
	echo "<br>type: ".$type.", chart_id: ".$chart_id; */
  return $data;
}

function OSIRPieChartHeader() {
  $series = array(
		array(
			'label' => 'OSIR Index Score',
			'type' => 'string',
		),
		array(
			'label' => 'Count',
			'type' => 'number',
		),
		array(
			'label' => 'style',
			'type' => 'string',
		),
	);

	return $series;
}

function OSIRPieChartData($my_gform_id) {
  global $wpdb;

	$sql  = "SELECT `meta_value` AS osirProfile, COUNT(*) AS Count";
  $sql  .= " FROM `wp_gf_entry_meta`";
  $sql  .= " WHERE `meta_key` = 'osir_profile'";
  $sql  .= " AND `form_id` = ".$my_gform_id;
  $sql  .= " GROUP BY `meta_value`";

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: '';
		$osirProfileCount = isset($v['Count'])? (double)$v['Count']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $osirProfileCount;
		$chartData[$counter][2] = $seriesColors[$counter];
		$counter++;
	}

/* 	echo "<br><br>sql:<br>".$sql;
	echo "<br><br>results:<br>";
	print_r($results);
	echo "<br><br>chartData:<br>";
	print_r($chartData); */
	
	return $chartData;
}

// OSIR By Department Chart Header & Data types
function OSIRByDepartmentChartHeader(){
		$series = array(
			array(
					'label' => 'Vocation',
					'type' => 'string',
			),
			array(
				'label' => 'Challenge(%)',
				'type' => 'number',
			),
			array(
				'label' => 'Concern(%)',
				'type' => 'number',
			),
			array(
				'label' => 'OK(%)', 
				'type' => 'number',
			),
			array(
				'label' => 'Thriving(%)',
				'type' => 'number',
			),
	);

	return $series;
}

function OSIRByYearsOfServiceChartHeader() {
	$series = array(
		array(
			'label' => 'Years Of Service',
			'type' => 'string',
		),
		array(
			'label' => 'Average OSIR Score',
			'type' => 'number',
		),
		array(
			'label' => 'annotation',
			'type' => 'number',
		),
	);

	return $series;
}

function outlookMentalScoreCopingChartHeader(){
	$series = array(
		array(
			'label' => 'OSIR Profile',
			'type' => 'string',
		),
		array(
			'label' => 'Outlook Mental Average Score',
			'type' => 'number',
		),
		array(
			'label' => 'style',
			'type' => 'string',
		),
		array(
			'label' => 'annotation',
			'type' => 'number',
		),
	);

	return $series;
}

function outlookMentalScoreCopingAlcoholChartData($my_gform_id = 0) {
	global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',";
	$sql .= " AVG(healthAlcoholStress.`meta_value`) AS 'outlookAverageScore'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'health_alcohol_stress_score' ) healthAlcoholStress";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = healthAlcoholStress.`entry_id`";
	$sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: 0;
		$outlookAverageScore = isset($v['outlookAverageScore'])? (double)$v['outlookAverageScore']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $outlookAverageScore;
		$chartData[$counter][2] = $seriesColors[$counter];
		$chartData[$counter][3] = $outlookAverageScore;
		$counter++;
	}

	/* echo "<br><br>sql:<br>".$sql;
	echo "<br><br>results:<br>";
	print_r($results);
	echo "<br><br>seriesColors:<br>";
	print_r($seriesColors);
	echo "<br><br>chartData:<br>";
	print_r($chartData); */
	
	return $chartData;
}

function outlookMentalScoreCopingCannabisChartData($my_gform_id = 0) {
	global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',";
	$sql .= " AVG(healthCannabisStress.`meta_value`) AS 'outlookAverageScore'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'health_cannabis_stress_score' ) healthCannabisStress";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = healthCannabisStress.`entry_id`";
	$sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: 0;
		$outlookAverageScore = isset($v['outlookAverageScore'])? (double)$v['outlookAverageScore']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $outlookAverageScore;
		$chartData[$counter][2] = $seriesColors[$counter];
		$chartData[$counter][3] = $outlookAverageScore;
		$counter++;
	}
	
	return $chartData;
}

function outlookMentalScoreCopingTobaccoChartData($my_gform_id = 0) {
	global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',";
	$sql .= " AVG(healthTobaccoStress.`meta_value`) AS 'outlookAverageScore'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'health_tobacco_stress_score' ) healthTobaccoStress";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = healthTobaccoStress.`entry_id`";
	$sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: 0;
		$outlookAverageScore = isset($v['outlookAverageScore'])? (double)$v['outlookAverageScore']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $outlookAverageScore;
		$chartData[$counter][2] = $seriesColors[$counter];
		$chartData[$counter][3] = $outlookAverageScore;
		$counter++;
	}
	
	return $chartData;
}

function OSIRDisabilityChartData($my_gform_id) {
  global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',"; 
	$sql .= " Count(impactQuestionsDisability.`meta_value`) AS 'Yes'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'impact_questions_disability' ) impactQuestionsDisability";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = impactQuestionsDisability.`entry_id`";
	$sql .= " AND impactQuestionsDisability.`meta_value` = 'Yes'";
	$sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;
	$sql .= " GROUP BY osirProfile";
	
	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: '';
		$osirProfileCount = isset($v['Yes'])? (double)$v['Yes']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $osirProfileCount;
		$chartData[$counter][2] = $seriesColors[$counter];
		$counter++;
	}
	
	return $chartData;
}

function OSIRWCCChartData($my_gform_id) {
  global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',"; 
	$sql .= " Count(impactQuestionsWCC.`meta_value`) AS 'Yes'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'impact_questions_wcc_claim' ) impactQuestionsWCC";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = impactQuestionsWCC.`entry_id`";
	$sql .= " AND impactQuestionsWCC.`meta_value` = 'Yes'";
	$sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;
	$sql .= " GROUP BY osirProfile";
	
	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: '';
		$osirProfileCount = isset($v['Yes'])? (double)$v['Yes']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $osirProfileCount;
		$chartData[$counter][2] = $seriesColors[$counter];
		$counter++;
	}
	
	return $chartData;
}

function traumaAvgScorebyProfileChartHeader() {
	$series = array(
		array(
			'label' => 'OSIR Profile',
			'type' => 'string',
		),
		array(
			'label' => 'Trauma Events Average Score',
			'type' => 'number',
		),
		array(
			'label' => 'style',
			'type' => 'string',
		),
	);

	return $series;
}

function absenteeismProfileChartHeader() {
	$series = array(
		array(
			'label' => 'Attendance',
			'type' => 'string',
		),
		array(
			'label' => 'Trauma Events Average Score',
			'type' => 'number',
		),
		array(
			'label' => 'style',
			'type' => 'string',
		),
	);

	return $series;
}

// ----------------------------------------------------------------------------------------

// OSIR By Department Chart Data
function OSIRByDepartmentChartData($my_gform_id){
	global $wpdb;

	$sql = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', COUNT(*) AS 'count', demographicVocation.`meta_value`";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta`";
	$sql .= " WHERE meta_key = 'demographic_vocation' ) demographicVocation";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = demographicVocation.`entry_id`";
  $sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;
	$sql .= " GROUP BY osirProfile, demographicVocation.`meta_value`";
	$sql .= " ORDER BY osirProfile ASC";

	$results = $wpdb->get_results( $sql, ARRAY_A );

	foreach ($results as $k => $v){;
		$dataSQL[$v['meta_value']][$v['osirProfile']] = $v['count'];
	} 

	$counter = 0;
	$chartData = [];

	// Build chart data
  if (isset($dataSQL)){
    foreach ($dataSQL as $k => $v){
      $challenge = isset($v['Challenge'])? (int)$v['Challenge']: 0;
      $concern = isset($v['Concern'])? (int)$v['Concern']: 0;
      $OK = isset($v['OK'])? (int)$v['OK']: 0;
      $thriving = isset($v['Thriving'])? (int)$v['Thriving']: 0;
      $total = $challenge + $concern + $OK + $thriving;

      $challengePercentage = ($challenge/$total) * 100;
      $concernPercentage =($concern/$total) * 100;
      $OKPercentage = ($OK/$total) * 100;
      $thrivingPercentage = ($thriving/$total) * 100;

      $chartData[$counter][0] = $k;
      $chartData[$counter][1] = $challengePercentage;
      $chartData[$counter][2] = $concernPercentage;
      $chartData[$counter][3] = $OKPercentage;
      $chartData[$counter][4] = $thrivingPercentage;
      $counter++;
    }
  }

	/* echo "<br><br>sql:<br>".$sql;
	echo "<br><br>results:<br>";
	print_r($results);
	echo "<br><br>chartData:<br>";
	print_r($chartData); */
	
	return $chartData;
}

function OSIRByYearsOfServiceChartData($my_gform_id = 0){
	global $wpdb;

	$sql  = "SELECT osirYearsOfService.`meta_value` AS 'yearsOfService',";
	$sql .= " AVG(`wp_gf_entry_meta`.`meta_value`) AS 'averageOSIRScore'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " (SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'osir_years_of_service') osirYearsOfService";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'total_osir_score'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = osirYearsOfService.`entry_id`";
  $sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;
	$sql .= " GROUP BY osirYearsOfService.`meta_value`";
	$sql .= " ORDER BY LENGTH(osirYearsOfService.`meta_value`) ASC,";
	$sql .= " osirYearsOfService.`meta_value` ASC";

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];

	// Build chart data
	foreach ($results as $k => $v){
		$yearsOfService = isset($v['yearsOfService'])? $v['yearsOfService']: 0;
		$averageOSIRScore = isset($v['averageOSIRScore'])? (double)$v['averageOSIRScore']: 0;
		$chartData[$counter][0] = $yearsOfService;
		$chartData[$counter][1] = $averageOSIRScore;
		$chartData[$counter][2] = $averageOSIRScore;
		$counter++;
	}

	/* echo "<br><br>sql:<br>".$sql;
	echo "<br><br>results:<br>";
	print_r($results);
	echo "<br><br>chartData:<br>";
	print_r($chartData); */
	
	return $chartData;
}

function traumaAvgScorebyProfileChartData($my_gform_id = 0) {
	global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',"; 
	$sql .= " AVG(numberTraumaEvents.`meta_value`) AS 'traumaEventsAvgNumber'";
	$sql .= " FROM `wp_gf_entry_meta`,";
	$sql .= " ( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'number_trauma_events' ) numberTraumaEvents";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = numberTraumaEvents.`entry_id`";
  $sql .= " AND `wp_gf_entry_meta`.`form_id` = ".$my_gform_id;
	$sql .= " GROUP BY osirProfile";

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];
	$seriesColors = array( "fill-color: #dd3333", "fill-color: #ff9205", 
		"fill-color: #eeee22", "fill-color: #81d742" );

	// Build chart data
	foreach ($results as $k => $v){
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: 0;
		$traumaEventsAvgNumber = isset($v['traumaEventsAvgNumber'])? (double)$v['traumaEventsAvgNumber']: 0;
		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $traumaEventsAvgNumber;
		$chartData[$counter][2] = $seriesColors[$counter];
		$counter++;
	}

	/* echo "<br><br>sql:<br>".$sql;
	echo "<br><br>results:<br>";
	print_r($results);
	echo "<br><br>chartData:<br>";
	print_r($chartData); */
	
	return $chartData;
}

// Absenteeism Profile Chart Data
/*
function absenteeismProfileChartData() {
	global $wpdb;

	$sql  = "SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',";
	$sql .= " AVG(absenteeismOSIRProfile.`meta_value`) AS 'averageAbsenteeism'";
	$sql .= " FROM `wp_gf_entry_meta`,"; 
	$sql .= "( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'absenteeism_osir_profile' ) absenteeismOSIRProfile";
	$sql .= " WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'";
	$sql .= " AND `wp_gf_entry_meta`.`entry_id` = absenteeismOSIRProfile.`entry_id`";
	$sql .= " GROUP BY osirProfile";

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$counter = 0;
	$chartData = [];

	// Build chart data
	foreach ($results as $k => $v){
		/* echo "<br>".$k."=>";
		echo "<br>osirProfile: ".$v['osirProfile'];
		echo "<br>averageAbsenteeism: ".$v['averageAbsenteeism'];
	
		$osirProfile = isset($v['osirProfile'])? $v['osirProfile']: 0;
		$averageAbsenteeism = isset($v['averageAbsenteeism'])? (double)$v['averageAbsenteeism']: 0;

		$chartData[$counter][0] = $osirProfile;
		$chartData[$counter][1] = $averageAbsenteeism;
		$counter++;
	}

	// echo "<br><br>sql:<br>".$sql;
	// echo "<br><br>results:<br>";
	// print_r($results);
	// echo "<br><br>chartData:<br>";
	// print_r($chartData);
	
	return $chartData;
}

*/
