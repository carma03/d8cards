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

    $form['reset'] = [
      '#type'          => 'checkbox',
      '#title'         => $this->t('Reset Stock Exchange Rate Card Block'),
      '#default_value' => 0,
      //'#default_value' => ($config->get('reset') !== NULL) ? $config->get('reset') : 0,
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
    /*
    $this->config('block_updates.settings')
      ->set('reset', $form_state->getValue('reset'))
      ->save();
    */
  }

}



