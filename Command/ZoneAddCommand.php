<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ZoneAddCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:zone:add')
      ->setDescription('Add a new zone.')
      ->setDefinition(array(
        new InputArgument('domain', InputArgument::REQUIRED, 'The domain'),
        new InputArgument('address', InputArgument::REQUIRED, 'The address'),
        new InputArgument('password', InputArgument::REQUIRED, 'The password'),
        new InputArgument('description', InputArgument::REQUIRED, 'The description'),
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $domain = $input->getArgument('domain');
    $address = $input->getArgument('address');
    $password = $input->getArgument('password');
    $description = $input->getArgument('description');

    $queue = new \Hollo\BindBundle\Entity\AddQueue();
    $queue->setDomain($domain);
    $queue->setAddress($address);
    $queue->setPassword($password);
    $queue->setDescription($description);
    $queue->setNs1('ns1.hollo.dk');
    $queue->setNs2('ns2.hollo.dk');

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $em->persist($queue);
    $em->flush();

    $output->writeln(sprintf('Added zone <comment>%s</comment>', $domain));
  }
}
