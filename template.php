<?php
/**
 * Auto-rebuild the theme registry during theme development.
 */
if (theme_get_setting('mox_rebuild_registry')) {
  // Rebuild .info data.
  system_rebuild_theme_data();
  // Rebuild theme registry.
  drupal_theme_rebuild();
}

/**
 * Load relevant debug files if enabled.
 */
if (theme_get_setting('mox_debug')) {
  drupal_add_js(drupal_get_path('theme', 'mox') .'/scripts/debug/debug.js');
  drupal_add_css(drupal_get_path('theme', 'mox') .'/scripts/debug/debug.css');
}

/**
 * Include files from current theme and all base themes.
 */
global $theme_info, $base_theme_info;

foreach (array_merge($base_theme_info, array($theme_info)) as $theme) {
  if (is_dir($path = drupal_get_path('theme', $theme->name) .'/includes') && $handle = opendir($path)) {
    while (($file = readdir($handle)) !== FALSE) {
      if (preg_match('/^[a-z0-9_\-]+\.inc$/', $file)) {
        include_once $path .'/'. $file;
      }
    }
    closedir($handle);
  }
}
