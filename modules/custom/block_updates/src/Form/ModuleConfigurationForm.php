<?php
/**
 * @file
 * Contains Drupal\block_updates\Form\ModuleConfigurationForm.
 */

namespace Drupal\block_updates\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;

/**
 * Class SettingsForm.
 *
 * @package Drupal\block_updates\Form
 */
class ModuleConfigurationForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'block_updates.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('block_updates.settings');

    $form['config_fieldset'] = [
      '#type'  => 'details',
      '#title' => t('Block Updates Configurations'),
      '#open'  => TRUE,
    ];

    $form['config_fieldset']['stock_api_url'] = [
      '#type'          => 'textfield',
      '#title'         => $this->t('Type the URL of the Stock API'),
      '#default_value' => ($config->get('stock_api_url') !== NULL) ? $config->get('stock_api_url') : '',
      '#description'   => t('original:') . ' http://dev.markitondemand.com/MODApis/Api/v2/Quote/json?symbol=AAPL',
      '#required'      => TRUE
    ];

    $options = [
      'field_last_price' => t('Last Price'),
      'field_change' => t('Change'),
    ];

    $form['config_fieldset']['fields_to_update'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Fields to Update'),
      '#title_display' => 'before', // before, after and invisible
      '#options' => $options,
      '#default_value' => ($config->get('fields_to_update') !== NULL) ? $config->get('fields_to_update') : [],
    ];

    $form['reset_fieldset'] = [
      '#type'  => 'details',
      '#title' => t('Reset Block Updates Fields'),
      '#open'  => FALSE,
    ];

    $form['reset_fieldset']['reset'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Reset'),
      '#default_value' => 0,
      '#description'   => t('Set empty values to Last Price and Change fields.'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);

    $reset = $form_state->getValue('reset');
    if ($reset) {
      $blocks = \Drupal::entityTypemanager()
        ->getStorage('block_content')
        ->loadByProperties(['type' => 'stock_exchange_rate_card']);

      // ensure that block type 'stock_exchange_rate_card' exists and has blocks
      if (is_array($blocks) && sizeof($blocks) > 0) {
        foreach ($blocks as $block_id => $block) {
          $block->set('field_last_price', '');
          $block->set('field_change', '');
          $block->save();
        }
      }
    }

    // for save form configurations
    $this->config('block_updates.settings')
      ->set('stock_api_url', $form_state->getValue('stock_api_url'))
      ->save();

    $this->config('block_updates.settings')
      ->set('fields_to_update', $form_state->getValue('fields_to_update'))
      ->save();
  }

}



