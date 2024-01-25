<?php

namespace Drupal\student_entity;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\Entity\User;

/**
 * Checks access for displaying the add/edit student form.
 */
class StudentsAddAccessCheck implements AccessInterface {

  /**
   * {@inheritdoc}
   */
  public function access(AccountInterface $account, $entity_bundle = NULL, array $context = []) {
    // Check if the user has the 'student' role.
    if ($account->hasRole('student')) {
      // Check if the user has already created a Student entity.
      $user = User::load($account->id());
      $students = \Drupal::entityTypeManager()->getStorage('students')->loadByProperties(['uid' => $user->id()]);

      // If the user has a Student entity, they can edit it; otherwise, they can add a new one.
      return AccessResult::allowedIf(empty($students) || reset($students)->isDefaultRevision());
    }

    return AccessResult::forbidden();
  }
}
/**
 * Defines the access control handler for the students entity type.
 */
// class StudentsAccessControlHandler extends EntityAccessControlHandler {

//   /**
//    * {@inheritdoc}
//    */
//   protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {

//     switch ($operation) {
//       case 'view':
//         return AccessResult::allowedIfHasPermission($account, 'view students');

//       case 'update':
//         return AccessResult::allowedIfHasPermissions(
//           $account,
//           ['edit students', 'administer students'],
//           'OR',
//         );

//       case 'delete':
//         return AccessResult::allowedIfHasPermissions(
//           $account,
//           ['delete students', 'administer students'],
//           'OR',
//         );

//       default:
//         // No opinion.
//         return AccessResult::neutral();
//     }

//   }

//   /**
//    * {@inheritdoc}
//    */
//   protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
//     return AccessResult::allowedIfHasPermissions(
//       $account,
//       ['create students', 'administer students'],
//       'OR',
//     );
//   }

// }
