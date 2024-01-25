<?php

//namespace Drupal\your_module\Plugin\Block;
use Drupal\Core\Block\BlockBase;


class MyNewCustomBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Load and render nodes of the custom content type.
    $nodes = \Drupal::entityTypeManager()
      ->getStorage('node')
      ->loadByProperties(['type' => 'second_test_content_type']);

    // Render nodes in a simple list.
    $output = '<ul>';
    foreach ($nodes as $node) {
      $output .= '<li>' . $node->getTitle() . '</li>';
    }
    $output .= '</ul>';

    return [
      '#markup' => $output,
    ];
  }
}
