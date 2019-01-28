<?php

namespace App\Admin;



use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ProductAdmin extends AbstractAdmin
{
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
        $form
            -> add('name')
            -> add('description')
            -> add('price')
            -> add('category')
            -> add('isTop' );

    }


}