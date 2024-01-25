<?php


namespace Drupal\custom_module\controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\custom_module\Form\CustomForm;
use GuzzleHttp\ClientInterface;
use Symfony\Component\HttpFoundation\Request;
use Drupal\custom_module\Table\CustomModuleTable;


class CustomModuleController extends ControllerBase {

  /**
   * The HTTP client service.
   *
   * @var \GuzzleHttp\ClientInterface
   *      
   * */
  protected $httpClient;

  /**
  * CustomThemeController constructor.
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
   * Route callback.
   */
  public function content(Request $request) {
      // Fetch API data and pass it to the table.
      $api_data = $this->fetchApiData();

      // Create form instance.
      $form = $this->formBuilder()->getForm(CustomForm::class);

      // Create table instance.
      $table = new CustomModuleTable();
      $table->setHeader($table->buildHeader());

      // Add rows to the table.
      foreach ($api_data as $row) {
        $table->addRow($table->buildRow($row));
      }

    // Pass form and API data to the theme.
    //   $output['#theme'] = 'custom_theme';
    //   $output['#form'] = $form;
    //   $output['#table'] = $api_data;

    //   return $output;
    // var_dump($api_data);die;
    // Return the themed table with API data.
    return [
      '#theme' => 'custom_module_theme',
      '#variables' => [
        //'#table' => $api_data,
        '#table'  => $table,
        '#form' => $form,
      ],
    ];
  }

  /**
   * Fetch data from the API.
   */
  private function fetchApiData() {
      // Fetch data from the API (replace with your actual API endpoint).
      $api_endpoint = 'https://reqres.in/api/users?page=1';
      $response = $this->httpClient->get($api_endpoint);
      $data = json_decode($response->getBody(), TRUE);

      // Extract relevant data for the table (adjust as needed).
      $api_data = [];
      foreach ($data['data'] as $item) {
          $api_data[] = [
              'id' => $item['id'],
              'first_name' => $item['first_name'],
              'last_name' => $item['last_name'],
              'email' => $item['email'],
              'avatar' => $item['avatar'],
          ];
      }

      return $api_data;
  }
}

