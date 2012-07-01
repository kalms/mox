<?php
/**
 * Override or insert variables into the html template.
 */
function mox_preprocess_html(&$vars) {
  global $language;
  
  $page_title = drupal_get_title();
  
  // Check if current page is frontpage
  if ($vars['is_front'] || empty($page_title)) {
    $vars['head_title'] = variable_get('site_name'); 
  } else {
    // Serve proper content title if is_front is false
    $vars['head_title'] = implode(' | ', array($page_title, variable_get('site_name', '')));
  }
  
  // Clean up the lang attributes
  $vars['html_attributes'] = 'lang="' . $language->language . '" dir="' . $language->dir . '"';
}

/**
 * theme_html_header_alter()
 *
 * Remove the generator meta tag for security reasons.
 */
function mox_html_head_alter(&$head_elements) {
  $head_elements['system_meta_content_type']['#attributes'] = array(
    'charset' => 'utf-8',
  );
  
  unset($head_elements['system_meta_generator']);
}

/**
 * Implementation of theme_preprocess_page().
 */
function mox_preprocess_page(&$vars) {
  // Check if panels is present and serve different template if true.
  if (function_exists('panels_get_current_page_display')) {
    if (panels_get_current_page_display() && empty($_GET['popup'])) {
      $vars['theme_hook_suggestions'][] = 'page__panel';
    }
  }
  
  $background_image = theme_get_setting('mox_image');
  
  // Assign header image.
  $vars['background_image'] = theme('image', array('path' => $background_image->uri, 'width' => '', 'height' => ''));
}
