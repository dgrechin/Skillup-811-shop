<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 16.01.19
 * Time: 21:16
 */

namespace App\Admin;


use function Sodium\add;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class CategoryAdmin extends AbstractAdmin
{
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
         ->add('name');
    }

    protected function configureFormFields(FormMapper $form)
    {
        $form
             ->add('name');
    }

}