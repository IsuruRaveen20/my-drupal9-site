<?php

namespace Drupal\test_module\Table;

use Drupal\Core\Table\TableBase;

/**
 * Defines a custom table to display API data.
 */
class CustomTable extends TableBase {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'id' => $this->t('ID'),
      'first_name' => $this->t('First Name'),
      'last_name' => $this->t('Last Name'),
      // Add more columns based on your API response.
    ];

    return $header;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRows(array $data) {
    $rows = [];

    foreach ($data as $item) {
      $rows[] = [
        'id' => $item['id'],
        'first_name' => $item['first_name'],
        'last_name' => $item['last_name'],
        // Add more columns based on your API response.
      ];
    }

    return $rows;
  }

}
