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
      'name' => $this->translator->trans('Domains'),
      'route' => $this->router->generate('hollo_bind_admindomain_index'),
      'items' => array()
    );
    $menu['ptr_view'] = array(
      'name' => $this->translator->trans('PTR'),
      'route' => $this->router->generate('hollo_bind_adminptr_index'),
      'items' => array()
    );

    $event->setMenu($menu);
  }
}
