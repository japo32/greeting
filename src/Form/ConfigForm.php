<?php
namespace Drupal\greeting\Form;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class ConfigForm extends ConfigFormBase {
  public function getFormId() {
    return 'greeting_config';
  }

  protected function getEditableConfigNames() {
    return ['greeting.settings'];
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('greeting.settings');

    $form['default_count'] = [
      '#type' => 'number',
      '#title' => $this->t('Default greeting count'),
      '#default_value' => $config->get('default_count'),
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('greeting.settings')
      ->set('default_count', $form_state->getValue('default_count'))
      ->save();
  }
}
