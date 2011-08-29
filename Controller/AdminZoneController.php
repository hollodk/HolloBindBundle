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
    $domain = new \Hollo\BindBundle\Entity\Domain();
    $form = $this->createForm(new \Hollo\BindBundle\Form\Domain(), $domain);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($domain);
        $em->flush();

        $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainAdd, $event);

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
    $em = $this->getDoctrine()->getEntityManager();

    $domain = $em->find('HolloBindBundle:Domain', $id);
    $form = $this->createForm(new \Hollo\BindBundle\Form\Domain(), $domain);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($domain);
        $em->flush();

        $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainMod, $event);

        $this->get('session')->setFlash('notice','Your data has been saved.');

        return $this->redirect($this->generateUrl('hollo_bind_adminzone_index'));
      }
    }

    return array(
      'domain' => $domain,
      'form' => $form->createView()
    );

  }

  /**
   * @Template()
   * @Route("/zone/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    $em->remove($domain);
    $em->flush();

    $this->get('session')->setFlash('notice','Domain has been deleted.');
    return $this->redirect($this->generateUrl('hollo_bind_adminzone_index'));
  }

  /**
   * @Template()
   * @Route("/zone/search")
   */
  public function searchAction()
  {
  }
}
