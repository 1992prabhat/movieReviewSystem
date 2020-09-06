<?php
namespace Drupal\movie_review_custom\Controller;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Routing;
use Drupal\Core\Form\FormStateInterface;
/**
 * Class SearchController.
 *
 * @package Drupal\movie_review_custom\Controller
 */
class SearchController extends ControllerBase {
    public function listMovies() {
        //Get parameter value while submitting filter form  
        $title = \Drupal::request()->query->get('title');
        $cast = \Drupal::request()->query->get('cast');

        $form['form'] = $this->formBuilder()->getForm('Drupal\movie_review_custom\Form\SearchForm');
 
        // Create table header.
        $header = [
          'title' => $this->t('Title'),
          'release_date' => $this->t('Release Date'),
          'image' => $this->t('Cover Image')
        ];
        
       if($title == "" && $cast == ""){
        $form['table'] = [
          '#type' => 'table',
          '#header' => $header,
          '#rows' => get_movies("All","",""),
          '#empty' => $this->t('No records found'),
        ];
       }else{
            $form['table'] = [
          '#type' => 'table',
          '#header' => $header,
          '#rows' => get_movies("",$title,$cast),
          '#empty' => $this->t('No records found'),
        ];
       }
        // $form['pager'] = [
        //   '#type' => 'pager'
        // ];
        return $form;
      }
}