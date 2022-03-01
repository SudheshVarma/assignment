<?php

/**
* @file providing the service that provides a time in predifined timezone.
*
*/

namespace Drupal\sp_assignment\Services;
use Drupal\Core\State\StateInterface;

class timeService {
 /**
  * The config factory.
  *
  * @var \Drupal\Core\Config\ConfigFactoryInterface
  */
  protected $state;
 
  /**
   * Constructs a new OrderNumberFormatter object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   */
  public function __construct(StateInterface $state) {
    $this->state = $state;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    return new static(
    // Load the service required to construct this class.
      $container->get('state')
    );
  }
  
  /**
   * @inheritDoc
   */
 public function  getTime(){

	// Fetching selected timezone.
	$selected_zone = $this->state->get('time_config.timezone');

	// Fetching timezones globally defined in .module file.
	$zones = timezone_selection();

	// Convert and return date in required format.
	return \Drupal::service('date.formatter')
				->format(time(), 'custom', 'dS M Y - h:i A', $zones[$selected_zone]);
 }

}