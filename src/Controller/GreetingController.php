<?php

namespace Drupal\greeting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\greeting\GreetingTracker;
use Symfony\Component\DependencyInjection\ContainerInterface;

class GreetingController extends ControllerBase {
  protected $greetingTracker;

  public function __construct(GreetingTracker $tracker) {
    $this->greetingTracker = $tracker;
  }

  public static function create(ContainerInterface $container) {
    return new static($container->get('greeting.greeting_tracker'));
  }

  public function greeting($to, $from, $count) {
    $this->greetingTracker->addGreeting($to);
    return [
      '#theme' => 'greeting_page',
      '#from' => $from,
      '#to' => $to,
      '#count' => $count ?: $this->config('greeting.settings')->get('default_count'),
    ];
  }
}
