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
    $em = $this->getDoctrine()->getEntityManager();
    $record = $em->find('HolloBindBundle:Record', $id);

    $em->remove($record);
    $em->flush();

    $event = new \Hollo\BindBundle\Event\FilterRecordEvent($record);
    $this->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onRecordDel, $event);

    return $this->redirect($this->generateUrl('hollo_bind_zone_index', array('id' => $record->getDomain()->getId())));
  }
}
