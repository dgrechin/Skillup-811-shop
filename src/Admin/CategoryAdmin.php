<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 16.01.19
 * Time: 21:16
 */

namespace App\Admin;


use App\Entity\Category;
use function Sodium\add;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;



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
        $form
             ->add('name')
             ->add('image', VichImageType::class, [
                     'required'=>false,
                     'image_uri' => function (Category $category, $resolveUri) use($cacheManager){
                         return $cacheManager->getBrowserPath($resolveUri, 'squared_thumbnail');
                     }]
             );
    }

}