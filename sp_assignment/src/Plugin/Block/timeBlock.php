<?php

namespace Drupal\sp_assignment\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\State\StateInterface;

/**
 * Provides a 'Time Block' block.
 *
 * @Block(
 *  id = "time_block",
 *  admin_label = @Translation("Time Block"),
 * )
 */
class timeBlock extends BlockBase implements ContainerFactoryPluginInterface {
  
  /**
   * @var AccountInterface $account
   */
  protected $state;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, StateInterface $state) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->state = $state;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('state')
    );
  }
  
  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];

    $service = \Drupal::service('sp_assignment.return_time');
	  $state = \Drupal::state();
  
    $build = [
      '#theme' => 'time_block',
      '#items' => ['country' => $state->get('time_config.country'),
                   'city' => $state->get('time_config.city'),
                   'renderd_time' => $service->getTime()]
    ];

    return $build;
  }

}