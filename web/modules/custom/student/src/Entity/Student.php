<?php

namespace Drupal\student\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\student\StudentInterface;
use Drupal\user\EntityOwnerTrait;

/**
 * Defines the student entity class.
 *
 * @ContentEntityType(
 *   id = "student",
 *   label = @Translation("Student"),
 *   label_collection = @Translation("Students"),
 *   label_singular = @Translation("student"),
 *   label_plural = @Translation("students"),
 *   label_count = @PluralTranslation(
 *     singular = "@count students",
 *     plural = "@count students",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\student\StudentListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "access" = "Drupal\student\StudentAccessControlHandler",
 *     "form" = {
 *       "add" = "Drupal\student\Form\StudentForm",
 *       "edit" = "Drupal\student\Form\StudentForm",
 *       "delete" = "Drupal\Core\Entity\ContentEntityDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   base_table = "student",
 *   admin_permission = "administer student",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid",
 *     "owner" = "uid",
 *   },
 *   links = {
 *     "collection" = "/admin/content/student",
 *     "add-form" = "/admin/students-content/add",
 *     "canonical" = "/admin/students-content/{student}",
 *     "edit-form" = "/admin/students-content/{student}/edit",
 *     "delete-form" = "/admin/students-content/{student}/delete",
 *   },
 *   field_ui_base_route = "entity.student.settings",
 * )
 */
class Student extends ContentEntityBase implements StudentInterface {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      // If no owner has been set explicitly, make the anonymous user the owner.
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Add UID field.
    $fields['uid'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User ID'))
      ->setDescription(t('The user ID associated with the student.'))
      ->setSetting('target_type', 'user')
      ->setRequired(true);

    // Add Name field.
    $fields['name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Name'))
      ->setDescription(t('The name of the student.'))
      ->setRequired(true);

    // Add Age field.
    $fields['age'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Age'))
      ->setDescription(t('The age of the student.'))
      ->setRequired(true);

    // Add Bio field.
    $fields['bio'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Bio'))
      ->setDescription(t('The biography of the student.'));

    return $fields;
  }
}

    // $fields['label'] = BaseFieldDefinition::create('string')
    //   ->setLabel(t('Label'))
    //   ->setRequired(TRUE)
    //   ->setSetting('max_length', 255)
    //   ->setDisplayOptions('form', [
    //     'type' => 'string_textfield',
    //     'weight' => -5,
    //   ])
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayOptions('view', [
    //     'label' => 'hidden',
    //     'type' => 'string',
    //     'weight' => -5,
    //   ])
    //   ->setDisplayConfigurable('view', TRUE);

    // $fields['status'] = BaseFieldDefinition::create('boolean')
    //   ->setLabel(t('Status'))
    //   ->setDefaultValue(TRUE)
    //   ->setSetting('on_label', 'Enabled')
    //   ->setDisplayOptions('form', [
    //     'type' => 'boolean_checkbox',
    //     'settings' => [
    //       'display_label' => FALSE,
    //     ],
    //     'weight' => 0,
    //   ])
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayOptions('view', [
    //     'type' => 'boolean',
    //     'label' => 'above',
    //     'weight' => 0,
    //     'settings' => [
    //       'format' => 'enabled-disabled',
    //     ],
    //   ])
    //   ->setDisplayConfigurable('view', TRUE);

    // $fields['description'] = BaseFieldDefinition::create('text_long')
    //   ->setLabel(t('Description'))
    //   ->setDisplayOptions('form', [
    //     'type' => 'text_textarea',
    //     'weight' => 10,
    //   ])
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayOptions('view', [
    //     'type' => 'text_default',
    //     'label' => 'above',
    //     'weight' => 10,
    //   ])
    //   ->setDisplayConfigurable('view', TRUE);

    // $fields['uid'] = BaseFieldDefinition::create('entity_reference')
    //   ->setLabel(t('Author'))
    //   ->setSetting('target_type', 'user')
    //   ->setDefaultValueCallback(static::class . '::getDefaultEntityOwner')
    //   ->setDisplayOptions('form', [
    //     'type' => 'entity_reference_autocomplete',
    //     'settings' => [
    //       'match_operator' => 'CONTAINS',
    //       'size' => 60,
    //       'placeholder' => '',
    //     ],
    //     'weight' => 15,
    //   ])
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayOptions('view', [
    //     'label' => 'above',
    //     'type' => 'author',
    //     'weight' => 15,
    //   ])
    //   ->setDisplayConfigurable('view', TRUE);

    // $fields['created'] = BaseFieldDefinition::create('created')
    //   ->setLabel(t('Authored on'))
    //   ->setDescription(t('The time that the student was created.'))
    //   ->setDisplayOptions('view', [
    //     'label' => 'above',
    //     'type' => 'timestamp',
    //     'weight' => 20,
    //   ])
    //   ->setDisplayConfigurable('form', TRUE)
    //   ->setDisplayOptions('form', [
    //     'type' => 'datetime_timestamp',
    //     'weight' => 20,
    //   ])
    //   ->setDisplayConfigurable('view', TRUE);

    // $fields['changed'] = BaseFieldDefinition::create('changed')
    //   ->setLabel(t('Changed'))
    //   ->setDescription(t('The time that the student was last edited.'));

  
