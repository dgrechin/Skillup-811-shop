<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $products = $productRepository -> findBy(['isTop'=> true]);

        $tree = $categoryRepository->childrenHierarchy(
            null,
            false,
            [
                'decorate' =>true,
                'representationField'=> 'name',
                'html' => true,

            ]
        );



        return $this->render('default/index.html.twig', [
            'products' => $products,
            'tree' => $tree,
        ]);
    }

    /**
     * @Route("/serach", name="search")
     *
     */
    public function search(Request $request, ProductRepository $repository)

    {
        $query= $request->query->get('q');

        if ($query) {
            $products = $repository->findByName($query);
        }else{
            $products=[];
        }
        return $this->render('default/search.html.twig',[
            'products'=>$products,
        ]);

    }
}
