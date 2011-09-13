<?php

namespace Hollo\BindBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PTR extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('domain');
    $builder->add('description');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Hollo\BindBundle\Entity\Domain'
    );
  }

  public function getName()
  {
    return 'ptr';
  }
}

