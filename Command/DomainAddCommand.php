<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DomainAddCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:domain:add')
      ->setDescription('Add a new domain')
      ->setDefinition(array(
        new InputArgument('domain', InputArgument::REQUIRED, 'The domain'),
        new InputArgument('address', InputArgument::REQUIRED, 'The address'),
        new InputArgument('description', InputArgument::REQUIRED, 'The description'),
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $domain = new \Hollo\BindBundle\Entity\Domain();
    $domain->setDomain($input->getArgument('domain'));
    $domain->setAddress($input->getArgument('address'));
    $domain->setDescription($input->getArgument('description'));
    $domain->setNs1($this->getContainer()->getParameter('hollo_bind.ns1'));
    $domain->setNs2($this->getContainer()->getParameter('hollo_bind.ns2'));

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $em->persist($domain);
    $em->flush();

    $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
    $this->getContainer()->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainAdd, $event);

    $output->writeln(sprintf('Added domain <comment>%s</comment>', $domain->getDomain()));
  }
}
