<?php

namespace Hollo\BindBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class AddQueue extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('domain');
    $builder->add('address');
    $builder->add('password');
    $builder->add('ns1');
    $builder->add('ns2');
    $builder->add('description');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Hollo\BindBundle\Entity\AddQueue'
    );
  }

  public function getName()
  {
    return 'zone';
  }
}

