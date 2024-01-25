<?php

namespace Drupal\student\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\Language;
/**
 * Form controller for the student entity edit forms.
 */
class StudentForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    $entity = $this->entity;

    // Check if $entity is set and is a valid entity.
    if ($entity && $entity->getEntityTypeId() === 'student') {
      $form['langcode'] = [
        '#title' => $this->t('Language'),
        '#type' => 'language_select',
        '#default_value' => $entity->getUntranslated()->language()->getId(),
        '#languages' => Language::STATE_ALL,
      ];
    }
    else {
      // Log an error if $entity is not valid.
      $this->logger('student')->error('Error in StudentForm: $entity is not set or is not a valid entity.');
      // Display a basic error message to the user.
      drupal_set_message($this->t('An error occurred while loading the form. Please try again later.'), 'error');
      // Returning an empty array.
      return [];
    }

    return $form;
  }
  


  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    parent::save($form, $form_state);
    
    $entity = $this->getEntity();
    $entity->save();
    
    // Redirect to the canonical page for the saved/updated entity.
    $form_state->setRedirect('entity.student.canonical', ['student' => $entity->id()]);
  }
  
}
// /**
//  * {@inheritdoc}
//  */
// public function buildForm(array $form, FormStateInterface $form_state) {
//   /** @var \Drupal\student\Entity\Student $entity */
//   $form = parent::buildForm($form, $form_state);
//   $entity = $this->entity;

//   $form['langcode'] = [
//     '#title' => $this->t('Language'),
//     '#type' => 'language_select',
//     '#default_value' => $entity->getUntranslated()->language()->getId(),
//     '#languages' => Language::STATE_ALL,
//   ];

//   return $form;
// }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function buildForm(array $form, FormStateInterface $form_state) {
  //   $form = parent::buildForm($form, $form_state);
  //   $entity = $this->entity;

  //   $form['langcode'] = [
  //     '#title' => $this->t('Language'),
  //     '#type' => 'language_select',
  //     '#default_value' => $entity->getUntranslated()->language()->getId(),
  //     '#languages' => Language::STATE_ALL,
  //   ];
  //   return $form;
  // }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function save(array $form, FormStateInterface $form_state) {
  //   parent::save($form, $form_state);
  //   $entity = $this->getEntity();
  //   $entity->save();

  //   // Redirect to the canonical page for the saved/updated entity.
  //   $form_state->setRedirect('entity.student.canonical', ['student' => $entity->id()]);
  //   //$form_state->setRedirect('entity.content_entity_example_contact.collection');
  // }

  // /**
  //  * {@inheritdoc}
  //  */
  // public function save(array $form, FormStateInterface $form_state) {
  //   // Get the entity being edited/created.
  //   $entity = $this->getEntity();

  //   // Validate the form submission.
  //   $form_state->setRedirect('entity.student.canonical', ['student' => $entity->id()]);
  //   $result = parent::save($form, $form_state);

  //   // Check if the entity was saved successfully.
  //   if ($result == SAVED_NEW || $result == SAVED_UPDATED) {
  //     // Display success messages.
  //     $this->messenger()->addStatus($this->t('The student %label has been saved.', ['%label' => $entity->label()]));
  //     $this->logger('student')->notice('Saved student %label.', ['%label' => $entity->label()]);

  //     // Redirect to the canonical page for the saved/updated entity.
  //     $form_state->setRedirect('entity.student.canonical', ['student' => $entity->id()]);
  //   } else {
  //     // Handle errors during saving.
  //     $this->messenger()->addError($this->t('The student could not be saved.'));
  //     $this->logger('student')->error('Unable to save student %label.', ['%label' => $entity->label()]);
  //   }

  //   return $result;
  // }


