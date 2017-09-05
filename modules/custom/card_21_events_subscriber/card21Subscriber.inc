<?php
namespace Drupal\mymodule\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Component\Utility\Unicode;

class card21Subscriber implements EventSubscriberInterface {

  public function addAccessAllowOriginHeaders(FilterResponseEvent $event) {
    $response= $event->getResponse();
    $response->headers->set('Access-Control-Allow-Origin', '*');
  }

  /**
  * {@inheritdoc}
  */
  static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('addAccessAllowOriginHeaders');
    return $events;
  }
}
