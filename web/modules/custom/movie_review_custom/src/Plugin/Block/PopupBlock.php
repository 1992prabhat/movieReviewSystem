<?php

namespace Drupal\movie_review_custom\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\file\Entity\File;
/**
 * Provides a 'PopupBlock' Block.
 *
 * @Block(
 *   id = "popup_block",
 *   admin_label = @Translation("PopupBlock"),
 *   category = @Translation("PopupBlock"),
 * )
 */
class PopupBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Init metadata.
    //$config =  \Drupal::config('modulename.my_service');
    $config = \Drupal::config('movie_review_custom.popupconfig');
    $image = $config->get('image');
    
    if (!empty($image[0])) {
      if ($file = File::load($image[0])) {
        // print_r($file->getFileUri());
        // exit();
        $image = $file->getFileUri();
      }
    }
    return array(
        'title' => $config->get('title'),
        'description' => $config->get('description'),
        'image' => $image
    );
  }

}