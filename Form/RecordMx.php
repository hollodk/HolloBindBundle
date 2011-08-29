<?php

namespace Hollo\BindBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class RecordMx extends AbstractType
{
  public function buildForm(FormBuilder $builder, array $options)
  {
    $builder->add('address');
    $builder->add('priority');
  }

  public function getDefaultOptions(array $options)
  {
    return array(
      'data_class' => 'Hollo\BindBundle\Entity\Record'
    );
  }

  public function getName()
  {
    return 'record_mx';
  }
}

