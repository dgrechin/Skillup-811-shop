<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 16.01.19
 * Time: 21:16
 */

namespace App\Admin;


use App\Entity\Category;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\Form\Type\CollectionType;
use Sonata\AdminBundle\Route\RouteCollection;


class CategoryAdmin extends AbstractAdmin

{
    /**
     * @property  cacheManager
     */
    private $cacheManager;

    public function __construct(string $code, string $class, string $baseControllerName, CacheManager $cacheManager)
    {
        parent::__construct($code, $class, $baseControllerName);

        $this->cacheManager = $cacheManager;
    }
    protected function configureListFields(ListMapper $list)
    {
        $list
            -> addIdentifier('name')
            -> addIdentifier('id');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
         -> add('id')
         -> add('name');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $cacheManager = $this->cacheManager;
        if($this->isCurrentRoute('attributes'))
        {
            $form
                ->add('name')
                ->add('attributes',
                    CollectionType::class ,[
                        'by_reference' => false
                    ],
                    [
                        'edit' => 'inline',
                        'inline' => 'table',
                    ]);
        }else {
        $form
             ->add('name')
             ->add('image', VichImageType::class, [
                     'required'=>false,
                     'image_uri' => function (Category $category, $resolveUri) use($cacheManager){
                         if (!$resolveUri)
                         { return null;}
                         return $cacheManager->getBrowserPath($resolveUri, 'squared_thumbnail');
                     }]
             )
            ->add('attributes');
    }
    }protected function configureRoutes(RouteCollection $collection)
{
    $collection->add('attributes', $this->getRouterIdParameter(). '/attributes', [
        '_controller' => $this->getBaseControllerName(). ':editAction',
    ]);
}

}