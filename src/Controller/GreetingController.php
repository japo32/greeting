<?php

namespace Drupal\greeting\Controller;

use Drupal\Core\Controller\ControllerBase;

class GreetingController extends ControllerBase {

  public function greeting($to, $from) {
    $message = $this->t('%from sends a greeting to %to', [
      '%from' => $from,
      '%to' => $to,
    ]);

    return ['#markup' => $message];
  }

  public function test() {
    return array(
      '#markup' => t('Hello World!'),
    );
  }
}
