<?php

namespace Drupal\movie_review_custom\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;

/**
 * Class SearchForm.
 */
class SearchForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'search_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

  //   $title = \Drupal::request()->query->get('title');
  //   $cast = \Drupal::request()->query->get('cast');
  //   echo($cast);
  //   //exit();
  //   $form['#prefix'] = '<div class="container"><div class=""row>';
  //   $form['#suffix'] = '</div></div>';
  //   $form['moviename'] = [
  //     '#type' => 'textfield',
  //     '#title' => $this->t('MovieName'),
  //     '#description' => $this->t('Movie Name'),
  //     '#maxlength' => 64,
  //     '#size' => 64,
  //     '#weight' => '0',
  //     '#prefix' => '<div class="col-md-4">',
	//     '#suffix' => '</div>',
  //   ];
  //   $form['cast'] = [
  //     '#type' => 'textfield',
  //     '#title' => $this->t('Cast'),
  //     '#description' => $this->t('Actor/Actress Name'),
  //     '#maxlength' => 64,
  //     '#size' => 64,
  //     '#weight' => '0',
  //     '#prefix' => '<div class="col-md-4">',
	//     '#suffix' => '</div>',
  //   ];
  //   $form['submit'] = [
  //     '#type' => 'submit',
  //     '#value' => $this->t('Submit'),
  //     '#prefix' => '<div class="col-md-4">',
	//     '#suffix' => '</div>',
  //   ];

  //   // $query = \Drupal::database()->select('users_field_data', 'u');
  //   // $query->fields('u', ['uid','name','mail']);
  //   // $results = $query->execute()->fetchAll();
  //   $header = [
  //     'title' => t('Title'),
  //     'release_date' => t('Release Date'),
  //   ];

  //   $query = \Drupal::entityQuery('node')
  //   ->condition('status', 1)
  //   ->condition('type', 'moview')
  //   ->condition('title', $title, '=')
  //   ->condition('field_cast', $cast, '=')
  //   ->sort('created', 'DESC');

  //   $nids = $query->execute();
    
  //   $output = array();
  //   if (!empty($nids)) {
      
  //     $nodes = Node::loadMultiple($nids);
  //     $i=0;
  //     foreach($nodes as $key => $value) {

  //       $output[$key] = [
  //         'title' => $value->getTitle(),     // 'userid' was the key used in the header
  //         'release_date' => $value->get('field_release_date')->getValue()[0]['value'], // 'Username' was the key used in the header
  //       ];
  //     }
  //   }
  //   //print_r($output);
  //   //exit();

  //   // Initialize an empty array
  //   // $output = array();
  //   // // Next, loop through the $results array
  //   // foreach ($results as $result) {
  //   //     //if ($result->uid != 0 ) {
  //   //       $output[$result->uid] = [
  //   //         'userid' => $result->uid,     // 'userid' was the key used in the header
  //   //         'Username' => $result->name, // 'Username' was the key used in the header
  //   //         'email' => $result->mail,    // 'email' was the key used in the header
  //   //       ];
  //   //     //}
  //   // }
    
  //   //exit();

  //  $form['table'] = [
  //   '#type' => 'tableselect',
  //   '#header' => $header,
  //   '#options' => $output,
  //   '#empty' => t('No result found'),
  //   ];
  //   return $form;

    $form['filters'] = [
      '#type'  => 'fieldset',
      '#title' => $this->t('Filter'),
      '#open'  => true,
    ];

    $form['filters']['title'] = [
        '#title'         => 'Title',
        '#type'          => 'search'

    ];
    $form['filters']['cast'] = [
        '#title'         => 'Cast',
        '#type'          => 'search'
    ];
    $form['filters']['actions'] = [
        '#type'       => 'actions'
    ];

    $form['filters']['actions']['submit'] = [
        '#type'  => 'submit',
        '#value' => $this->t('Filter')

    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $field = $form_state->getValues();
	  $title = $field["title"];
	  $cast = $field["cast"];
    $url = \Drupal\Core\Url::fromRoute('movie_review_custom.search_form')
          ->setRouteParameters(array('title'=>$title,'cast'=>$cast));
    $form_state->setRedirectUrl($url); 
  }

}