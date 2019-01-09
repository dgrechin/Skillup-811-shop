<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/{slug}", name="category", requirements={"slug" : "^[-\w]+$"})
     */
    public function index($slug='all')
    {
        switch ($slug){
            case 'tv' : $name = 'Televisions'; break;
            case 'media' : $name = 'Media'; break;
            case 'all' : $name = 'all'; break;
            default:
              throw $this->createNotFoundException('Category not found');
        }
        return $this->render('category/index.html.twig',
        ['category_code'=> $slug,
            'category_name'=> $name
            ]);
    }




}
