<?php

namespace App\Admin;



use App\Entity\Product;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductAdmin extends AbstractAdmin
{
    /**
     * @var CacheManager
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
            -> addIdentifier('id')
            -> addIdentifier('description')
            -> addIdentifier('price')
            -> addIdentifier('category');

    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            -> add('id')
            -> add('name')
            -> add('description')
            -> add('price');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $cacheManager = $this->cacheManager;

        if($this->isCurrentRoute('attributes'))
        {
            $form
            ->add('attributeValues');
        }
        else{


        $form
            -> add('name')
            -> add('description')
            -> add('price')
            -> add('category')
            -> add('isTop' )
            -> add('image',VichImageType::class, [
                    'required'=>false,
                    'image_uri' => function (Product $product, $resolveUri) use($cacheManager){
                        if (!$resolveUri)
                        { return null;}
                        return $cacheManager->getBrowserPath($resolveUri, 'squared_thumbnail');
                    }]
            );

    }}

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('attributes', $this->getRouterIdParameter(). '/attributes', [
            '_controller' => $this->getBaseControllerName(). ':editAction',
        ]);
    }


}