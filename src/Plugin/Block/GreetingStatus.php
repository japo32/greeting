<?php

namespace Drupal\greeting\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

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
    $form['enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Greeting enabled'),
      '#default_value' => $this->configuration['enabled'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] =  $form_state->getValue('enabled');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $message = $this->configuration['enabled']
      ? $this->t('Now accepting greetings')
      : $this->t('No greetings :-(');

    return ['#markup' => $message];
  }
}
