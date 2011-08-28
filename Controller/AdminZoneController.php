<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminZoneController extends Controller
{
  /**
   * @Template()
   * @Route("/zone")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domains = $em->getRepository('HolloBindBundle:Domain')->findAll();

    return array(
      'domains' => $domains
    );
  }

  /**
   * @Template()
   * @Route("/zone/new")
   */
  public function newAction()
  {
    $queue = new \Hollo\BindBundle\Entity\AddQueue();
    $form = $this->createForm(new \Hollo\BindBundle\Form\Zone(), $queue);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($queue);
        $em->flush();

        $this->get('session')->setFlash('notice','Your data has been saved.');

        return $this->redirect($this->generateUrl('hollo_bind_adminzone_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
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

  /**
   * @Template()
   * @Route("/zone/search")
   */
  public function searchAction()
  {
  }
}
