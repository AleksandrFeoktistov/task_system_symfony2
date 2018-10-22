<?php

namespace App\Controller;

use App\Entity\Project2;
use App\Entity\Tickets;
use App\Form\Project2Type;
use App\Repository\Project2Repository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\User;


/**
 * @Route("/project2")
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="project2_index", methods="GET")
     */
    public function index(Project2Repository $project2Repository): Response
    {
        return $this->render('project2/index.html.twig', ['project2s' => $project2Repository->findAll()]);
    }

    /**
     * @Route("/new", name="project2_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $project2 = new Project2();
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //передаем creater_id
        $project2->setcreaterId($user->getId());
        //
        $repository = $this->getDoctrine()->getRepository(User::class);
        $user = $this->getDoctrine()
                ->getRepository(User::class)
                ->findBySomeField();
                 $username = array();
                 foreach ($user as $row){
                          $username[$row['username']] = $row['id'];
                          }
        $form = $this->createFormBuilder($project2)
                  ->add('name', TextType::class)
                  ->add('description', TextType::class)
                  ->add('assignedId', ChoiceType::class, array(
                        'choices'  => $username,
                         ))
                 ->add('createrId', HiddenType::class)
                 ->add('save', SubmitType::class, array('label' => 'Create project'))
                 ->getForm();
                    $form->handleRequest($request);
              if ($form->isSubmitted() && $form->isValid()) {
                   $ticket = $form->getData();
                   $entityManager = $this->getDoctrine()->getManager();
                   $entityManager->persist($project2);
                   $entityManager->flush();
              return $this->redirectToRoute('project2_index');
              }
              return $this->render('tickets/new.html.twig',
              array('project2' => $project2,
              'form' => $form->createView(),
               ));
    }

    /**
     * @Route("/{id}", name="project2_show", methods="GET")
     */
    public function show(Project2 $project2): Response
    {
        // $repository = $this->getDoctrine()->getRepository(Tickets::class);
        // $tickets = $repository->findOneBytickets($project2->getId());
        $repository = $this->getDoctrine()->getRepository(Tickets::class);
        $tickets = $repository->findBy(['project_id' => $project2->getId(),]);
        return $this->render('project2/show.html.twig', ['project2' => $project2, 'tickets' => $tickets ]);
    }

    /**
     * @Route("/{id}/edit", name="project2_edit", methods="GET|POST")
     */
    public function edit(Request $request, Project2 $project2): Response
    {
        $this->denyAccessUnlessGranted('edit', $project2);
        $form = $this->createForm(Project2Type::class, $project2);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('project2_index');
        }
        return $this->render('project2/edit.html.twig', [
            'project2' => $project2,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/{id}", name="project2_delete", methods="DELETE")
     */
    public function delete(Request $request, Project2 $project2): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project2->getId(), $request->request->get('_token'))) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($project2);
            $manager->flush();
        }

        return $this->redirectToRoute('project2_index');
    }
}
