<?php

namespace Drupal\custom_module\Table;

use Drupal\Core\Table\TableBuilder;

/**
 * Defines a table for displaying API data.
 */
class CustomModuleTable extends TableBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header = [
      'id' => $this->t('ID'),
      'first_name' => $this->t('First Name'),
      'last_name' => $this->t('Last Name'),
      'email' => $this->t('Email'),
      'avatar' => $this->t('Avatar'),
    ];

    return $header;
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow($row) {
    return [
      'id' => $row['id'],
      'first_name' => $row['first_name'],
      'last_name' => $row['last_name'],
      'email' => $row['email'],
      'avatar' => $row['avatar'],
    ];
  }
}
