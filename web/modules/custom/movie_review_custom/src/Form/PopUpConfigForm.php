<?php

namespace Drupal\movie_review_custom\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
/**
 * Class PopUpConfigForm.
 */
class PopUpConfigForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'movie_review_custom.popupconfig',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'pop_up_config_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $config = $this->config('movie_review_custom.popupconfig');
    
    $form['title'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Main Title of pop up'),
      '#default_value' => $config->get('title'),
    ];
    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#default_value' => $config->get('description'),
    ];
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Image'),
      '#description' => $this->t('pop up image'),
      '#upload_location' => 'public://upload/popup',
      '#upload_validators' => [
          'file_validate_extensions' => ['jpg', 'jpeg', 'png', 'gif']
      ],
      '#default_value' => $config->get('image'),
    ];

    return parent::buildForm($form, $form_state);
  }

  
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $config = $this->config('movie_review_custom.popupconfig');
    $image = $form_state->getValue('image');
    if ($image != $config->get('image')) {
      if (!empty($image[0])) {
        $file = File::load($image[0]);
        $file->setPermanent();
        $file->save();
      }
    }

    $this->config('movie_review_custom.popupconfig')
      ->set('title', $form_state->getValue('title')['value'])
      ->set('description', $form_state->getValue('description'))
      ->set('image', $form_state->getValue('image'))
      ->save();
  }

}
