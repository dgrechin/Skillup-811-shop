<?php



namespace App\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;

class FeedbackRequestAdmin extends AbstractAdmin

{
    protected function configureListFields(ListMapper $list)
    {
        $list
            -> addIdentifier('id')
            -> addIdentifier('name')
            -> addIdentifier('email')
            -> addIdentifier('message')
            -> addIdentifier('createAt');
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('id')
            ->add('email');
    }
    protected function configureFormFields(FormMapper $form)
    {
        $form
            -> add('name')
            -> add('message')
            -> add('email');

    }

}