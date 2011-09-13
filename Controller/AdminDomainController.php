<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class AdminDomainController extends Controller
{
  /**
   * @Template()
   * @Route("/domain")
   */
  public function indexAction()
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domains = $em->getRepository('HolloBindBundle:Domain')->findBy(array(
      'type' => 'domain'
    ));

    return array(
      'domains' => $domains
    );
  }

  /**
   * @Template()
   * @Route("/domain/new")
   */
  public function newAction()
  {
    $domain = new \Hollo\BindBundle\Entity\Domain();
    $domain->setNs1($this->container->getParameter('hollo_bind.ns1'));
    $domain->setNs2($this->container->getParameter('hollo_bind.ns2'));
    $domain->setAddress('127.0.0.1');
    $domain->setType('domain');

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

        return $this->redirect($this->generateUrl('hollo_bind_admindomain_index'));
      }
    }

    return array(
      'form' => $form->createView()
    );
  }

  /**
   * @Template()
   * @Route("/domain/update/{id}")
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

        return $this->redirect($this->generateUrl('hollo_bind_admindomain_index'));
      }
    }

    return array(
      'domain' => $domain,
      'form' => $form->createView()
    );

  }

  /**
   * @Template()
   * @Route("/domain/delete/{id}")
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
    return $this->redirect($this->generateUrl('hollo_bind_admindomain_index'));
  }

  /**
   * @Template()
   * @Route("/domain/search")
   */
  public function searchAction()
  {
  }
}
