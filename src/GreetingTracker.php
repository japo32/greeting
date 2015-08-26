<?php

namespace Drupal\greeting;

use Drupal\Core\State\StateInterface;

class GreetingTracker {
  protected $state;

  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  public function addGreeting($target_name) {
    $this->state->set('greeting.last_recipient', $target_name);
    return $this;
  }

  public function getLastRecipient() {
    return $this->state->get('greeting.last_recipient');
  }
}
