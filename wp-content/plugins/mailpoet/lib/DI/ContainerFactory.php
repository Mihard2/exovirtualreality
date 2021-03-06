<?php

namespace MailPoet\DI;

if (!defined('ABSPATH')) exit;


use MailPoetVendor\Symfony\Component\DependencyInjection\Container;
use MailPoetVendor\Symfony\Component\DependencyInjection\ContainerBuilder;

class ContainerFactory {

  /** @var IContainerConfigurator */
  private $configurator;

  /** @var bool */
  private $debug;

  /**
   * ContainerFactory constructor.
   * @param bool $debug
   */
  public function __construct(IContainerConfigurator $configurator, $debug = false) {
    $this->debug = $debug;
    $this->configurator = $configurator;
  }

  /**
   * @return Container
   */
  public function getContainer() {
    $dumpClass = '\\' . $this->configurator->getDumpNamespace() . '\\' . $this->configurator->getDumpClassname();
    if (!$this->debug && class_exists($dumpClass)) {
      $container = new $dumpClass();
    } else {
      $container = $this->getConfiguredContainer();
      $container->compile();
    }
    return $container;
  }

  public function getConfiguredContainer() {
    return $this->configurator->configure(new ContainerBuilder());
  }
}
