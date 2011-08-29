<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ZoneController extends Controller
{
  /**
   * @Template()
   * @Route("/zone/{id}")
   */
  public function indexAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    return array(
      'domain' => $domain
    );
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
