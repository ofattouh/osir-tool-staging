<?php

//----------------------------------------------------------------------------------------
// Member Press & Gravity Form custom hooks


// Numeric fields custom validation
add_filter( 'gform_field_validation_18_176', 'validate_attendance_presenteeism_wcb_claim_trauma_fields', 10, 4 );
add_filter( 'gform_field_validation_18_178', 'validate_attendance_presenteeism_wcb_claim_trauma_fields', 10, 4 );
add_filter( 'gform_field_validation_18_177', 'validate_attendance_presenteeism_wcb_claim_trauma_fields', 10, 4 );
add_filter( 'gform_field_validation_18_181', 'validate_attendance_presenteeism_wcb_claim_trauma_fields', 10, 4 );
function validate_attendance_presenteeism_wcb_claim_trauma_fields( $result, $value, $form, $field ) {

  if (is_numeric($value)){
    $validated_value = ($value == (int) $value) ? (int) $value : (float) $value;
  } else{
    $validated_value = $value;
  }

  /*
  echo "<br><br>result";
  echo $field->id;
  print_r($result);
  
  echo "<br><br>value<br>";
  var_dump($value);
  var_dump($validated_value);

  echo "<br><br>is_numeric<br>";
  print_r(is_numeric($value));
  echo "<br>is_numeric2<br>";
  print_r(is_numeric($validated_value));
  */

  if ( $result['is_valid'] && !is_int($validated_value) ) {
    $result['is_valid'] = false;
    $result['message'] = 'Only positive whole numeric values between 0 to 90 (inclusive) are allowed';
  } else if ($result['is_valid'] && (0 > $validated_value || $validated_value > 90) ){
    $result['is_valid'] = false;
    $result['message'] = 'Only positive whole numeric values between 0 to 90 (inclusive) are allowed';
  }

  return $result;
}

// Numeric field custom validation. What is your age?
add_filter( 'gform_field_validation_18_180', 'validate_age_field', 10, 4 );
function validate_age_field( $result, $value, $form, $field ) {

  if (is_numeric($value)){
    $validated_value = ($value == (int) $value) ? (int) $value : (float) $value;
  } else{
    $validated_value = $value;
  }

  if ( $result['is_valid'] && !is_int($validated_value) ) {
    $result['is_valid'] = false;
    $result['message'] = 'Only whole numbers between 20 to 70 years (inclusive) are allowed';
  } else if ($result['is_valid'] && (20 > $validated_value || $validated_value > 70) ){
    $result['is_valid'] = false;
    $result['message'] = 'Only whole numbers between 20 to 70 years (inclusive) are allowed';
  }

  return $result;
}

// Adds custom link to the Account subscription page to manage sub accounts when there's an 
// associated corporate account record but ONLY showing the corporate parent account
function my_mepr_account_subscriptions_actions_func($user, $row, $transaction, $issub) {
  $show_membership_users = 'no';
  $obj_type = ($issub ? 'subscriptions' : 'transactions');
  $prd = ($obj_type === 'transactions') ? $transaction->product(): '';
  $ca = MPCA_Corporate_Account::find_corporate_account_by_obj_id($row->id, $obj_type);

  // Added manually using advanced custom fields inside memberpress membership page
  if ( !empty($prd) && !empty($prd->ID) ) {
    $show_membership_users = get_post_meta( $prd->ID, 'show_membership_users', true );
  }

  $ca_parent = get_ca_parent();
  $my_ca = ( isset($ca_parent) && $ca_parent !== '' )? $ca_parent : $ca;

  // echo "<br>ca:". $ca;
  // echo "<br>ca_parent: ".$ca_parent;
  /* echo "<br>obj_type: "; echo $obj_type;
  echo "<br>prd->ID: ".$prd->ID;
  echo "<br>show_membership_users: "; print_r($show_membership_users); */

  if( !empty($my_ca) && isset($my_ca->id) && !empty($my_ca->id) && $my_ca->is_enabled()
     && !empty($show_membership_users) && $show_membership_users === 'yes' ) {
    ?>
    <a href="<?php echo $my_ca->sub_account_management_url(); ?>" class="mepr-account-row-action mepr-account-manage-sub-accounts"><?php _e('Display Users', 'memberpress-corporate'); ?></a>
    <?php
  }
}

// We need to determine which corporate account should be displayed for manage accounts page 
// ONLY 1 corporate parent account is allowed per membership
function get_ca_parent () { 
  global $wpdb;

  // fetch logged in user info
  $user = MeprUtils::get_currentuserinfo();

  // Added by member press corporate add-on (for all none parent accounts)
  $mpca_corporate_account_id = get_user_meta($user->ID, 'mpca_corporate_account_id', true);

  // Added manually user_meta field using advanced custom fields plugin
  $ca_parent_user_id = get_user_meta($user->ID, 'corporate_parent_account_user_id', true);
  
  if( $mpca_corporate_account_id > 0 && $ca_parent_user_id > 0 ) {
    $sql  = "SELECT * FROM `wp_mepr_corporate_accounts` WHERE `user_id`=".$ca_parent_user_id;
    $sql .= " AND `id`=".$mpca_corporate_account_id. " AND `status`='enabled'";

    $parent_ca_res = $wpdb->get_results( $sql );
    $ca_parent_uuid = $parent_ca_res[0]->uuid;
    $ca_parent = MPCA_Corporate_Account::find_by_uuid($ca_parent_uuid);
  
    // use the parent account instead to allow other corporate member accounts to upload 
    // new users to the same membership plan using the ONLY 1 parent corporate account user_id
    return $ca_parent;
  }

  // no corporate account parent found OR user is logged in with corporate parent account
  return '';
}

