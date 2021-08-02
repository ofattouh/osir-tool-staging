/*******************************************************************************
// Charts DB Queries

// Grand total number of all answers
SELECT SUM(totalNumberAnswers.`meta_value`) AS 'grandTotalNumberAnswers' FROM 
(select * FROM `wp_gf_entry_meta` WHERE `meta_key` = 'total_number_of_answers') totalNumberAnswers

//

// OSIR Profile Pie Chart (Occupational Stress Injury Resiliency (OSIR) Index Score)

SELECT `meta_value` AS OSIR_Profile, COUNT(*) AS Count
FROM `wp_gf_entry_meta`
WHERE `meta_key` = 'osir_profile'
AND `form_id` = 17
GROUP BY `meta_value`

SELECT `wp_gf_entry_meta`.`meta_value` AS OSIR_Profile, COUNT(*) AS Count
FROM `wp_gf_entry_meta`, (select * FROM `wp_gf_entry_meta` 
 WHERE `meta_key` = 'my_gform_id' AND `meta_value` = 10) my_gform_id
 WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'
 AND `wp_gf_entry_meta`.`entry_id` = my_gform_id.`entry_id`
 AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY OSIR_Profile


SELECT AVG(osirProfile.osirProfileCount) AS 'Company Average Score' FROM 
(select COUNT(*) AS osirProfileCount FROM `wp_gf_entry_meta` 
 WHERE `meta_key` = 'osir_profile' GROUP BY `meta_value`) osirProfile

// 

// What is your current vocation? (OSIR Index Score by Department) 

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', COUNT(*) AS 'count', 
demographicVocation.`meta_value`
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'demographic_vocation' ) demographicVocation 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile'
AND `wp_gf_entry_meta`.`entry_id` = demographicVocation.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile, demographicVocation.`meta_value`
ORDER BY osirProfile ASC

//

// General Mental Outlook Score (Average score by vulnerability profile)

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
AVG(outlookScore.`meta_value`) AS 'Outlook Score Average' 
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'total_outlook_score' ) outlookScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = outlookScore.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

SELECT AVG(mentalOutlookScoreAvg.outlookScoreAverage) as "Company Score Average"
FROM 
(
SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
AVG(outlookScore.`meta_value`) AS 'outlookScoreAverage' 
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'total_outlook_score' ) outlookScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = outlookScore.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile
) AS mentalOutlookScoreAvg

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', COUNT(*) AS 'Count', SUM(outlookScore.`meta_value`) AS outlookScoreProfile, AVG(outlookScore.`meta_value`) AS outlookScoreProfileAvg 
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'total_outlook_score' ) outlookScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = outlookScore.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17 
GROUP BY osirProfile

SELECT `wp_gf_entry_meta`.`entry_id`, `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
outlookScore.`meta_value` AS outlookScore 
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'total_outlook_score' ) outlookScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = outlookScore.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17


//

// How many total years of service have you spent as a First Responder (in all applicable roles)?
// Average OSIR Index score by years of service

SELECT osirYearsOfService.`meta_value` AS 'yearsOfService', 
AVG(`wp_gf_entry_meta`.`meta_value`) AS 'averageOSIRScore' 
FROM `wp_gf_entry_meta`, 
(SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'osir_years_of_service') osirYearsOfService 
WHERE `wp_gf_entry_meta`.`meta_key` = 'total_osir_score' 
AND `wp_gf_entry_meta`.`entry_id` = osirYearsOfService.`entry_id` 
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirYearsOfService.`meta_value` 
ORDER BY LENGTH(osirYearsOfService.`meta_value`) ASC, osirYearsOfService.`meta_value` ASC

SELECT osirYearsOfService.`meta_value` AS 'yearsOfService', Count(*), 
SUM(`wp_gf_entry_meta`.`meta_value`) AS 'Total OSIR Index score', 
AVG(`wp_gf_entry_meta`.`meta_value`) AS 'Average OSIR Index score'
FROM `wp_gf_entry_meta`, 
(SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'osir_years_of_service') osirYearsOfService 
WHERE `wp_gf_entry_meta`.`meta_key` = 'total_osir_score' 
AND `wp_gf_entry_meta`.`entry_id` = osirYearsOfService.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirYearsOfService.`meta_value` 
ORDER BY LENGTH(osirYearsOfService.`meta_value`) ASC, osirYearsOfService.`meta_value` ASC

//

// 1.	Attendance – number of days missed work due to illness

SELECT `wp_gf_entry_meta`.`entry_id`, 
`wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
absenteeismOSIRProfile.`meta_value` AS 'numberOfMissedDays'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'absenteeism_osir_profile' ) absenteeismOSIRProfile
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = absenteeismOSIRProfile.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
AVG(absenteeismOSIRProfile.`meta_value`) AS 'averageAbsenteeism' 
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'absenteeism_osir_profile' ) absenteeismOSIRProfile 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = absenteeismOSIRProfile.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

SELECT `wp_gf_entry_meta`.`entry_id`, 
`wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
absenteeismOSIRProfile.`meta_value` AS 'Absenteeism',
AVG(absenteeismOSIRProfile.`meta_value`) AS 'averageAbsenteeism'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'absenteeism_osir_profile' ) absenteeismOSIRProfile
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = absenteeismOSIRProfile.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17

//

// 6.	Trauma/Very stressful situation exposures – Please estimate how many events have you 
// deal with that you have found traumatic/very stressful in the past 12 months 
// Exposure to stress/trauma

// 7 or more (value 7)
// Do not know (value 0)

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
AVG(numberTraumaEvents.`meta_value`) AS "Average Number of Trauma Events"
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'number_trauma_events' ) numberTraumaEvents
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = numberTraumaEvents.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

SELECT `wp_gf_entry_meta`.`entry_id`, `wp_gf_entry_meta`.`meta_value` AS 'osirProfile',
count(*),
numberTraumaEvents.`meta_value` AS "Number of Trauma Events",
SUM(numberTraumaEvents.`meta_value`) AS "Total Number of Trauma Events",
AVG(numberTraumaEvents.`meta_value`) AS "Average Number of Trauma Events"
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'number_trauma_events' ) numberTraumaEvents
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = numberTraumaEvents.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

//

// Do you use tobacco products? This includes smoking cigarettes and cigars as well as using chewing tobacco

SELECT employeeByTobaccoUse.`meta_value` AS 'Tobacco use',
count(*) AS 'Number of Employees'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'tobacco_use' ) employeeByTobaccoUse
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByTobaccoUse.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByTobaccoUse.`meta_value`

SELECT `wp_gf_entry_meta`.`meta_value` AS 'Is survey submitted', 
count(*) AS 'Number of Employees',
employeeByTobaccoUse.`meta_value` AS 'Tobacco use'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'tobacco_use' ) employeeByTobaccoUse
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByTobaccoUse.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByTobaccoUse.`meta_value`

//

// 3.	Short term disability – Over the past 12 months, have you been off work for a mental 
// health-related matter?

SELECT employeeByShorTermDisability.`meta_value` AS 'Short Term Disability',
count(*) AS 'Number of Employees'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'short_term_disability' ) employeeByShorTermDisability
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByShorTermDisability.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByShorTermDisability.`meta_value`

//

// 4.	WCB claim – Over the past 12 months, have you made a worker’s compensation claim related
// to an Occupational Stress Injury (such as PTSD and other similar mental illnesses)?

SELECT employeeByWCBClaim.`meta_value` AS 'WCB Claim',
count(*) AS 'Number of Employees'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'wcb_claim' ) employeeByWCBClaim
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByWCBClaim.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByWCBClaim.`meta_value`

//

// Have you ever been clinically diagnosed with a mental illness or addictive disorder?
// Number of employees with a mental illness or addictive disorder (Clinical diagnosis)

SELECT employeeByDiagnosedMentalIllness.`meta_value` AS 'Mental Illness Diagnosis',
count(*) AS 'Number of Employees'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'clinically_diagnosed_mental_illness' ) employeeByDiagnosedMentalIllness
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByDiagnosedMentalIllness.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByDiagnosedMentalIllness.`meta_value`

SELECT `wp_gf_entry_meta`.`meta_value` AS 'Is survey submitted',
count(*) AS 'Number of Employees',
employeeByDiagnosedMentalIllness.`meta_value` AS 'Mental Illness Diagnosis'
FROM `wp_gf_entry_meta`, 
( SELECT * FROM `wp_gf_entry_meta` WHERE meta_key = 'clinically_diagnosed_mental_illness' ) employeeByDiagnosedMentalIllness
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`entry_id` = employeeByDiagnosedMentalIllness.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY employeeByDiagnosedMentalIllness.`meta_value`


//***************************************************************************************

// Survey charts short codes

// Total number of submissions

SELECT count(*) AS 'numberSubmissions'
FROM `wp_gf_entry_meta`
WHERE `wp_gf_entry_meta`.`meta_key` = 'is_survey_entry_submitted_by_user' 
AND `wp_gf_entry_meta`.`meta_value` = 'yes'
AND `wp_gf_entry_meta`.`form_id` = 17

// OSIR average company score (Pie chart)

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
Count(*), 
SUM(osirScore.`meta_value`) AS 'Total OSIR score'
FROM `wp_gf_entry_meta`, 
(SELECT * FROM `wp_gf_entry_meta` WHERE `meta_key` = 'total_osir_score') osirScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = osirScore.`entry_id`
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

// General mental outlook average company score

SELECT `wp_gf_entry_meta`.`meta_value` AS 'osirProfile', 
Count(*), 
SUM(outlookScore.`meta_value`) AS 'totalOutlookScore',
AVG(outlookScore.`meta_value`) AS 'avgOutlookScore'
FROM `wp_gf_entry_meta`, 
(SELECT * FROM `wp_gf_entry_meta` WHERE `meta_key` = 'total_outlook_score') outlookScore 
WHERE `wp_gf_entry_meta`.`meta_key` = 'osir_profile' 
AND `wp_gf_entry_meta`.`entry_id` = outlookScore.`entry_id` 
AND `wp_gf_entry_meta`.`form_id` = 17
GROUP BY osirProfile

//
