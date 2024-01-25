<?php

namespace Drupal\student_entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining a students entity type.
 */
interface StudentsInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
