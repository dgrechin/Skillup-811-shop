<?php

namespace App\Admin;



use App\Entity\Product;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use function Sodium\add;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
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
        $form
            -> add('name')
            -> add('description')
            -> add('price')
            -> add('category')
            -> add('isTop' )
            -> add('image',VichImageType::class, [
                    'required'=>false,
                    'image_uri' => function (Product $product, $resolveUri) use($cacheManager){
                        return $cacheManager->getBrowserPath($resolveUri, 'squared_thumbnail');
                    }]
            );

    }


}