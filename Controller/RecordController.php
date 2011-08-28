<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class RecordController extends Controller
{
  /**
   * @Template()
   * @Route("/zone/new")
   */
  public function newAction()
  {
  }

  /**
   * @Template()
   * @Route("/zone/update/{id}")
   */
  public function updateAction($id)
  {
  }

  /**
   * @Template()
   * @Route("/zone/delete/{id}")
   */
  public function deleteAction($id)
  {
  }
}
