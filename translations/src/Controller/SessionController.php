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

/**
 * @Route("/project2")
 */
class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="session_index", methods="POST")
     */
    public function session(Project2Repository $project2Repository): Response
    {
        return $this->render('project2/index.html.twig', ['project2s' => $project2Repository->findAll()]);
    }
}
