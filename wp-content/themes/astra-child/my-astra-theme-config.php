<?php

//----------------------------------------------------------------------------------------
// Astra theme custom configuration

// Astra theme hooks
// http://developers.wpastra.com/theme-visual-hooks/

// Corporate Parent Moderator User ID
$my_gform_id = (isset($_GET['my_gform_id']) && $_GET['my_gform_id'] > 0) ? $_GET['my_gform_id'] : 0;
// echo "<br><br>my_gform_id: ".$my_gform_id;

// Disable next/previous navigation links for membership pages
add_filter( 'astra_single_post_navigation_enabled', '__return_false' );

// https://developer.wordpress.org/reference/functions/wp_is_mobile/
function my_custom_redirects_func() {
  // my_gform_id = 10, corporate_parent_account_moderator_id = 3 
  if ( is_user_logged_in() && wp_is_mobile() && is_page('osir-survey-analytics-3') ) {
    // Redirect users to the mobile page version of the survey analytics
    wp_safe_redirect( '/osir-survey-analytics-3-m/' );
    exit;
  }

  // my_gform_id = 17, corporate_parent_account_moderator_id = 9
  if ( is_user_logged_in() && wp_is_mobile() && is_page('osir-survey-analytics-9') ) {
    // Redirect users to the mobile page version of the survey analytics
    wp_safe_redirect( '/osir-survey-analytics-9-m/' );
    exit;
  }
}
add_action( 'template_redirect', 'my_custom_redirects_func' );
