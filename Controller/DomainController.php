<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DomainController extends Controller
{
  /**
   * @Template()
   * @Route("/domain/{id}")
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
   * @Route("/domain/view/{id}")
   */
  public function viewAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    $bind = $this->get('hollo_bind.bind');
    $output = $bind->getDomainConfig($domain);

    return array(
      'domain' => $domain,
      'output' => $output
    );
  }

  /**
   * @Template()
   * @Route("/domain/update/{id}")
   */
  public function updateAction($id)
  {
  }

}
