<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tickets;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * @Route("/comments")
 */
class CommentsController extends AbstractController
{
    /**
     * @Route("/", name="comments_index", methods="GET")
     */
    public function index(CommentsRepository $commentsRepository): Response
    {
        return $this->render('comments/index.html.twig', ['comments' => $commentsRepository->findAll()]);
    }
    /**
     * @Route("/new/{id}", name="comments_new", methods="GET|POST")
     */
    public function new(Request $request, Tickets $ticket): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $comment = new Comments();
        $comment->setUserId($user->getId());
        $comment->setTicketId($ticket->getId());
        $form = $this->createFormBuilder($comment)
                ->add('text', TextType::class)
                ->add('ticketId', HiddenType::class)
                ->add('userId', HiddenType::class)
                ->add('save', SubmitType::class, array('label' => 'Create comment'))
                ->getForm();
        $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                    $comment = $form->getData();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($comment);
                    $entityManager->flush();
                    return $this->redirectToRoute('tickets_show', array('id' => $ticket->getId()));
            }
        return $this->render('comments/new.html.twig',array('comment' => $comment,
        'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="comments_show", methods="GET")
     */
    public function show(Comments $comment): Response
    {
        return $this->render('comments/show.html.twig', ['comment' => $comment]);
    }

    /**
     * @Route("/{id}/edit", name="comments_edit", methods="GET|POST")
     */
    public function edit(Request $request, Comments $comment): Response
    {
        $this->denyAccessUnlessGranted('editcomments', $comment);
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        //передаем creater_id
        //$comments->setuserId($user->getId());
        // передаем projectId
        //$comments ->setticketId($comment->get());
        //
        $form = $this->createFormBuilder($comment)
                  ->add('text', TextType::class)
                 ->add('ticketId', HiddenType::class)
                 ->add('userId', HiddenType::class)
                 ->add('save', SubmitType::class, array('label' => 'Create project'))
                 ->getForm();
                    $form->handleRequest($request);
              if ($form->isSubmitted() && $form->isValid()) {
                   $comments = $form->getData();
                   $entityManager = $this->getDoctrine()->getManager();
                   $entityManager->persist($comments);
                   $entityManager->flush();
              return $this->redirectToRoute('tickets_show',array('id'=>$comment->getticketId()));
              }
              return $this->render('comments/edit.html.twig',
              array('comments' => $comment,
              'form' => $form->createView(),
               ));
    }

    /**
     * @Route("/{id}", name="comments_delete", methods="DELETE")
     */
    public function delete(Request $request, Comments $comment): Response
    {
        $this->denyAccessUnlessGranted('editcomments', $comment);
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($comment);
            $manager->flush();
        }

        return $this->redirectToRoute('comments_index');
    }
}
