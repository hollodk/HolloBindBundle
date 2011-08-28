<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ZoneController extends Controller
{
  /**
   * @Template()
   * @Route("/zone")
   */
  public function indexAction()
  {
  }

  /**
   * @Template()
   * @Route("/zone/view")
   */
  public function viewAction()
  {
  }

  /**
   * @Template()
   * @Route("/zone/update/{id}")
   */
  public function updateAction($id)
  {
  }

}
