<?php

namespace Hollo\BindBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class RecordController extends Controller
{
  /**
   * @Template()
   * @Route("/record/new/{id}")
   */
  public function newAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $domain = $em->find('HolloBindBundle:Domain', $id);

    $record_a = new \Hollo\BindBundle\Entity\Record();
    $record_cname = new \Hollo\BindBundle\Entity\Record();
    $record_mx = new \Hollo\BindBundle\Entity\Record();

    $record_a->setAddress($domain->getAddress());
    $record_cname->setAddress($domain->getDomain());
    $record_mx->setPriority(10);

    $form_a = $this->createForm(new \Hollo\BindBundle\Form\RecordA(), $record_a);
    $form_cname = $this->createForm(new \Hollo\BindBundle\Form\RecordCname(), $record_cname);
    $form_mx = $this->createForm(new \Hollo\BindBundle\Form\RecordMx(), $record_mx);

    if ($this->getRequest()->getMethod() == 'POST') {
      if ($this->getRequest()->get($form_a->getName())) {
        $form_a->bindRequest($this->getRequest());

        if ($form_a->isValid()) {
          $record_a->setType('A');
          $record_a->setDomain($domain);
          $em->persist($record_a);
          $em->flush();

          $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record_a);
          $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordAdd, $event);
          $this->get('session')->setFlash('notice','Your data has been saved.');
          return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $domain->getId())));
        }
      }
      if ($this->getRequest()->get($form_cname->getName())) {
        $form_cname->bindRequest($this->getRequest());

        if ($form_cname->isValid()) {
          $record_cname->setType('CNAME');
          $record_cname->setDomain($domain);
          $em->persist($record_cname);
          $em->flush();

          $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record_cname);
          $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordAdd, $event);
          $this->get('session')->setFlash('notice','Your data has been saved.');
          return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $domain->getId())));
        }
      }
      if ($this->getRequest()->get($form_mx->getName())) {
        $form_mx->bindRequest($this->getRequest());

        if ($form_mx->isValid()) {
          $record_mx->setType('CNAME');
          $record_mx->setDomain($domain);
          $em->persist($record_mx);
          $em->flush();

          $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record_mx);
          $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordAdd, $event);
          $this->get('session')->setFlash('notice','Your data has been saved.');
          return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $domain->getId())));
        }
      }
    }

    return array(
      'domain' => $domain,
      'form_a' => $form_a->createView(),
      'form_cname' => $form_cname->createView(),
      'form_mx' => $form_mx->createView()
    );
  }

  /**
   * @Template()
   * @Route("/record/update/{id}")
   */
  public function updateAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $record = $em->find('HolloBindBundle:Record', $id);

    switch ($record->getType()) {
    case 'A':
      $form = $this->createForm(new \Hollo\BindBundle\Form\RecordA(), $record);
      break;
    case 'CNAME':
      $form = $this->createForm(new \Hollo\BindBundle\Form\RecordCname(), $record);
      break;
    case 'MX':
      $form = $this->createForm(new \Hollo\BindBundle\Form\RecordMx(), $record);
      break;
    }

    if ($this->getRequest()->getMethod() == 'POST') {
      $form->bindRequest($this->getRequest());

      if ($form->isValid()) {
        $em->persist($record);
        $em->flush();

        $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordAdd, $event);

        $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record);
        $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordMod, $event);

        $this->get('session')->setFlash('notice','Your data has been saved.');
        return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $record->getDomain()->getId())));
      }
    }

    return array(
      'record' => $record,
      'form' => $form->createView(),
    );
  }

  /**
   * @Template()
   * @Route("/record/delete/{id}")
   */
  public function deleteAction($id)
  {
    $em = $this->getDoctrine()->getEntityManager();
    $record = $em->find('HolloBindBundle:Record', $id);

    $em->remove($record);
    $em->flush();

    $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record);
    $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordDel, $event);

    return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $record->getDomain()->getId())));
  }
}
