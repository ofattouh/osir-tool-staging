<?php

//----------------------------------------------------------------------------------------
// Survey Submission Confirmation Messages

// Get survey user OSIR profile
function getUserProfile ($total_score = 0){
	$userProfile = 'N/A';

	if (0 <= $total_score && $total_score <= 40 ) {
		$userProfile = 'Challenge';
	} elseif (41 <= $total_score && $total_score <= 80 ) {
		$userProfile = 'Concern';
	} elseif (81 <= $total_score && $total_score <= 120 ) {
		$userProfile = 'OK';
	} elseif (121 <= $total_score && $total_score <= 160 ) {
		$userProfile = 'Thriving';
	}

	return $userProfile;
}

// Get user OSIR profile message
function getUserProfileMsg ($userProfile ='N/A') {
	if ($userProfile === 'Challenge') {
		$userProfileMsg  = '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>It is common for individuals reporting at this level to be experiencing chronic feelings of work and life distress.</p>';
		$userProfileMsg .= '<p>Were you feeling concerned or stressed before you used this tool? Most of the time we know things are not going as well as we would like. At this level it is important to recognize where you are and know';
		$userProfileMsg .= ' that there are steps that you can take to reduce your level of concern. The tips below will help you explore how to get out of this level in health and safe way.</p>';
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>It is ok and helpful to acknowledge you are feeling unwanted levels of stress and concern.  It is also ok to ask for help.</li>';
		$userProfileMsg .= '<li>If you are already talking to a mental health professional and you feel comfortable, share the results of this assessment so that they can help you explore options to help you reduce your current feelings of stress.</li>';
		$userProfileMsg .= '<li>Consider speaking to a mental health professional if you are not already doing so. They can help you explore options to assist to reduce your current feelings of stress. To access mental health professionals, you can consider various options including EFAP (e.g., trauma care), paramedical psychological services, in-house psychological services.</li>';
		$userProfileMsg .= '<li>Keep in mind you do not need to figure this out alone there is help. Even talking to trusted peer about support options can be a good place to start. With support there is a way to move toward green and feeling better.  If you are interested in free confidential peer support consider contacting Boots on the Ground Peer Support for First Responders at 1-833-677-2668 or visit <a href="https://www.bootsontheground.ca" target="_blank">www.bootsontheground.ca</a></li>';
		$userProfileMsg .= '<li>Take steps to make self-care a priority including staying active and eat healthy. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>If you are having any thoughts of suicide contact National Crisis line 1.833.456.4566</li></ul></p>';
	} else if ($userProfile === 'Concern') {
		$userProfileMsg  = '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>Individuals reporting at this level are typically struggling and experiencing some degree of concern and unwanted stress. Recognizing what may be causing stress can be a good place to start. Once you understand your stressors you can create a plan on how to reduce and remove this stress.</p>';
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>It is ok and helpful to acknowledge you are feeling unwanted levels of concern and to spend time to identify what might be contributing to your levels of stress. It is ok to ask for help.</li>';
		$userProfileMsg .= '<li>Take time to understand what resources are available to you to help you cope with stress. This can include supportive relationships, resources offered through your organization to help with coping with stress, as well as self-care.</li>';
		$userProfileMsg .= '<li>Take steps to ensure that you are maintaining structure in your life, such as setting and maintaining daily routines.</li>';
		$userProfileMsg .= '<li>Taking training in resiliency and coping skills can be helpful to help develop and improve your mental fitness.</li>';
		$userProfileMsg .= '<li>Take steps to make sure you are physically active, eating well, sleep and healthy social connections are core for supporting mental health. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>It is important to maintain social connections. Reaching out and talking to a family member or trusted peers, or even a mental health professional, or an occupational therapist who can help you find tools to manage stress, can be helpful to get you moving toward green if you are unsure how to improve your situation. Here is a webinar that you may find helpful about <a href="https://www.pshsa.ca/training/free-training/speaking-to-colleagues-and-staff-about-mental-health" target="_blank">speaking to colleagues about mental health</a></li>';
		$userProfileMsg .= '<li>If you are interested in free confidential peer support consider contacting Boots on the Ground Peer Support for First Responders at 1-833-677-2668 or visit <a href="https://www.bootsontheground.ca" target="_blank">www.bootsontheground.ca</a></li></ul></p>';
	} else if ($userProfile === 'OK') {
		$userProfileMsg  = '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>It is common for a person reporting at this level to think most days are doing OK.  However, it is good to also recognize when you are experiencing a more challenging day, or periods where you feel worried and stressed about life or work. Mental health is not a static state and you can experience various feeling across a continuum from languishing to flourishing.</p>';
		$userProfileMsg .= '<p>In fact, it common to have challenging moments and good days. If you have any concerns, it is helpful to be proactive and deal with them early, so they do not have a chance to grow.</p>';
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>If you have any stress you like to get rid of it helpful to first recognize what is causing you unwanted bad stress that is draining your battery.</li>';
		$userProfileMsg .= '<li>Proactively learn about the resources and supports offered by your organization so that you can access them when you need them.</li>';
		$userProfileMsg .= '<li>It is important to recognize your limits. If you are feeling burnt out you can view this free webinar which will help you explore different ways that people try to <a href="https://www.pshsa.ca/training/free-training/beating-the-burnout-blues?gaProductTitle=Beating+the+Burnout+Blues&gaProductEvent=Download" target="_blank">cope with feelings of stress and burnout.</a></li>';
		$userProfileMsg .= '<li>Maintain your structure and daily routines.</li>';
		$userProfileMsg .= '<li>Taking training in resiliency and coping skills can be helpful to help develop and improve your mental fitness.</li>';
		$userProfileMsg .= '<li>Stay active engaging your social connections and social network can help with managing daily challenges and to feel connected.</li>';
		$userProfileMsg .= '<li>It is important that you are taking steps to stay physically active and eat well to support your mental health. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>It is ok to not always feel at your best. It is also ok to ask for help If you have stress you are not sure how to deal with it is perfectly fine to discuss your situation with a trusted peer, or to even have a conversation with a mental health professional, or and <a href="https://www.pshsa.ca/training/free-training/speaking-to-colleagues-and-staff-about-mental-health" target="_blank">occupational therapist</a> who can help you find tools to manage stress, as a proactive step we do not need to in crisis to get professional support. Here is a webinar that you may find helpful about <a href="https://www.pshsa.ca/training/free-training/speaking-to-colleagues-and-staff-about-mental-health" target="_blank">speaking to colleagues about mental health</a></li></ul></p>';
	} else if ($userProfile === 'Thriving') {
		$userProfileMsg  = '<h3>Interpretation</h3>';
		$userProfileMsg .= '<p>Individuals who fall in this category are typically doing well and feel they have most things in control and managing their job stress accordingly. It is important to check how you are doing on an ongoing basis and maintain your self-care.</p>';
		$userProfileMsg .= '<h3>Recommendations</h3>';
		$userProfileMsg .= '<p><ul><li>Take time to establish positive routines and structures and nurture your social connections and relationships.</li>';
		$userProfileMsg .= '<li>Take time for self-care, eating health and getting the sleep and rest that you need. You may find helpful resources at <a href="https://www.pshsa.ca/healthy-workers" target="_blank">https://www.pshsa.ca/healthy-workers</a></li>';
		$userProfileMsg .= '<li>Proactively learn about supports and resources offered by your organization. Stay active in organizations health and wellness initiatives.</li>';
		$userProfileMsg .= '<li>Taking training in resiliency and coping skills can be helpful to help develop and improve your mental fitness.</li>';
		$userProfileMsg .= '<li>Developing a mental fitness plan can help you keep your battery charged.</li>';
		$userProfileMsg .= '<li>It is ok to not always feel at your best, and in times of stress if it OK to ask for help, seek peer or professional support.</li>';
		$userProfileMsg .= '<li>Learn tips for <a href="https://www.pshsa.ca/training/free-training/beating-the-burnout-blues?gaProductTitle=Beating+the+Burnout+Blues&gaProductEvent=Download" target="_blank">coping with feelings of stress and burnout</a> to help you maintain your health</li></ul></p>';
	}
	
	return $userProfileMsg;
}

// Get user profile generic message
function getUserProfileGenericMsg () {
	$userProfileGenericMsg  = '<br><br><p>Thank you for your participation. You will find your OSI risk assessment report below:</p>';
	$userProfileGenericMsg .= '<h3>REPORT: RISK OF DEVELOPING AN OCCUPATOINAL STRESS INJURY</h3>';
	$userProfileGenericMsg .= '<p>Your overall OSI risk score is calculated using several data points from this survey.';
	$userProfileGenericMsg .= ' This report is meant to be screening tool only. By regularly monitoring your behaviours,';
	$userProfileGenericMsg .= ' perceptions and experiences you can help increase your level of awareness of your';
	$userProfileGenericMsg .= ' vulnerability and risk for stress and concern that can increase you risk for experiencing';
	$userProfileGenericMsg .= ' an OSI. Through early recognition and intervention, you can mitigate you risk for OSI.</p>';
	$userProfileGenericMsg .= '<p>Below you will find four profiles: Thriving, OK, Concern, and Challenge. Each of these';
	$userProfileGenericMsg .= ' profiles has information that can help increase your awareness, and tips that you can act on.</p>';

	return $userProfileGenericMsg;
}

//
