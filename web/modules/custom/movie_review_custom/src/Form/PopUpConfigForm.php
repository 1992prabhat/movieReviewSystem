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

    // $form['description'] = array(
    //   '#markup' => '<div>'. t('This example shows an add-more and a remove-last button.').'</div>',
    // );
    //   $i = 0;
    //   $name_field = $form_state->get('num_names');
    //   $form['#tree'] = TRUE;
    //   $form['names_fieldset'] = [
    //     '#type' => 'fieldset',
    //     '#title' => $this->t('People coming to picnic'),
    //     '#prefix' => '<div id="names-fieldset-wrapper">',
    //     '#suffix' => '</div>',
    //   ];
    //   if (empty($name_field)) {
    //     $name_field = $form_state->set('num_names', 1);
    //   }
    //   for ($i = 0; $i < $name_field; $i++) {
    //     $form['names_fieldset']['name'][$i] = [
    //       '#type' => 'text_format',
    //   '#title' => $this->t('Title'),
    //   '#description' => $this->t('Main Title of pop up'),
    //   '#default_value' => $config->get('title'),
    //     ];

    //     $form['description'] = [
    //       '#type' => 'textarea',
    //       '#title' => $this->t('Description'),
    //       '#default_value' => $config->get('description'),
    //     ];
    //     $form['image'] = [
    //       '#type' => 'managed_file',
    //       '#title' => $this->t('Image'),
    //       '#description' => $this->t('pop up image'),
    //       '#default_value' => $config->get('image'),
    //     ];
    //   }
    //   $form['actions'] = [
    //     '#type' => 'actions',
    //   ];
    //   $form['names_fieldset']['actions']['add_name'] = [
    //     '#type' => 'submit',
    //     '#value' => t('Add one more'),
    //     '#submit' => array('::addOne'),
    //     '#ajax' => [
    //       'callback' => '::addmoreCallback',
    //       'wrapper' => 'names-fieldset-wrapper',
    //     ],
    //   ];
    //   if ($name_field > 1) {
    //     $form['names_fieldset']['actions']['remove_name'] = [
    //       '#type' => 'submit',
    //       '#value' => t('Remove one'),
    //       '#submit' => array('::removeCallback'),
    //      '#ajax' => [
    //         'callback' => '::addmoreCallback',
    //         'wrapper' => 'names-fieldset-wrapper',
    //       ]
    //     ];
    //   }
    //   $form_state->setCached(FALSE);
    //   $form['actions']['submit'] = [
    //     '#type' => 'submit',
    //     '#value' => $this->t('Submit'),
    //   ];
  
      //return $form;

    return parent::buildForm($form, $form_state);
  }

  public function addOne(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    $add_button = $name_field + 1;
    $form_state->set('num_names', $add_button);
    $form_state->setRebuild();
  }

  public function addmoreCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    return $form['names_fieldset'];
  }

  public function removeCallback(array &$form, FormStateInterface $form_state) {
    $name_field = $form_state->get('num_names');
    if ($name_field > 1) {
      $remove_button = $name_field - 1;
      $form_state->set('num_names', $remove_button);
    }
   $form_state->setRebuild();
  }

  // public function submitForm(array &$form, FormStateInterface $form_state) {
  //   $values = $form_state->getValue(array('names_fieldset', 'name'));

  //   $output = t('These people are coming to the picnic: @names', array(
  //     '@names' => implode(', ', $values),
  //       )
  //   );
  //   drupal_set_message($output);
  // }

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
