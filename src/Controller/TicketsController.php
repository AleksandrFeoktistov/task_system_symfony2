<?php

namespace App\Controller;

use App\Entity\Tickets;
use App\Form\TicketsType;
use App\Repository\TicketsRepository;
use App\Entity\Project2;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use App\Entity\Comments;
use App\Entity\Tags;
use App\Repository\TagsRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\User;

/**
 * @Route("/tickets")
 */
class TicketsController extends AbstractController
{
    /**
     * @Route("/", name="tickets_index", methods="GET")
     */
    public function index(TicketsRepository $ticketsRepository): Response
    {
        return $this->render('tickets/index.html.twig', ['tickets' => $ticketsRepository->findAll()]);
    }

    /**
     * @Route("/new/{id}", name="tickets_new", methods="GET|POST")
     */
    public function new(Request $request, Project2 $project): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $ticket = new Tickets();
        $ticket->setcreaterId($user->getId());
        $ticket->setprojectId($project->getId());
         $repository = $this->getDoctrine()->getRepository(User::class);
        //  $user = $repository->findall();
         $user = $this->getDoctrine()
          ->getRepository(User::class)
          ->findBySomeField();
           $username = array();
           foreach ($user as $row)
          {
            $username[$row['username']] = $row['id'];
          }
        $form = $this->createFormBuilder($ticket)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, array(
                  'choices'  => array(
                  'task' => 1,
                  'bug' => 2,
                  ),
                  ))
           ->add('status', ChoiceType::class, array(
                  'choices'  => array(
                  'new' => 1,
                  'in progress' => 2,
                  'end' => 3,
                  ),
                  ))
          ->add('assignedId', ChoiceType::class, array(
                  'choices'  => $username,
                   ))
           ->add('file', TextType::class)


            //->add('save', SubmitType::class, array('label' => 'Create Task'))
            ->add('projectId', HiddenType::class)
            ->add('createrId', HiddenType::class)
            ->add('save', SubmitType::class, array('label' => 'Create ticket'))
            ->getForm();
              $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              $ticket = $form->getData();
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($ticket);
              $entityManager->flush();
              return $this->redirectToRoute('tickets_index');
            }
            return $this->render('tickets/new.html.twig',
            array('ticket' => $ticket,
            'form' => $form->createView(),
             ));
    }

    /**
     * @Route("/{id}", name="tickets_show", methods="GET")
     */
    public function show(Tickets $ticket): Response
    {
      $manager = $this->getDoctrine()->getManager();
      $manager->persist($ticket);
      $manager->flush();
      $repository = $this->getDoctrine()->getRepository(Comments::class);
      $comments = $repository->findBy(['ticket_id' => $ticket->getId(),]);
      return $this->render('tickets/show.html.twig', ['ticket' => $ticket, 'comments' => $comments ]);
    }

    /**
     * @Route("/{id}/edit", name="tickets_edit", methods="GET|POST")
     */
    public function edit(Request $request, Tickets $ticket, AuthorizationCheckerInterface $authChecker): Response
    {

     // check for "edit" access: calls all voters
        $this->denyAccessUnlessGranted('edit', $ticket);
        $user = $this->getDoctrine()
         ->getRepository(User::class)
         ->findBySomeField();
          $username = array();
        $tags = $this->getDoctrine()
         ->getRepository(Tags::class)
         ->findBySomeField();
         $tagsName = array();
         var_dump($tags);
           foreach ($tags as $key) {
             $tagsName[] = $key['name'];
             // code...
           }
         $tagsName = implode(",", $tagsName);
         var_dump($tagsName);
          foreach ($user as $row)
         {
           $username[$row['username']] = $row['id'];
         }
        $form = $this->createFormBuilder($ticket)
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('type', ChoiceType::class, array(
                  'choices'  => array(
                  'task' => 1,
                  'bug' => 2,
                  ),
                  ))
           ->add('status', ChoiceType::class, array(
                  'choices'  => array(
                  'new' => 1,
                  'in progress' => 2,
                  'end' => 3,
                  ),
                  ))
          ->add('assignedId', ChoiceType::class, array(
                  'choices'  => $username,
                   ))
           ->add('file', TextType::class)
            ->add('projectId', HiddenType::class)
            ->add('createrId', HiddenType::class)
            ->add('tags', TextType::class,array(
               "mapped" => false, 'data' => "$tagsName"))
            ->add('save', SubmitType::class, array('label' => 'Create ticket'))
            ->getForm();
              $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
              $ticket = $form->getData();
              $tags = $form->get('tags')->getData();
              $tag = new Tags();
              $tag ->setName($tags);
              $em = $this->getDoctrine()->getManager();
              $em->persist($tag);
              $em->flush();
              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($ticket);
              $entityManager->flush();
              return $this->redirectToRoute('tickets_index');
            }
            return $this->render('tickets/new.html.twig',
            array('ticket' => $ticket,
            'form' => $form->createView(),
             ));
    }

    /**
     * @Route("/{id}", name="tickets_delete", methods="DELETE")
     */
    public function delete(Request $request, Tickets $ticket): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ticket->getId(), $request->request->get('_token'))) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($ticket);
            $manager->flush();
        }

        return $this->redirectToRoute('tickets_index');
    }
}
