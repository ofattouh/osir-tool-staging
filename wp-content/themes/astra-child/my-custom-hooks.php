<?php

//----------------------------------------------------------------------------------------
// Member Press & gravity form custom hooks

// https://ristrettoapps.com/downloads/gravity-press/
// https://members-plugin.com/docs/snippets/


// Adds custom link to the Account subscription page to manage sub accounts when there's an 
// associated corporate account record but ONLY showing the corporate parent account
function my_mepr_account_subscriptions_actions_func($user, $row, $transaction, $issub) {
  $obj_type = ($issub ? 'subscriptions' : 'transactions');
  $ca = MPCA_Corporate_Account::find_corporate_account_by_obj_id($row->id, $obj_type);

  $ca_parent = get_ca_parent();
  $my_ca = ( isset($ca_parent) && $ca_parent !== '' )? $ca_parent : $ca;

  // echo "<br><br>ca<br>";
  // print_r($ca);
  // echo "<br><br>my_ca<br>";
  // print_r($my_ca);

  if(!empty($my_ca) && isset($my_ca->id) && !empty($my_ca->id) && $my_ca->is_enabled()) {
    ?>
    <a href="<?php echo $my_ca->sub_account_management_url(); ?>" class="mepr-account-row-action mepr-account-manage-sub-accounts"><?php _e('Sub Accounts', 'memberpress-corporate'); ?></a>
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

    // $ca_parent = "28cae006dd7c93520ef15a24c089dd76";
    // echo $sql;
    // print_r($parent_ca_res);
    // $is_existing_user = MeprUtils::is_user_logged_in();
    // $subscriptions = $usr->subscriptions();

    // use the parent account instead to allow other corporate member accounts to upload 
    // new users to the same membership plan using the ONLY 1 parent corporate account user_id
    return $ca_parent;
  }

  // no corporate account parent found OR user is logged in with corporate parent account
  return '';
}

//--------------------------------------------------------------------------------------

// check if user is logged in
/* function member_only_shortcode_func($atts){
  if ( !is_user_logged_in() ) {
    return '<h4>PLEASE LOGIN TO YOUR ACCOUNT</h4>';
  }
}
add_shortcode('memberonly', 'member_only_shortcode_func'); */

/* function mepr_admin_capability($cap) {
  return $cap;
}
add_filter('mepr-admin-capability', 'mepr_admin_capability'); */
