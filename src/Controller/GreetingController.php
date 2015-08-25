<?php

namespace Drupal\greeting\Controller;

use Drupal\Core\Controller\ControllerBase;

class GreetingController extends ControllerBase {

  public function greeting($to, $from, $count) {
    if (!$count) {
      $count = $this->config('greeting.settings')->get('default_count');
    }
    return [
      '#theme' => 'greeting_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count,
    ];
  }
}
