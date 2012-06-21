<?php
/**
 * @file node.inc
 *
 * Implementation of theme_preprocess_node().
 */
function mox_preprocess_node(&$vars) {
  if ($vars['display_submitted']) {
    $vars['submitted'] = t('Submitted by !username on !datetime', array(
      '!username' => $vars['name'],
      '!datetime' => $vars['date'],
    ));
  }
}
