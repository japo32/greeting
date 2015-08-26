<?php

namespace Drupal\greeting\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\greeting\GreetingTracker;
use \Drupal\node\NodeInterface;
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

  public function nodeGreeting(NodeInterface $node) {
    if ($node->isPublished()) {
      $formatted = $node->body->processed;

      foreach ($node->field_tags as $tag) {
        $terms[] = $tag->entity->label();
      }

      return [
        '#theme' => 'greeting_node',
        '#title' => $node->label() . ' (' . $node->bundle() . ')',
        '#body' => $formatted,
        '#name' => $node->getOwner()->label(),
        '#terms' => $terms
      ];
    }
    return ['#markup' => $this->t('Not published')];
  }
}
