<?php
/*
Plugin Name: Google Tag Manager ID Display
Description:Displays the Google Tag Manager ID on the frontend
Version: 1.4
Author: Groq llama3 © Stars Media IT GmbH
Author URI: https://www.starsmedia.com/
*/

// Add a settings page to the WordPress admin dashboard
function gtmdi_display_settings_page() {
  add_menu_page('Google Tag Manager ID Display', 'Google Tag Manager ID', 'manage_options', 'gtmdi-display', 'gtmdi_display_settings_form');
}
add_action('admin_menu', 'gtmdi_display_settings_page');

// Settings form function
function gtmdi_display_settings_form() {
  ?>
  <div class="wrap">
    <h1>Google Tag Manager ID Display</h1>
    <form action="options.php" method="post">
      <?php
      // Retrieve the current settings from the database
      $gtmdi_id = get_option('gtmdi_id');
      ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Google Tag Manager ID</th>
          <td>
            <input type="text" name="gtmdi_id" value="<?php echo esc_attr($gtmdi_id); ?>">
          </td>
        </tr>
        <tr valign="top">
          <th scope="row"></th>
          <td>
            <input type="submit" name="gtmdi_submit" value="Save Changes">
          </td>
        </tr>
      </table>
    </form>
  </div>
  <?php
}

// Save the settings when the form is submitted
function gtmdi_display_save_settings() {
  // Check if the form has been submitted
  if (isset($_POST['gtmdi_submit'])) {
    // Update the settings in the database
    update_option('gtmdi_id', $_POST['gtmdi_id']);
  }
}
add_action('admin_init', 'gtmdi_display_save_settings');

// Display the Google Tag Manager ID in the frontend
function gtmdi_display_tagmanager_id() {
  // Retrieve the current settings from the database
  $gtmdi_id = get_option('gtmdi_id');
  // Check if the ID has been set
  if (!empty($gtmdi_id)) {
    // Display the ID in the head section of the page
    ?>
    <head>
      <!-- Google Tag Manager -->
      <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
      new Date().getTime(),event:"gtm.js"});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id=' . esc_attr($gtmdi_id) . dl;f.parentNode.insertBefore(j,f);
      })(window,document,"script","dataLayer","<?= esc_attr($gtmdi_id); ?>");</script>
      <!-- End Google Tag Manager -->
    </head>

    // Display the noscript tag immediately after the opening <body> tag
    <body>
      <!-- Google Tag Manager (noscript) -->
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= esc_attr($gtmdi_id); ?>" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
    </body>
    <?php
  }
}
add_action('wp_footer', 'gtmdi_display_tagmanager_id');