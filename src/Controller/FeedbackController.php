<?php

namespace App\Controller;

use App\Entity\FeedbackRequest;
use App\Form\FeedbackRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
    /**
     * @Route("/feedback", name="feedback")
     */
    public function index(Request $request)
    {
        $feedbackRequest = new FeedbackRequest();
        $form = $this -> createForm(FeedbackRequestType::class,$feedbackRequest);
        $form -> handleRequest($request);

        if($form ->isSubmitted() && $form->isValid()){
                $manager = $this->getDoctrine()->getManager();
                $manager-> persist($feedbackRequest);
                $manager-> flush();
            $this->addFlash(
                'info',
                'Спасибо за отзыв!'
            );

                return $this ->redirectToRoute('feedback');
        }

        return $this->render('feedback/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
