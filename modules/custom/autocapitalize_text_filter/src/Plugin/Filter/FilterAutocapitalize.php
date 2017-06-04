<?php

namespace Drupal\autocapitalize_text_filter\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * @Filter(
 *   id = "filter_autocapitalize",
 *   title = @Translation("Autocapitalize Filter"),
 *   description = @Translation("Auto­capitalizes pre­configured words anywhere they occur in the filtered text"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class FilterAutocapitalize extends FilterBase {
  public function process($text, $langcode) {
    if (isset($this->settings['autocapitalize_config'])) {
      $autocapitalize_config_words = $this->settings['autocapitalize_config'];
    }else {
      $autocapitalize_config_words =  '';
    }

    $autocapitalize_config_words = explode(',', $autocapitalize_config_words);

    $new_text = $text;

    if (is_array($autocapitalize_config_words) && (count($autocapitalize_config_words) > 0)) {
      foreach ($autocapitalize_config_words as $value) {
        $neddle = $value;
        if (strpos($text, $neddle) !== false) {
          $value = ucfirst($value);
          $new_text = str_replace($neddle, $value, $new_text);
        }
      }
    }

    return new FilterProcessResult($new_text);
  }

  /**
   * Override the settingsForm method
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['autocapitalize_config'] = array(
      '#type' => 'textarea',
      '#title' => $this->t('Words to Autocapitalize'),
      '#default_value' => $this->settings['autocapitalize_config'],
      '#description' => $this->t('Enter list of words in small case, which should be capitalized.') . '<br>' . t('Separate multiple words with comma') . '(,)',
    );

    return $form;
  }
}

