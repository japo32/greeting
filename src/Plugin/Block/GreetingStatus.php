<?php

namespace Drupal\greeting\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\SafeMarkup;

/**
 * Reports on greetability status
 *
 * @Block(
 *   id = "greeting_status",
 *   admin_label = @Translation("Greeting Status"),
 *   category = @Translation("System")
 * )
 */
class GreetingStatus extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return array('enabled' => 1);
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['greeting'] = array(
      '#type' => 'textfield',
      '#title' => t('Greeting text'),
      '#default_value' => $this->configuration['greeting'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['greeting'] =  t($form_state->getValue('greeting'));
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return ['#markup' => SafeMarkup::checkPlain($this->configuration['greeting'])];
  }
}
