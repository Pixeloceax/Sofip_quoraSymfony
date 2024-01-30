<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Question;
use App\Form\QuestionType;


class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]

    public function addQuestion(Request $request, EntityManagerInterface $entityManager)
    {
        $question = new Question();

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('question/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}