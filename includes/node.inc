<?php
/**
 * @file node.inc
 *
 * Implementation of theme_preprocess_node().
 */
function mox_preprocess_node(&$vars) {
 // Format std. node date to your own liking
 $vars['date'] = format_date($vars['created'], 'custom', 'd. M Y');

 // Switch example
 switch ($vars['type']) {
   case 'blog':
     //       
     $vars['submitted'] = t('by !username', array('!username' => $vars['name']));

     break;
 }
}

function phptemplate_node_admin_nodes($form) {
  dpm($form);
}
