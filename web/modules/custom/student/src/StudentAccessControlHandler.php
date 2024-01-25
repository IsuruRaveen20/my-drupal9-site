<?php

namespace Drupal\student;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Defines the access control handler for the student entity type.
 */
class StudentAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

    // Check if the user has the 'student' role.
    if ($account->hasRole('student')) {
      // If yes, allow access.
      return static::allowed();
    }

    // For other roles, use the default access control.
    return parent::checkAccess($entity, $operation, $account);

  }
  
  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermissions(
      $account,
      ['create student', 'administer student'],
      'OR',
    );
  }
  
}
// if ($operation === 'view' && $account->hasRole('student')) {
//   return AccessResult::allowed();
// }

// return parent::checkAccess($entity, $operation, $account);


// switch ($operation) {
//   case 'view':
//     return AccessResult::allowedIfHasPermission($account, 'view student');

//   case 'update':
//     return AccessResult::allowedIfHasPermissions(
//       $account,
//       ['edit student', 'administer student'],
//       'OR',
//     );

//   case 'delete':
//     return AccessResult::allowedIfHasPermissions(
//       $account,
//       ['delete student', 'administer student'],
//       'OR',
//     );

//   default:
//     // No opinion.
//     return AccessResult::neutral();
// }

// }
