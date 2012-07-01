<?php
/**
 * @file
 * Enable cross-browser friendly styling of legends.
 *
 * @see mox_preprocess_fieldset()
 */
?>
<fieldset <?php if (!empty($attributes)) print drupal_attributes($attributes) ?>>
  <?php if (!empty($title)): ?>
    <legend><span class="fieldset-title fieldset-legend"><?php print $title; ?></span></legend>
  <?php endif; ?>
  <?php if (!empty($content)): ?>
    <div class="fieldset-content fieldset-wrapper clearfix"><?php print $content; ?></div>
  <?php endif; ?>
</fieldset>
