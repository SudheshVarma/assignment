<?php

namespace Drupal\sp_assignment\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


class timeConfigForm extends ConfigFormBase {
	/**
	 * {@inheritdoc}
	 */
	public function getFormId() {
		return 'time_config_form';
	}

	/**
	 * {@inheritdoc}
	 */
	protected function getEditableConfigNames() {
		return [
			'time_config.settings',
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function buildForm(array $form, FormStateInterface $form_state) {

		// Country text box field
		$form['country'] = [
			'#title' => $this->t('Country'),
			'#type' => 'textfield',
			'#description' => $this->t('Country name goes here'),
			'#required' => TRUE,
			'#default_value' => \Drupal::state()->get('time_config.country'),
		];

		// City text box field
		$form['city'] = [
			'#title' => $this->t('City'),
			'#type' => 'textfield',
			'#description' => $this->t('City name goes here'),
			'#required' => TRUE,
			'#default_value' => \Drupal::state()->get('time_config.city'),
		];

		// Fetching timezones globally defined in .module file
		$zone_options = timezone_selection();

		// Timezone Dropdown field
		$form['timezone'] = [
			'#title' => $this->t('Timezone'),
			'#type' => 'select',
			'#description' => $this->t('Select a TimeZone'),
			'#options' => $zone_options,
			'#required' => TRUE,
			'#default_value' => \Drupal::state()->get('time_config.timezone'),
		];
		
		return parent::buildForm($form, $form_state);
	}

	/**
	 * {@inheritdoc}
	 */
	public function validateForm(array &$form, FormStateInterface $form_state) {

		// Validating textfield data to only to accept names
		$values = $form_state->getValues();
		if (!preg_match('/^[a-zA-Z ]+$/i', $values['country'])) {
			$form_state->setErrorByName('country', t('Country Name should only have Alphabets and Spaces'));
		}
		if (!preg_match('/^[a-zA-Z ]+$/i', $values['city'])) {
			$form_state->setErrorByName('city', t('City Name should only have Alphabets and Spaces'));
		}

	}

	/**
	 * {@inheritdoc}
	 */
	public function submitForm(array &$form, FormStateInterface $form_state) {

		// Saving values as config
		$values = $form_state->getValues();
		$fields = ['country', 'city', 'timezone'];
		foreach ($fields as $field) {
			if (!empty($values[$field])) {
				\Drupal::state()->set('time_config.' . $field, $values[$field]);
			}
		}

	}

}