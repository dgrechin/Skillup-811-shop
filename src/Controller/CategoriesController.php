<?php

namespace App\Controller;

use App\Entity\Attribute;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Sonata\AdminBundle\Form\Type\Filter\ChoiceType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories/", name="categories")
     */
    public function index(CategoryRepository $categoryRepository)
    {
      $categories = $categoryRepository ->findAll();


        return $this->render('categories/index.html.twig', [
            'categories'=> $categories

        ]);
    }

    /**
     * @Route("/categories/{id}", name = "category_item")
     */
 public function item(Category $category, Request $request, ProductRepository $productRepository){
     $form=$this->getFilterForm($category);
     $form->handleRequest($request);

     if($form->isSubmitted() && $form->isValid()){

         $products= $productRepository->findByAttributes($category, $form->getData());

     }else {
         $products = $category->getProducts();
     }

     return $this -> render('categories/item.html.twig',[
         'category' => $category,
         'products' =>$products,
         'filterForm' => $form->createView(),
     ]);
 }

 public function getFilterForm(Category $category)
 {
     $formBuilder=$this->createFormBuilder();
     $formBuilder->setMethod('get');

     foreach ($category->getAttributes() as $attribute) {

         switch ($attribute->getType()){
             case Attribute::TYPE_INT:
         $formBuilder->add('attr_min_'. $attribute->getId(), NumberType::class, ['required'=>false]);
         $formBuilder->add('attr_max_'. $attribute->getId(), NumberType::class, ['required'=>false]);

         break;

         case Attribute::TYPE_LIST:
         $formBuilder->add('attr_min_'. $attribute->getId(), ChoiceType::class,[
             'multiple' =>true,
             'expanded'=>true,
             'choices'=> array_flip($attribute->getChoices()),
         ]);
         break;
     }}
     return $formBuilder->getForm();
 }


}















