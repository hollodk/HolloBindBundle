<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminPTRController extends Controller
{
  /**
   * @Template()
   * @Route("/ptr")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domains = $em->getRepository('HolloBindBundle:Domain')->findBy(array(
      'type' => 'ptr'
    ));

    return array(
      'domains' => $domains
    );
  }

  /**
   * @Template()
   * @Route("/ptr/new")
   */
  public function newAction()
  {
    $domain = new \Hollo\BindBundle\Entity\Domain();
    $domain->setDomain('0.168.192.in-addr.arpa');
    $domain->setNs1($this->container->getParameter('hollo_bind.ns1'));
    $domain->setNs2($this->container->getParameter('hollo_bind.ns2'));
    $domain->setType('ptr');

    $form = $this->createForm(new \Hollo\BindBundle\Form\PTR(), $domain);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($domain);
        $em->flush();

        $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainAdd, $event);

        $this->get('session')->setFlash('notice','Your data has been saved.');

        return $this->redirect($this->generateUrl('hollo_bind_adminptr_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Template()
   * @Route("/ptr/update/{id}")
   */
  public function updateAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();

    $domain = $em->find('HolloBindBundle:Domain', $id);
    $form = $this->createForm(new \Hollo\BindBundle\Form\PTR(), $domain);

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($domain);
        $em->flush();

        $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainMod, $event);

        $this->get('session')->setFlash('notice','Your data has been saved.');

        return $this->redirect($this->generateUrl('hollo_bind_adminptr_index'));
      }
    }

    return array(
      'domain' => $domain,
      'form' => $form->createView()
    );

  }

  /**
   * @Template()
   * @Route("/ptr/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    $em->remove($domain);
    $em->flush();

    $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
    $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainDel, $event);

    $this->get('session')->setFlash('notice','Domain has been deleted.');
    return $this->redirect($this->generateUrl('hollo_bind_adminptr_index'));
  }

  /**
   * @Template()
   * @Route("/ptr/search")
   */
  public function searchAction()
  {
  }
}
