<?php
/**
 * Implements hook_form_system_theme_settings_alter() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function mox_form_system_theme_settings_alter(&$form, &$form_state) {
  // Development
  $form['development'] = array(
    '#type'        => 'fieldset',
    '#title'       => t('Development'),
    '#description' => t('These settings are meant for use during development of themes. Remember to turn these off before deployment!'),
    '#collapsible' => TRUE,
    '#collapsed'   => FALSE,
  );
  $form['development']['mox_rebuild_registry'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Rebuild theme registry'),
    '#description'   => t('Automatically rebuild the theme registry during theme development (will affect performance greatly).'),
    '#default_value' => theme_get_setting('mox_rebuild_registry'),
  );
  $form['development']['mox_debug'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Enable debug mode'),
    '#description'   => t('Will enable debug grid and other helpers during development.'),
    '#default_value' => theme_get_setting('mox_debug'),
  );
  
  $image_path = variable_get('mox_image_path');  

  // Remove stream wrappers if path URI scheme is "public".
  if (file_uri_scheme($image_path) == 'public') {
    $image_path = file_uri_target($image_path);
    $image_path_relative = file_create_url(file_build_uri($image_path));
  }
  
  $form['development']['mox_image'] = array(
    '#type' => 'file',
    '#title' => t('Upload background image'),
    '#maxlength' => 40,
    '#description' => t("Upload an image for various nefarious purposes.")
  );
  
  if (!empty($image_path_relative)) {
    $form['development']['mox_image_relative_path'] = array(
      '#type' => 'textfield',
      '#title' => t('Path to custom background image'),
      '#default_value' => $image_path_relative,
      '#description' => t('The path to the uploaded file.'),
    );
    $form['development']['mox_image_preview'] = array(
      '#type' => 'markup',
      '#markup' => !empty($image_path_relative) ? theme('image', array('path' => $image_path_relative, 'width' => '450', 'height' => '', 'alt' => t('Header image'), 'title' => t('Header image'))) : '',
    );
  }
  
  $form['#validate'][] = 'mox_system_theme_settings_validate';  
  $form['#submit'][] = 'mox_system_theme_settings_submit';  
}

/**
 * Validate settings form.
 */
function mox_system_theme_settings_validate($form, &$form_state) {
  $file = file_save_upload('mox_image', array(
    'file_validate_is_image' => array(), // Validates file is really an image. 
    'file_validate_extensions' => array('png gif jpg jpeg'), // Validate extensions.
  ));
  
  if (isset($file)) {
    // File upload was attempted.
    if ($file) {
      // Save the temporary file in form_values.
      $form_state['values']['mox_image'] = $file;
    }
    else {
      // File upload failed.
      form_set_error('mox_image', t('Image upload failed.'));
    }
  }
}

/**
 * Submit handler.
 */
function mox_system_theme_settings_submit($form, &$form_state) {
  $values = $form_state['values'];
  
  // If the user uploaded a new logo or favicon, save it to a permanent location
  // and use it in place of the default theme-provided file.
  if ($file = $values['mox_image']) {
    unset($values['mox_image']);
    $filename = file_unmanaged_copy($file->uri);
    $values['mox_image_path'] = $filename;
    
    if (!empty($values['mox_image_path'])) {
      $values['mox_image_path'] = _system_theme_settings_validate_path($values['mox_image_path']);
    }
    
    variable_set('mox_image_path', $filename);
    
    // Set a response to the user.
    drupal_set_message(t('The image has been saved, filename: @filename.', array('@filename' => $file->filename)));
  }
}
