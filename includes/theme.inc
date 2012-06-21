<?php
/**
 * @file theme.inc
 *
 * @see includes/theme.inc
 *      - for more examples on how to override theme functions.
 */

/**
 * Implementation of hook_theme().
 */ 
function mox_theme(&$vars) {
  $items = array();

  $items['node'] = array(
    'arguments' => array('node' => NULL, 'teaser' => FALSE, 'page' => FALSE),
    'template' => 'node',
    'path' => drupal_get_path('theme', 'mox') .'/templates/nodes',
  );
  $items['fieldset'] = array(
    'arguments' => array('element' => array()),
    'template' => 'fieldset',
    'path' => drupal_get_path('theme', 'mox') .'/templates/base',
  );
  // Split out pager list into separate theme function.
  $items['pager_list'] = array('arguments' => array(
    'tags' => array(),
    'limit' => 10,
    'element' => 0,
    'parameters' => array(),
    'quantity' => 9,
  ));
  
  return $items;
}
