<?php

/**
 * Implements hook_form_system_theme_settings_alter() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function mox_form_system_theme_settings_alter(&$form, $form_state) {
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
}
