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

      $message = $this->t('Everyone greet @name because @reasons!', [
        '@name' => $node->getOwner()->label(), '@reasons' => implode(', ', $terms),
      ]);
      return [
        '#title' => $node->label() . ' (' . $node->bundle() . ')',
        '#markup' => $message . $formatted,
      ];
    }
    return ['#markup' => $this->t('Not published')];
  }
}
