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
   * @Route("/zone/view/{id}")
   */
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    $bind = $this->get('hollo_bind.bind');
    $output = $bind->getZoneConfig($domain);

    return array(
      'domain' => $domain,
      'output' => $output
    );
  }

  /**
   * @Template()
   * @Route("/zone/update/{id}")
   */
  public function updateAction($id)
  {
  }

}
