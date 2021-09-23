<?php

//----------------------------------------------------------------------------------------
// Survey Submission Confirmation Messages

// Get survey user OSIR profile
function getUserProfile ($total_score = 0){
	$userProfile = 'N/A';

	if (0 <= $total_score && $total_score <= 27 ) {
		$userProfile = 'Challenge';
	} elseif (27 < $total_score && $total_score < 81 ) {
		$userProfile = 'Concern';
	} elseif (81 <= $total_score ) {
		$userProfile = 'Thriving';
	}

	return $userProfile;
}

// Get user OSIR profile message
function getUserProfileMsg ($userProfile ='N/A', $total_resiliency_behaviours_score,
		$total_support_programs_score, $total_supportive_leadership_score, $total_supportive_environment_score) {
	$userProfileMsg  = '<h3>Overall</h3>';
	$userProfileMsg .= '<p>Based on the four scales above your OSI Risk score is: <b>'.$userProfile.'</b></p>'; 
	$userProfileMsg .= '<p>Your Resiliency Behaviours score is: <b>' . $total_resiliency_behaviours_score.'</b></p>';
	$userProfileMsg .= '<p>Your Support Programs score is: <b>' . $total_support_programs_score.'</b></p>';
	$userProfileMsg .= '<p>Your Supportive Leadership score is: <b>' . $total_supportive_leadership_score.'</b></p>';
	$userProfileMsg .= '<p>Your Supportive Environment Score is: <b>' . $total_supportive_environment_score.'</b></p>';
	
	// $userProfileMsg .= '<p>Below you will find profiles of the following risk scores: Thriving, ';
	// $userProfileMsg .= 'Concern, and Challenge. Each of these profiles has information that can ';
	// $userProfileMsg .= 'help increase your awareness, and tips that you can act on.</p>';
	// $userProfileMsg .= '<p>Challenge = ≤ 27</p>';
	// $userProfileMsg .= '<p>Concern = >27, < 81</p>';
	// $userProfileMsg .= '<p>Thriving = ≥ 81</p>'; 

	if ($userProfile === 'Challenge') {
		$userProfileMsg .= '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>It is common for individuals reporting at this level to be experiencing ';
		$userProfileMsg .= 'chronic feelings of work and life distress.</p>';
		$userProfileMsg .= '<p>Were you feeling concerned or stressed-before you used this tool? Most ';
		$userProfileMsg .= 'of the time we know things are not going as well as we would like. At this ';
		$userProfileMsg .= 'level it is important to recognize where you are and know that there are ';
		$userProfileMsg .= 'steps that you can take to reduce your level of concern. The tips below will ';
		$userProfileMsg .= 'help you explore how to get out of this level in health and safe way.</p>';
		
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>It is ok and helpful to acknowledge you are feeling unwanted levels of stress and concern. It is also ok to ask for help.</li>';
		$userProfileMsg .= '<li>If you are already talking to a mental health professional and you feel comfortable, share the results of this assessment so that they can help you explore options to help you reduce your current feelings of stress.</li>';
		$userProfileMsg .= '<li>Consider speaking to a mental health professional if you are not already doing so. They can help you explore options to assist to reduce your current feelings of stress. To access mental health professionals, you can consider various options including EFAP (e.g., trauma care), paramedical psychological services, and in-house psychological services</li>';
		$userProfileMsg .= '<li>Keep in mind you do not need to figure this out alone. There is help. Even talking to trusted peer about support options can be a good place to start. With support there is a way to move toward feeling better. If you are interested in free confidential peer support, consider contacting Boots on the Ground Peer Support for First Responders at 1-833-677-2668 or visit <a href="https://www.bootsontheground.ca" target="_blank">www.bootsontheground.ca</a></li>';
		$userProfileMsg .= '<li>Take steps to make self-care a priority including staying active and eating healthy. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>If you are having any thoughts of suicide, contact National Crisis line at 1-833-456-4566</li></ul></p>';
	} else if ($userProfile === 'Concern') {
		$userProfileMsg .= '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>Individuals reporting at this level may be doing well some days but may struggle other days and experience some degree of concern and unwanted stress.</p>';
		$userProfileMsg .= '<p>Mental health is not a static state, and you can experience various feelings across a continuum from languishing to flourishing. In fact, it is common to have challenging moments and good days.</p>';
		$userProfileMsg .= '<p>Recognizing what may be causing stress can be a good place to start. Once you understand your stressors you can create a plan on how to reduce and remove this stress.</p>';

		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>It is ok and helpful to acknowledge when you are feeling unwanted levels of concern and to spend time to identify what might be contributing to your levels of stress. It is ok to ask for help.</li>';
		$userProfileMsg .= '<li>It is important to recognize your limits. If you are feeling burnt out you can view this free webinar which will help you explore different ways that people try to <a href="https://www.pshsa.ca/training/free-training/beating-the-burnout-blues" target="_blank">cope with feelings of stress and burnout.</a></li>';
		$userProfileMsg .= '<li>Take time to understand what resources are available to you to help you cope with stress. This can include supportive relationships, resources offered through your organization to help with coping with stress, as well as self-care.</li>';
		$userProfileMsg .= '<li>Take steps to ensure that you are maintaining structure in your life, such as setting and maintaining daily routines.</li>';
		$userProfileMsg .= '<li>Training in resiliency and coping skills can be helpful to help develop and improve your mental fitness.</li>';
		$userProfileMsg .= '<li>Take steps to make sure you are physically active, eating well, and sleeping. These along with having healthy social connections are core for supporting mental health. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>It is important to maintain social connections. Reaching out and talking to a family member or trusted peers, or even a mental health professional, or an occupational therapist who can help you find tools to manage stress, can be helpful to get you moving toward green if you are unsure how to improve your situation. Here is a webinar that you may find helpful about <a href="https://www.pshsa.ca/training/free-training/speaking-to-colleagues-and-staff-about-mental-health" target="_blank">speaking to colleagues about mental health</a></li>';
		$userProfileMsg .= '<li>If you are interested in free confidential peer-support consider contacting Boots on the Ground Peer Support for First Responders at 1-833-677-2668 or visit <a href="https://www.bootsontheground.ca" target="_blank">www.bootsontheground.ca</a></li></ul></p>';
	} else if ($userProfile === 'Thriving') {
		$userProfileMsg .= '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>Individuals who fall in this category are typically doing well and feel they have most things under control and are managing their job stress accordingly. It is important to check how you are doing on an ongoing basis and maintain your self-care.</p>';
		
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>Take time to establish positive routines and structures and nurture your social connections and relationships.</li>';
		$userProfileMsg .= '<li>Take time for self-care, eating health and getting the sleep and rest that you need. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>Proactively learn about supports and resources offered by your organization. Stay active in organizations health and wellness initiatives.</li>';
		$userProfileMsg .= '<li>Taking training in resiliency and coping skills can be helpful to help develop and improve your mental fitness.</li>';
		$userProfileMsg .= '<li>Developing a mental fitness plan can help you keep your battery charged.</li>';
		$userProfileMsg .= '<li>It is ok to not always feel at your best, and in times of stress it is OK to ask for help or seek peer or professional support.</li>';
		$userProfileMsg .= '<li>Learn tips for <a href="https://www.pshsa.ca/training/free-training/beating-the-burnout-blues" target="_blank">coping with feelings of stress and burnout</a> to help you maintain your health.</li></ul></p>';
	}
	
	return $userProfileMsg;
}

