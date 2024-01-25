<?php

namespace Drupal\student\Controller;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Controller for the Student entity.
 */
class StudentController extends ControllerBase {

    /**
     * The entity type manager.
     *
     * @var \Drupal\Core\Entity\EntityTypeManagerInterface
     */
    protected $entityTypeManager;

    /**
     * Constructs a StudentController object.
     *
     * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
     *   The entity type manager.
     */
    public function __construct(EntityTypeManagerInterface $entityTypeManager) {
        $this->entityTypeManager = $entityTypeManager;
    }

     /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container) {
        return new static(
        $container->get('entity_type.manager')
        );
    }

    /**
   * Controller function for the student entity.
   *
   * @return array
   *   Render array for the student entity page.
   */
    public function content() {
        // Check if the current user has created a Student entity.
        $uid = \Drupal::currentUser()->id();
        $storage = $this->entityTypeManager->getStorage('student');
        $student_entities = $storage->loadByProperties(['uid' => $uid]);
        
        if(count($student_entities) > 0) {
            //Load the Student entity for the current user
            $student_entity = reset($student_entities);
            $form = \Drupal::formBuilder()->getForm('Drupal\student\Form\StudentForm', reset($student_entity));

        }else {
            //Display the add form
            $form = \Drupal::formBuilder()->getForm('Drupal\student\Form\StudentForm');
        }

        
        $build = [
            '#markup' => \Drupal::service('renderer')->render($form),
        ];
        
        return $build;
    }
}
    //$hasStudentEntity = !empty($storage->loadByProperties(['uid' => $uid]));

    // if ($hasStudentEntity) {
    //     // Load the Student entity for the current user.
    //     $student_entity = $storage->loadByProperties(['uid' => $uid]);
    //     $form = \Drupal::formBuilder()->getForm('Drupal\student\Form\StudentForm', reset($student_entity));
    // } else {
    //     // Display the add form.
    //     $form = \Drupal::formBuilder()->getForm('Drupal\student\Form\StudentForm');
    // }