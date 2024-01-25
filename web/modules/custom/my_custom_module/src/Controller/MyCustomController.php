<?php

namespace Drupal\my_custom_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\my_custom_module\Services\CustomService;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\my_custom_module\Form\CustomForm;

class MyCustomController extends ControllerBase {

    protected $customService;
    protected $cache;


    public function __construct(CustomService $custom_service, \Drupal\Core\Cache\CacheBackendInterface $cache) {
        $this->customService = $custom_service;
        $this->cache = $cache;
    }

    public static function create(ContainerInterface $container) {
        return new static(
            $container->get('my_custom_module.custom_service'),
            $container->get('cache.default')
        );
    }

    public function content() {
        $header = array(
            'id'        =>  $this->t('id'),
            'First Name' =>  $this->t('first Name'),
            'Last Name'  =>  $this->t('Last Name'),
            'Email'      =>  $this->t('Email')
        );
        
        $cache_id = 'my_custom_module_api_users';
        $apiData = $this->cache->get($cache_id);

        if (!$apiData) {
            $apiData = $this->customService->getAPIData();
            $this->cache->set($cache_id, $apiData, 3600);
        }

        // Check if the API request was successful
        if(isset($apiData['data'])){

            //Extract data from the API response
            $apiUsers = $apiData['data'];

            //Initialize rows array
            $rows = [];

            //Populate rows with data from the API
            foreach($apiUsers as $user){
                $rows[] = [
                    'id'    =>  $user['id'],
                    'First Name' => $user['first_name'],
                    'Last Name'  => $user['last_name'],
                    'Email'      => $user['email']
                ];
            }
        }else{
            //If API Request fails, set an Empty row
            $rows = [
                ['','','',''],
            ];
        }

        $table = [
            '#theme'    =>  'table',
            '#header'   =>  $header,
            '#rows'     =>  $rows,
            '#empty'    =>  $this->t('No Data Found!'),
        ];

        // Create form instance.
        $form = $this->formBuilder()->getForm(CustomForm::class);
        
        return [
            '#theme' => 'my_custom_template',
            '#table' => $table,
            '#form'  => $form,
            '#cache' => [
                'max_age' => 3600
            ]   
        ];
        
    }

}