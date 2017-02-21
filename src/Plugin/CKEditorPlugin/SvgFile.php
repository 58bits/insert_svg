<?php

/**
 * @file
 * Contains \Drupal\insert_svg\Plugin\CKEditorPlugin\SvgFile.
 */

namespace Drupal\insert_svg\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\ckeditor\CKEditorPluginConfigurableInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "svgfile" plugin.
 *
 * @CKEditorPlugin(
 *   id = "svgfile",
 *   label = @Translation("Insert SVG"),
 *   module = "ckeditor"
 * )
 */
class SvgFile extends CKEditorPluginBase implements CKEditorPluginConfigurableInterface {

  /**
   * {@inheritdoc}
   */
  public function getFile() {
    return drupal_get_path('module', 'insert_svg') . '/js/plugins/svgfile/plugin.js';
  }

  /**
   * {@inheritdoc}
   */
  public function getLibraries(Editor $editor) {
    return array(
      'core/drupal.ajax',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getConfig(Editor $editor) {
    return array(
      'svgFile_dialogTitleAdd' => t('Add SVG File'),
      'svgFile_dialogTitleEdit' => t('Edit SVG File'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    $path = drupal_get_path('module', 'insert_svg') . '/js/plugins/svgfile';
    return array(
      'SvgFile' => array(
        'label' => t('File'),
        'image' => $path . '/file.png',
      ),
    );
  }

  /**
   * {@inheritdoc}
   *
   * @see \Drupal\editor\Form\InsertSvgDialog
   * @see insert_svg_upload_settings_form()
   */
  public function settingsForm(array $form, FormStateInterface $form_state, Editor $editor) {
    $form_state->loadInclude('insert_svg', 'admin.inc');
    $form['file_upload'] = insert_svg_upload_settings_form($editor);
    $form['file_upload']['#attached']['library'][] = 'insert_svg/drupal.ckeditor.svgfile.admin';
    $form['file_upload']['#element_validate'][] = array($this, 'validateFileUploadSettings');
    return $form;
  }

  /**
   * #element_validate handler for the "file_upload" element in settingsForm().
   *
   * Moves the text editor's file upload settings from the SvgFile plugin's
   * own settings into $editor->file_upload.
   *
   * @see \Drupal\editor\Form\InsertSvgDialog
   * @see insert_svg_upload_settings_form()
   */
  function validateFileUploadSettings(array $element, FormStateInterface $form_state) {
    $settings = &$form_state->getValue(array('editor', 'settings', 'plugins', 'svgfile', 'file_upload'));
    $editor = $form_state->get('editor');
    foreach ($settings as $key => $value) {
      if (!empty($value)) {
        $editor->setThirdPartySetting('insert_svg', $key, $value);
      }
      else {
        $editor->unsetThirdPartySetting('insert_svg', $key);
      }
    }
    $form_state->unsetValue(array('editor', 'settings', 'plugins', 'svgfile'));
  }

}
