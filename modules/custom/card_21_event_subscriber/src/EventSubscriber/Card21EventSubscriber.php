<?php

/**
 * @file
 * Contains \Drupal\card_21_event_subscriber\EventSubscriber\MyEventSubscriber.
 */

namespace Drupal\card_21_event_subscriber\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Component\Utility\Unicode;

class Card21EventSubscriber implements EventSubscriberInterface {

  /**
   * Code that should be triggered on event specified.
   * Adds CORS headers to the response.
   *
   * @param \Symfony\Component\HttpKernel\Event\FilterResponseEvent $event
   *   The GET response event.
   */
  public function addAccessAllowOriginHeaders(FilterResponseEvent $event) {
    if (\Drupal::currentUser()->isAnonymous()) {
      $response= $event->getResponse();
      $response->headers->set('Access-Control-Allow-Origin', '*');
      \Drupal::logger('card_21_event_subscriber')->notice('from anonymous user');
    }
  }

  /**
  * {@inheritdoc}
  */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = ['addAccessAllowOriginHeaders'];
    return $events;
  }
}
