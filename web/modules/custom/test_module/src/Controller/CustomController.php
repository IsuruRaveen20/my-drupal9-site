<?php

namespace Drupal\test_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Controller for the custom module.
 * Controller for displaying API data in a table.
 * 
 * @package Drupal\test_module\Controller;
 */
class CustomController extends ControllerBase {

  protected $httpClient;
  /**
   * Callback for the custom route.
   *
   * @return array
   *   The rendered output.
   */

  /**
   * Constructor.
   *
   * @param \GuzzleHttp\ClientInterface $http_client
   *   The HTTP client service.
   */
  public function __construct(ClientInterface $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * Callback for the custom route.
   *
   * @return array
   *   The rendered output.
   */
  public function customRoute() {

    // Fetch data from the API.
    $api_url = 'https://reqres.in/api/users?page=1';
    $response = $this->httpClient->request('GET', $api_url);
    $data = json_decode($response->getBody(), TRUE);

    // Process the data and display it in a custom table.
    $table = // Create or load your custom table with $data.

    // Load your custom form and table here.
    $form = \Drupal::formBuilder()->getForm('Drupal\test_module\Form\CustomForm');
    //$table = 

    // Return the theme with form and table variables.
    return [
      '#theme' => 'custom_theme',
      '#form' => $form,
      '#table' => $table,
    ];
  }

}