// Get user profile generic message
function getUserProfileGenericMsg () {
	$userProfileGenericMsg  = '<br><p>Thank you for your participation. You will find your OSI risk assessment report below:</p>';
	$userProfileGenericMsg .= '<h3>RISK OF DEVELOPING AN OCCUPATOINAL STRESS INJURY</h3>';
	$userProfileGenericMsg .= '<p>Your overall OSI risk score is calculated from four scales. ';
	$userProfileGenericMsg .= 'Scoring high on these scales indicates that you have the resources ';
	$userProfileGenericMsg .= 'available to help cope with stressors at work. Scoring low on these ';
	$userProfileGenericMsg .= 'scales indicates that you may not have the necessary resources to ';
	$userProfileGenericMsg .= 'cope with workplace stressors and are at risk for OSI. Understanding ';
	$userProfileGenericMsg .= 'and regularly monitoring your behaviours, perceptions, and experiences, ';
	$userProfileGenericMsg .= 'can help increase your level of awareness of your vulnerability and ';
	$userProfileGenericMsg .= 'risk for stress and other health concerns that can increase your risk ';
	$userProfileGenericMsg .= ' of experiencing an OSI. Through early recognition and ';
	$userProfileGenericMsg .= 'intervention, you can mitigate your risk for OSI.</p>';

	$userProfileGenericMsg .= '<h3>Resiliency behaviours</h3>';
	$userProfileGenericMsg .= '<p>Resiliency behaviours focus on what you do to try to maintain your mental health.</p>';
	$userProfileGenericMsg .= '<p><b>Your Resiliency Behaviours score: /12</b></p>';
	$userProfileGenericMsg .= '<p>Scoring high (nine or higher) on this indicates that you are actively ';
	$userProfileGenericMsg .= 'practicing resilience techniques and are using available support ';
	$userProfileGenericMsg .= 'systems. If you scored low (three or lower) on this scale, you should ';
	$userProfileGenericMsg .= 'seek out support from trusted persons. Attending training sessions ';
	$userProfileGenericMsg .= 'on resilience and/or reading about resilience are encouraged.</p>';

	$userProfileGenericMsg .= '<h3>Support Programs</h3>';
	$userProfileGenericMsg .= '<p>Support programs refer to the perceptions that the organization ';
	$userProfileGenericMsg .= 'has mental health programs available for you and that you find that ';
	$userProfileGenericMsg .= 'these programs are helpful.</p>';
	$userProfileGenericMsg .= '<p><b>Your Support Programs score: /44</b></p>';
	$userProfileGenericMsg .= '<p>Scoring high on this (33 or higher) indicates that you feel there ';
	$userProfileGenericMsg .= 'are strong programs at work that you feel you can use when necessary. ';
	$userProfileGenericMsg .= 'If you scored low on this scale (11 or lower), you should seek out ';
	$userProfileGenericMsg .= 'and ask for information on what mental health programs the organization ';
	$userProfileGenericMsg .= 'offers. There may be existing programs that you don\'t know about ';
	$userProfileGenericMsg .= 'either within your organization or within your community.</p>';

	$userProfileGenericMsg .= '<h3>Supportive Leadership</h3>';
	$userProfileGenericMsg .= '<p>Supportive leadership focus specifically on your perception of ';
	$userProfileGenericMsg .= 'your leader/direct manager. </p>';
	$userProfileGenericMsg .= '<p><b>Your Supportive Leadership score: /20</b></p>';
	$userProfileGenericMsg .= '<p>Scoring high on this indicates that you trust your leader and ';
	$userProfileGenericMsg .= 'that your leader engages in behaviours that support you at work. ';
	$userProfileGenericMsg .= 'If you scored low on this scale (five or lower), reach out to another ';
	$userProfileGenericMsg .= 'leader in the organization for support (e.g., human resources, health ';
	$userProfileGenericMsg .= '& safety, a colleague). Building a trust relationship with them or ';
	$userProfileGenericMsg .= 'getting their advice on how to build a trusting relationship with ';
	$userProfileGenericMsg .= 'your leader is important to help support you in times of stress.</p>';

	$userProfileGenericMsg .= '<h3>Supportive Environment</h3>';
	$userProfileGenericMsg .= '<p>Supportive environment encompasses how you perceive your workplace ';
	$userProfileGenericMsg .= 'and how you feel you are treated at work (outside of leadership).</p>';
	$userProfileGenericMsg .= '<p><b>Your Supportive Environment score: /28</b></p>';
	$userProfileGenericMsg .= '<p>Scoring high on this (21 or higher) indicates that you feel treated ';
	$userProfileGenericMsg .= 'with respect, have healthy workplace social connections, and feel ';
	$userProfileGenericMsg .= 'that at least some aspects of your organization are a good fit for ';
	$userProfileGenericMsg .= 'you. If you scored low on this scale (seven or lower), reach out to ';
	$userProfileGenericMsg .= 'your leader or a support (e.g., human resources, a more senior leader, ';
	$userProfileGenericMsg .= 'etc.) to help create open dialogue on how the team can take steps to be a ';
	$userProfileGenericMsg .= 'more supportive environment to not only yourself but those around you. </p>';

	return $userProfileGenericMsg;
}

//
