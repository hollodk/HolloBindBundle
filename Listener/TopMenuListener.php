<?php

namespace Hollo\BindBundle\Listener;

class TopMenuListener
{
  private $router;
  private $security_context;
  private $translator;

  public function __construct($router, $security_context, $translator)
  {
    $this->router = $router;
    $this->security_context = $security_context;
    $this->translator = $translator;
  }

  public function onTopMenuRender(\Hollo\MenuBundle\Event\FilterMenuEvent $event)
  {
    $menu = $event->getMenu();

    $menu['view'] = array(
      'name' => $this->translator->trans('View domains'),
      'route' => $this->router->generate('hollo_bind_admindomain_index'),
      'items' => array()
    );
    $menu['new'] = array(
      'name' => $this->translator->trans('New domain'),
      'route' => $this->router->generate('hollo_bind_admindomain_new'),
      'items' => array()
    );

    $event->setMenu($menu);
  }
}
