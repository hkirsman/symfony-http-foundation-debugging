<?php

namespace Drupal\symfony_http_foundation_debugging\EventSubscriber;

use Drupal\Core\Language\LanguageManager;
use Drupal\Core\Path\CurrentPathStack;
use Drupal\Core\Path\PathValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * HelpViewer links validation and redirecting.
 */
class ProductGuidesRequestSubscriber implements EventSubscriberInterface {

  /**
   * The current path.
   *
   * @var \Drupal\Core\Path\CurrentPathStack
   */
  protected $currentPath;

  /**
   * The path validator.
   *
   * @var \Drupal\Core\Path\PathValidatorInterface
   */
  protected $pathValidator;

  /**
   * The current language.
   *
   * @var \Drupal\Core\Language\LanguageManager
   */
  protected $currentLang;

  /**
   * Constructs a new ProductGuidesRequestSubscriber.
   *
   * @param \Drupal\Core\Path\CurrentPathStack $current_path
   *   The current path.
   * @param \Drupal\Core\Path\PathValidatorInterface $path_validator
   *   The path validator.
   * @param \Drupal\Core\Language\LanguageManager $current_lang
   *   The current language.
   */
  public function __construct(CurrentPathStack $current_path, PathValidatorInterface $path_validator, LanguageManager $current_lang) {
    $this->currentPath = $current_path;
    $this->pathValidator = $path_validator;
    $this->currentLang = $current_lang;
  }

  /**
   * HelpViewer links validation and redirecting.
   *
   * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
   *   The event to process.
   */
  public function redirectHelpViewer(RequestEvent $event) {
    // Check current path.
    $current_path = $this->currentPath->getPath();

    // Return if URL is valid and no redirection needed.
    if ($this->pathValidator->isValid($current_path)) {
      return;
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events[KernelEvents::REQUEST][] = ['redirectHelpViewer', 33];
    return $events;
  }

}
