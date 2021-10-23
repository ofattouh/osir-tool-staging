<?php

//----------------------------------------------------------------------------------------
// Survey Submission Confirmation Messages


// Organization OSIR profile
function getOSIRProfile ($total_score = 0) {
	$organizationProfile = 'N/A';

	if (0 <= $total_score && $total_score <= 27 ) {
		$organizationProfile = 'Challenge';
	} elseif (27 < $total_score && $total_score < 81 ) {
		$organizationProfile = 'Concern';
	} elseif (81 <= $total_score ) {
		$organizationProfile = 'Thriving';
	}

	return $organizationProfile;
}

// Organization Report profile message
function getOrganizationScalesMsg ($osirAverageGrandScore, $avg_resiliency_behaviours_score, $avg_support_programs_score, 
	$avg_supportive_leadership_score, $avg_supportive_environment_score) {
	$organizationProfile = getOSIRProfile($osirAverageGrandScore);

	$organizationProfileMsg  = '<h2>Overall</h2>';
	$organizationProfileMsg .= '<p>Your OSI Risk score is: <b>'.number_format($osirAverageGrandScore, 2).'</b></p>'; 

	$organizationProfileMsg .= '<p>Below you will find 3 profiles: Thriving, Concern, and Challenge. ';
	$organizationProfileMsg .= 'Each of these profiles has information that can help increase your ';
	$organizationProfileMsg .= 'awareness, and tips that you can act on.</p><br>';

	// Add horizontal scroll bar for the table on small screens
	$organizationProfileMsg .= '<div style="overflow-x:auto;"><table class="organization-report-results">';
	$organizationProfileMsg .= '<tr><th class="organization-report-th">RESULTS</th><th class="organization-report-th2">CHALLENGE</th><th class="organization-report-th3">CONCERN</th><th class="organization-report-th4">THRIVING</th></tr>';
	$organizationProfileMsg .= '<tr class="organization-report-your-results-tr"><td>YOUR RESULTS</td>';

	if ($organizationProfile === 'Challenge') {
		$organizationProfileMsg .= '<td class="organization-report-your-results-td">Resiliency behaviours score: '.number_format($avg_resiliency_behaviours_score, 2).'<br>';
		$organizationProfileMsg .= 'Support programs score: '.number_format($avg_support_programs_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive leadership score: '.number_format($avg_supportive_leadership_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive environment score: '.number_format($avg_supportive_environment_score, 2);
		$organizationProfileMsg .= '</td><td></td><td></td></tr>';
	} else if ($organizationProfile === 'Concern') {
		$organizationProfileMsg .= '<td></td><td class="organization-report-your-results-td">Resiliency behaviours score: '.number_format($avg_resiliency_behaviours_score, 2).'<br>';
		$organizationProfileMsg .= 'Support programs score: '.number_format($avg_support_programs_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive leadership score: '.number_format($avg_supportive_leadership_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive environment score: '.number_format($avg_supportive_environment_score, 2);
		$organizationProfileMsg .= '</td><td></td></tr>';
	
	} else if ($organizationProfile === 'Thriving') {
		$organizationProfileMsg .= '<td></td><td></td><td class="organization-report-your-results-td">Resiliency behaviours score: '.number_format($avg_resiliency_behaviours_score, 2).'<br>';
		$organizationProfileMsg .= 'Support programs score: '.number_format($avg_support_programs_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive leadership score: '.number_format($avg_supportive_leadership_score, 2).'<br>';
		$organizationProfileMsg .= 'Supportive environment score: '.number_format($avg_supportive_environment_score, 2);
		$organizationProfileMsg .= '</td></tr>';
	}
	
	$organizationProfileMsg .= '<tr><td class="organization-report-recommendations">RECOMMEDATIONS</td>';
	$organizationProfileMsg .= '<td valign="top"><ul><li>Encourage employees to seek help from a mental health professional</li>';
	$organizationProfileMsg .= '<li>Consider examining your current benefits programs to ensure adequate health coverage</li>';
	$organizationProfileMsg .= '<li>Do an outreach or communications campaign to advertise the programs available within your organization (e.g., EFAP, trauma care, paramedical psychological services, in-house psychological services)</li>';
	$organizationProfileMsg .= '<li>Develop programs for leaders to be better able to discuss health and trauma at work</li>';
	$organizationProfileMsg .= '<li>Implement leadership training programs to equip employees with leadership skills and behaviour that foster employee health and safety</li>';
	$organizationProfileMsg .= '<li>Consider providing paid time off to utilize support programs and resources</li>';
	$organizationProfileMsg .= '</ul></td>';

	$organizationProfileMsg .= '<td valign="top"><ul><li>Offer specialized campaigns or webinars on lower scoring areas to ensure all groups are aware of available resources</li>';
	$organizationProfileMsg .= '<li>Examine whether subgroups of people are facing struggles over others (e.g., newer employees, females, those with children)</li>';
	$organizationProfileMsg .= '<li>Provide supports and resources to allow for better work-life balance/integration</li>';
	$organizationProfileMsg .= '<li>Evaluate whether current programs are effective and where improvements can be made</li>';
	$organizationProfileMsg .= '<li>Train resiliency and coping skills</li>';
	$organizationProfileMsg .= '<li>Review existing organizational policies and see what could be changed to further improve the interpersonal work environment.</li>';
	$organizationProfileMsg .= '<li>Organizational culture interventions are recommended</li>';
	$organizationProfileMsg .= '<li>Interventions such as civility training and team building exercises may improve team interpersonal relationships</li>';
	$organizationProfileMsg .= '</ul></td>';

	$organizationProfileMsg .= '<td valign="top"><ul><li>Celebrate successes through communication campaigns on best practices and success stories</li>';
	$organizationProfileMsg .= '<li>Encourage programs to maintain resiliency such as wellness challenges</li>';
	$organizationProfileMsg .= '<li>Examine which programs are most effective and consider offering webinars to external organizations</li>';
	$organizationProfileMsg .= '<li>Ensure programs stay relevant and top of mind for when traumatic events or challenging times occur</li>';
	$organizationProfileMsg .= '</ul></td>';

	$organizationProfileMsg .= '</tr></table></div>';

	return $organizationProfileMsg;
}

// Organization Report generic message
function getOrganizationGenericMsg ($avg_resiliency_behaviours_score, $avg_support_programs_score, 
	$avg_supportive_leadership_score, $avg_supportive_environment_score, $report_start_date, $report_end_date) {
	
	// Submission entry date/time (EST)
	date_default_timezone_set('America/New_York');
	$start_date = ( isset($report_start_date) ) ? $report_start_date->format('l, Y-m-d'): date('l, Y-m-d');
	$end_date = (isset($report_end_date) ) ? $report_end_date->format('l, Y-m-d'): date('l, Y-m-d');

	$organizationGenericMsg  = '<a href="/?action=subscriptions">&#60;&#60;Go Back</a><br>';
	$organizationGenericMsg .= '<br><h2>Organization Report</h2>';
	$organizationGenericMsg .= '<p class="organization-report-dates"><b>From: </b><i>'.$start_date.'</i></p>';
	$organizationGenericMsg .= '<p class="organization-report-dates"><b>To: </b><i>'.$end_date.'</i></p>';
	$organizationGenericMsg .= '<h3>RISK OF DEVELOPING AN OCCUPATIONAL STRESS INJURY</h3>';
	$organizationGenericMsg .= '<p>The organization’s overall OSI risk score is calculated ';
	$organizationGenericMsg .= 'using several data points from the survey. By regularly monitoring ';
	$organizationGenericMsg .= 'employee and leader behaviours, perceptions, and experiences, you ';
	$organizationGenericMsg .= 'can help increase your level of awareness of vulnerability and ';
	$organizationGenericMsg .= 'risk for stress and other health concerns that can increase your ';
	$organizationGenericMsg .= 'employees’ risk of experiencing an OSI. Through early recognition ';
	$organizationGenericMsg .= 'and intervention, you can mitigate your employees’ risk for OSI.</p>';
	
	$organizationGenericMsg .= '<p>The OSI risk assessment is based on four themes (or scales). ';
	$organizationGenericMsg .= 'Scoring high on these scales indicates that an employee has ';
	$organizationGenericMsg .= 'resources available to help them cope with stressors at work. ';
	$organizationGenericMsg .= 'Scoring low on these scales indicates that an employee may not ';
	$organizationGenericMsg .= 'have the necessary resources to cope with workplace stressors ';
	$organizationGenericMsg .= 'and is at risk for OSI.</p>';

	$organizationGenericMsg .= '<h3>Resiliency Behaviours</h3>';
	$organizationGenericMsg .= '<p>Resiliency behaviours focus on what employees do to try to ';
	$organizationGenericMsg .= 'maintain their mental health.</p>';
	$organizationGenericMsg .= '<p><b>Resiliency behaviours score: '.number_format($avg_resiliency_behaviours_score, 2).'/12</b></p>';
	$organizationGenericMsg .= '<p>Scoring high on this indicates that employees are actively ';
	$organizationGenericMsg .= 'practicing resilience techniques and are using available support ';
	$organizationGenericMsg .= 'systems. Employees scoring low on this scale should seek out ';
	$organizationGenericMsg .= 'support from trusted persons. Attending training sessions on ';
	$organizationGenericMsg .= 'resilience and/or reading about resilience are encouraged. The ';
	$organizationGenericMsg .= 'organization should consider providing such training or reading ';
	$organizationGenericMsg .= 'materials to employees if these programs do not already exist.</p>';

	$organizationGenericMsg .= '<h3>Support Programs</h3>';
	$organizationGenericMsg .= '<p>Support programs refer to the perceptions that the organization ';
	$organizationGenericMsg .= 'has mental health programs available for their employees and that ';
	$organizationGenericMsg .= 'these programs are helpful.</p>';
	$organizationGenericMsg .= '<p><b>Support programs score: '.number_format($avg_support_programs_score, 2).'/44</b></p>';
	$organizationGenericMsg .= '<p>Scoring high on this (33 or higher) indicates that your employees ';
	$organizationGenericMsg .= 'feel there are strong programs at work that they feel they can ';
	$organizationGenericMsg .= 'use when necessary. If your employees scored low on this scale ';
	$organizationGenericMsg .= '(11 or lower), you should share information on what mental health ';
	$organizationGenericMsg .= 'programs the organization offers using multiple communication ';
	$organizationGenericMsg .= 'methods. Employees may not be aware of the existing programs ';
	$organizationGenericMsg .= 'either within your organization or within your community. You ';
	$organizationGenericMsg .= 'may also consider offering more programs focused on fostering ';
	$organizationGenericMsg .= 'workplace mental health.</p>';

	$organizationGenericMsg .= '<h3>Supportive Leadership</h3>';
	$organizationGenericMsg .= '<p>Supportive leadership focuses specifically on employees ';
	$organizationGenericMsg .= 'perception of their leader/direct manager.</p>';
	$organizationGenericMsg .= '<p><b>Supportive leadership score: '.number_format($avg_supportive_leadership_score, 2).'/20</b></p>';
	$organizationGenericMsg .= '<p>Scoring high on this indicates that employees trust their ';
	$organizationGenericMsg .= 'leader and that their leaders engage in behaviours that support ';
	$organizationGenericMsg .= 'employees at work. If employees are scoring low on this scale, ';
	$organizationGenericMsg .= 'the organization is encouraged to implement an evidence-based ';
	$organizationGenericMsg .= 'leadership training program. Leadership training will educate ';
	$organizationGenericMsg .= 'leaders on the importance of good leadership and provide them ';
	$organizationGenericMsg .= 'with guidance on how to become better leaders (e.g., improving ';
	$organizationGenericMsg .= 'specific behaviours). Improving leader behaviour improves ';
	$organizationGenericMsg .= 'employee mental health and safety.</p>';

	$organizationGenericMsg .= '<h3>Supportive Environment</h3>';
	$organizationGenericMsg .= '<p>Supportive environment encompasses how employees perceive their ';
	$organizationGenericMsg .= 'workplace and how they are treated at work (outside of leadership).</p>';
	$organizationGenericMsg .= '<p><b>Supportive environment score: '.number_format($avg_supportive_environment_score, 2).'/28</b></p>';
	$organizationGenericMsg .= '<p>Scoring high on this indicates that employees are treated with ';
	$organizationGenericMsg .= 'respect, have health workplace social connections, and feel that at ';
	$organizationGenericMsg .= 'least some aspects of their organization are a good fit for them. ';
	$organizationGenericMsg .= 'If employees are scoring low on this scale, the organization should ';
	$organizationGenericMsg .= 'seek to improve the work environment and the organizational culture. ';
	$organizationGenericMsg .= 'As this scale includes interpersonal relationships, low scores may ';
	$organizationGenericMsg .= 'indicate incivility (i.e., rudeness) or even bullying and harassment ';
	$organizationGenericMsg .= 'are occurring in the workplace. The organization should instruct ';
	$organizationGenericMsg .= 'leaders to look out for these sorts of behaviours and ensure they ';
	$organizationGenericMsg .= 'are protecting the employees that are victims of these behaviours. ';
	$organizationGenericMsg .= 'Interventions such as civility training and team building exercises ';
	$organizationGenericMsg .= 'may improve this area. The organization should also look into their ';
	$organizationGenericMsg .= 'existing organizational policies and see what could be changed to ';
	$organizationGenericMsg .= 'further improve the interpersonal work environment. Organizational ';
	$organizationGenericMsg .= 'culture interventions are also recommended.</p>';
	
	return $organizationGenericMsg;
}

// Calculate Organization Average Score per Scale (4 sub scales) for this reporting period
function calculateOrganizationAverageScore($meta_key, $my_gform_id, $report_start_date, $report_end_date) {
	global $wpdb;

	// Submission entry date/time (EST)
	date_default_timezone_set('America/New_York');
	$start_date = ( isset($report_start_date) ) ? $report_start_date->format('Y-m-d'): date('Y-m-d');
	$end_date = (isset($report_end_date) ) ? $report_end_date->format('Y-m-d'): date('Y-m-d');

	$sql  = "SELECT AVG(scaleScore.`meta_value`) AS 'averageScore' FROM ";
	$sql .= "(select * FROM `wp_gf_entry_meta` WHERE `meta_key` = '".$meta_key."') scaleScore, ";
	$sql .= "(select * FROM `wp_gf_entry_meta` WHERE `meta_key` = 'survey_entry_submitted_date' ";
	$sql .= "AND `meta_value` BETWEEN '".$start_date."' AND '".$end_date."') reportingPeriod ";
	$sql .= "WHERE scaleScore.`entry_id` = reportingPeriod.`entry_id` AND ";
	$sql .= "reportingPeriod.`form_id` = ".$my_gform_id;

	$results = $wpdb->get_results( $sql, ARRAY_A );

	$averageScore = (isset($results[0]) && isset($results[0]['averageScore'])) ? 
		$results[0]['averageScore'] : 0;

	// echo "<br><br>".$sql;
	// echo "<br>"; print_r($results);

	return $averageScore;
}

// Participant Report
function getParticipantReportMsg(){
	$participantReportMsg  = '<br><br><p>Thank you for your participation.</p>';

	$participantReportMsg .= '<p>Understanding and regularly monitoring your behaviours, perceptions, ';
	$participantReportMsg .= 'and experiences, can help increase your level of awareness of your ';
	$participantReportMsg .= 'vulnerability and risk for stress and other health concerns that can ';
	$participantReportMsg .= 'increase your risk of experiencing an Occupational Stress Injury (OSI). ';
	$participantReportMsg .= 'It is ok and helpful to acknowledge when you are feeling unwanted levels ';
	$participantReportMsg .= 'of stress and concern. Spend time to identify what might be contributing ';
	$participantReportMsg .= 'to your levels of stress. It is also ok to ask for help.</p>';

	$participantReportMsg .= '<p>Through early recognition and intervention, you can mitigate your ';
	$participantReportMsg .= 'risk for OSI. You will find some general tips and recommendations below:</p>';
	
	$participantReportMsg .= '<h3>Resiliency Behaviours</h3>';
	$participantReportMsg .= '<p><ul><li>Research suggests that resilience involves a combination of activating internal qualities and accessing external resources to positively deal with stress, setbacks and work through problems. Put simply, resilient people draw from both their strengths and support systems to face challenges. Actively practicing self-care and resilience techniques can increase your capacity to cope, overcome, and thrive through challenging times. Learning more about resilience is encouraged. Find out more by accessing <a href="https://www.pshsa.ca/training/free-training/resilientme" target="_blank">ResilientME</a></li>';
	$participantReportMsg .= '<li>Take steps to make self-care a priority including establishing positive routines and structures, nurturing your social connections and relationships, staying active and eating healthy. You may find additional resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
	$participantReportMsg .= '<li>It is important to recognize your limits and signs of burn out. Here is a webinar that explores different ways that people can <a href="https://www.pshsa.ca/training/free-training/beating-the-burnout-blues" target="_blank">cope with feelings of stress and burnout</a></li></ul></p>';

	$participantReportMsg .= '<h3>Supportive Environment</h3>';
	$participantReportMsg .= '<p><ul><li>Being treated with respect, having healthy workplace social connections, and feeling that at least some aspects of your organization are a good fit for you are some factors that build a supportive environment. Create open dialogue on how your work team can take steps to be a more supportive environment to not only yourself but those around you.</li>';
	$participantReportMsg .= '<li>Keep in mind you do not need to figure this out alone. There is help. Even talking to a family member or trusted peer about support options can be a good place to start. With support there is a way to move toward feeling better.  If you are interested in free confidential peer-support, consider contacting Boots on the Ground Peer Support for First Responders at 1-833-677-2668 or visit <a href="https://www.bootsontheground.ca" target="_blank">www.bootsontheground.ca</a>. Here is a webinar that you may find helpful about <a href="https://www.pshsa.ca/training/free-training/speaking-to-colleagues-and-staff-about-mental-health" target="_blank">speaking to colleagues about mental health</a></li></ul></p>';

	$participantReportMsg .= '<h3>Support Programs</h3>';
	$participantReportMsg .= '<p><ul><li>Consider speaking to a mental health professional if you are not already doing so. They can help you explore options to reduce your current feelings of stress. To access mental health professionals, you can consider various options including EFAP (e.g., trauma care), paramedical psychological services, and in-house psychological services. If you are having any thoughts of suicide, contact National Crisis line at 1-833-456-4566</li>';
	$participantReportMsg .= '<li>The right support programs can be meaningful and helpful in times of need. Seek out and ask for information on what mental health programs your organization offers. There may be existing supports and resources that you don’t know about either within your organization or within your community.</li>';
	$participantReportMsg .= '<li>Stay active in organizational health and wellness initiatives.</li></ul></p>';

	$participantReportMsg .= '<h3>Supportive Leadership</h3>';
	$participantReportMsg .= '<p><ul><li>A trusting relationship between you and your leadership is important to help support you in times of stress. Other roles within the organization that can offer support include colleagues, human resources, health & safety groups, etc.</li>';
	$participantReportMsg .= '<li>Take time to understand what resources are available to you to help you cope with stress. This can include supportive relationships, resources offered through your organization, as well as self-care.</li></ul></p>';

	return $participantReportMsg;
}

// ------------------------------------------------------------------------------------------

// Show PDF Links in the organization report page (short code doesn't work for Gravity PDF)
/* function showPDFLinks ($entry_id) {
	if ($entry_id > 0) {
		echo do_shortcode("[gravitypdf name='OSIR Organization Report PDF' id='61691d54897ef' entry=".$entry_id." text='Save As PDF']");
		echo " | ";
		echo do_shortcode("[gravitypdf name='OSIR Organization Report PDF' id='61691d54897ef' entry=".$entry_id." text='Print PDF' print='1']");
	}
} */

//
