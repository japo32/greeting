<?php

namespace Drupal\greeting\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Component\Utility\SafeMarkup;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Reports on greetability status
 *
 * @Block(
 *   id = "greeting_status",
 *   admin_label = @Translation("Greeting Status"),
 *   category = @Translation("System")
 * )
 */
class GreetingStatus extends BlockBase implements ContainerFactoryPluginInterface {
  protected $greetingTracker;

  /**
   * {@inheritdoc}
   */

  public function __construct(array $configuration, $plugin_id, $plugin_definition, GreetingTracker $greetingTracker) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->greetingTracker = $greetingTracker;
  }

  /**
   * {@inheritdoc}
   */

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration, $plugin_id, $plugin_definition,
      $container->get('greeting.greeting_tracker')
    );
  }

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
    $form['enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Greetings enabled'),
      '#default_value' => $this->configuration['enabled'],
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['greeting'] = t('@greeting', array('@greeting' => $form_state->getValue('greeting')));
    $this->configuration['enabled'] = (bool)$form_state->getValue('enabled');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return array(
      '#theme' => 'greeting_status_block',
      '#enabled' => (bool)$this->configuration['enabled'],
      '#to' => $this->greetingTracker->getLastRecipient(),
      '#greeting' => $this->configuration['greeting']
    );
  }
}
