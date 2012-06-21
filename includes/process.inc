<?php

/**
 * Implementation of preprocess_fieldset().
 */
function mox_preprocess_fieldset(&$vars) {
  $element = $vars['element'];
  
  _form_set_class($element, array('form-wrapper'));
  
  $vars['attributes'] = isset($element['#attributes']) ? $element['#attributes'] : array();
  $vars['attributes']['class'][] = 'fieldset';
  
  if (!empty($element['#title'])) {
    $vars['attributes']['class'][] = 'titled';
  }
  if (!empty($element['#id'])) {
    $vars['attributes']['id'] = $element['#id'];
  }

  $description = !empty($element['#description']) ? "<div class='description'>{$element['#description']}</div>" : '';
  $children = !empty($element['#children']) ? $element['#children'] : '';
  $value = !empty($element['#value']) ? $element['#value'] : '';
  $vars['content'] = $description . $children . $value;
  $vars['title'] = !empty($element['#title']) ? $element['#title'] : '';
}
