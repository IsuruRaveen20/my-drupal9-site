<?php

namespace Drupal\test_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * This example demonstrates a form with email, first name, last name, and avatar fields.
 */
class CustomForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form';
  }

  /**
   * Build the form.
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
      '#markup' => $this->t('This form includes email, first name, last name, and avatar fields.'),
    ];
  
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#description' => $this->t('Please enter your email address.'),
      '#required' => TRUE,
    ];
  
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First Name'),
      '#description' => $this->t('Please enter your first name.'),
      '#required' => TRUE,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last Name'),
      '#description' => $this->t('Please enter your last name.'),
      '#required' => TRUE,
    ];

    $form['avatar'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Avatar'),
      '#description' => $this->t('Upload your avatar.'),
      '#upload_location' => 'public://avatars/',
      '#required' => TRUE,
    ];
  
    $form['actions'] = [
      '#type' => 'actions',
    ];
  
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
  
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission logic here.
    // For now, you can just print the submitted values.
    $email = $form_state->getValue('email');
    $first_name = $form_state->getValue('first_name');
    $last_name = $form_state->getValue('last_name');
    $avatar = $form_state->getValue('avatar')[0];

    drupal_set_message($this->t('Submitted email: @email, First Name: @first_name, Last Name: @last_name, Avatar: @avatar', [
      '@email' => $email,
      '@first_name' => $first_name,
      '@last_name' => $last_name,
      '@avatar' => $avatar,
    ]));
  }
}
