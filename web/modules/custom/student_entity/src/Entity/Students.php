<?php

namespace Drupal\student_entity\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\user\EntityOwnerInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the Student entity.
 *
 * @ingroup student_entity
 *
 * @ContentEntityType(
 *   id = "students",
 *   label = @Translation("Student"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\student_entity\StudentsListBuilder",
 *     "views_data" = "Drupal\student_entity\Entity\StudentsViewsData",
 *     "translation" = "Drupal\student_entity\StudentsTranslationHandler",
 *     "form" = {
 *       "default" = "Drupal\student_entity\Form\StudentsForm",
 *       "add" = "Drupal\student_entity\Form\StudentsForm",
 *       "edit" = "Drupal\student_entity\Form\StudentsForm",
 *       "delete" = "Drupal\student_entity\Form\StudentsDeleteForm",
 *     },
 *     "access" = "Drupal\student_entity\StudentsAccessControlHandler",
 *   },
 *   base_table = "students",
 *   data_table = "students_field_data",
 *   translatable = TRUE,
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *   },
 *   links = {
 *     "canonical" = "/students/{students}",
 *     "add-form" = "/entity_students/add",
 *     "edit-form" = "/students/{students}/edit",
 *     "delete-form" = "/students/{students}/delete",
 *     "collection" = "/admin/structure/students",
 *   },
 *   field_ui_base_route = "students.settings",
 * )
 */
class Students extends ContentEntityBase implements ContentEntityInterface, EntityOwnerInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Name field.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the student.'))
      ->setRequired(TRUE)
      ->setSetting('max_length', 255)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Age field.
    $fields['age'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Age'))
      ->setDescription(t('The age of the student.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'integer',
        'weight' => -3,
      ])
      ->setDisplayOptions('form', [
        'type' => 'number',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Bio field.
    $fields['bio'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Bio'))
      ->setDescription(t('The biography of the student.'))
      ->setRequired(TRUE)
      ->setDisplayOptions('view', [
        'label' => 'above',
        'type' => 'text_long',
        'weight' => -2,
      ])
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Add additional fields if needed.

    return $fields;
  }

}
