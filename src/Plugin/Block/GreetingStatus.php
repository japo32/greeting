<?php

namespace Drupal\greeting\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
  public function build() {
    return array('#markup' => t('This is a basic block.'));
  }
}