// show organization report link header inside management page 
add_action('mepr-account-subscriptions-th', 'show_organization_report_header', 10, 2);
function show_organization_report_header($user, $subscriptions) { ?>
  <th>ORGANIZATION REPORT</th>
<?php
}

// show organization report link cell inside management page 
add_action('mepr-account-subscriptions-td', 'show_organization_report_cell', 10, 4);
function show_organization_report_cell($user, $row, $transaction, $issub) {
  $ca_parent = get_ca_parent();
  $show_organization_report = 'no';
  $obj_type = ($issub ? 'subscriptions' : 'transactions');
  $prd = ($obj_type === 'transactions') ? $transaction->product(): '';

  // Added manually using advanced custom fields inside memberpress membership page
  if ( !empty($prd) && !empty($prd->ID) ) {
    $show_organization_report = get_post_meta( $prd->ID, 'show_organization_report', true );
  }

  // echo "<br>ca_parent cell: ".$ca_parent;
  /* echo "<br>obj_type: "; echo $obj_type;
  echo "<br>prd->ID: ".$prd->ID;
  echo "<br>show_organization_report: "; print_r($show_organization_report); */
  
  // Link should match organization report back end page permalink consisting of:  
  // /organization-report-{corporate_parent_account_user_id} for: $ca_parent->user_id NOT $ca->user_id
  // AND matching gravity form back end field: corporate_parent_account_user_id 
  if( !empty($ca_parent) && isset($ca_parent->id) && !empty($ca_parent->id) && $ca_parent->is_enabled()
      && !empty($show_organization_report) && $show_organization_report === 'yes' ) {
    ?>
    <td><a href="/organization-report-<?php echo $ca_parent->user_id; ?>">Display Report</a></td>
    <?php
  }
}

// Show organization report hook
add_action( 'astra_entry_content_after', 'astra_entry_content_after_organization_report');
function astra_entry_content_after_organization_report () {
  echo do_shortcode("[organizationreport]");
}

// Setup short code on organization report back end page. Should only be shown on frontend
add_shortcode('organizationreport', 'show_organization_report'); 
function show_organization_report($atts){
  if( isset($atts['gformid']) && !is_admin() ){
    $resiliencyBehavioursAverageScore = calculateOrganizationAverageScore ('total_resiliency_behaviours_score', $atts['gformid']);
    $supportProgramsAverageScore = calculateOrganizationAverageScore ('total_support_programs_score', $atts['gformid']);
    $supportiveLeadershipAverageScore = calculateOrganizationAverageScore ('total_supportive_leadership_score', $atts['gformid']);
    $supportiveEnvironmentAverageScore = calculateOrganizationAverageScore ('total_supportive_environment_score', $atts['gformid']);

    $osirAverageGrandScore = ( $resiliencyBehavioursAverageScore + $supportProgramsAverageScore + 
      $supportiveLeadershipAverageScore + $supportiveEnvironmentAverageScore ) / 4;
    
    // print_r($atts);
   /*  echo "<br><br>resiliencyBehavioursAverageScore: ".$resiliencyBehavioursAverageScore;
    echo "<br><br>supportProgramsAverageScore: ".$supportProgramsAverageScore;
    echo "<br><br>supportiveLeadershipAverageScore: ".$supportiveLeadershipAverageScore;
    echo "<br><br>supportiveEnvironmentAverageScore: ".$supportiveEnvironmentAverageScore;
    echo "<br><br>osirAverageGrandScore: ".$osirAverageGrandScore; */

    echo getOrganizationGenericMsg();
	  echo getOrganizationScalesMsg($osirAverageGrandScore, $resiliencyBehavioursAverageScore, 
      $supportProgramsAverageScore, $supportiveLeadershipAverageScore, $supportiveEnvironmentAverageScore);
  }
}

//--------------------------------------------------------------------------------------

/* 
add_shortcode('memberonly', 'member_only_shortcode'); 
function member_only_shortcode($atts){
  if ( !is_user_logged_in() ) {
    return '<h4>PLEASE LOGIN TO YOUR ACCOUNT</h4>';
  }
}
*/

/*
add_filter('mepr-admin-capability', 'mepr_admin_capability');  
function mepr_admin_capability($cap) {
  return $cap;
}
*/

// https://docs.gravityforms.com/gform_field_validation/
// https://ristrettoapps.com/downloads/gravity-press/
// https://members-plugin.com/docs/snippets/
