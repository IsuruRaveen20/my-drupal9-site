<?php

namespace Drupal\custom_form\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class SimpleForm extends FormBase {

/**
 * Getter method for Form ID.
 *
 * @return string
 *   The unique ID of the form defined by this class.
 */
public function getFormId() {
    return 'form_api_example_simple_form';
}

/**
 * Build the simple form.
 *
 * @param array $form
 *   Default form array structure.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   Object containing current form state.
 *
 * @return array
 *   The render array defining the elements of the form.
 */
public function buildForm(array $form, FormStateInterface $form_state) {
    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('This basic example shows a single text input element and a submit button'),
    ];
  
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Title must be at least 5 characters in length.'),
      '#required' => TRUE,
    ];
  
    // Group submit handlers in an actions element with a key of "actions" so
    // that it gets styled correctly, and so that other modules may add actions
    // to the form. This is not required, but is convention.
    $form['actions'] = [
      '#type' => 'actions',
    ];
  
    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
  
    return $form;
  }

  /**
 * Implements form validation.
 *
 * @param array $form
 *   The render array of the currently built form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   Object describing the current state of the form.
 */
public function validateForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    if (strlen($title) < 5) {
      // Set an error for the form element with a key of "title".
      $form_state->setErrorByName('title', $this->t('The title must be at least 5 characters long.'));
    }
}

/**
 * Implements a form submit handler.
 *
 * @param array $form
 *   The render array of the currently built form.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   Object describing the current state of the form.
 */
public function submitForm(array &$form, FormStateInterface $form_state) {
    $title = $form_state->getValue('title');
    $this->messenger()->addStatus($this->t('You specified a title of %title.', ['%title' => $title]));
}

}