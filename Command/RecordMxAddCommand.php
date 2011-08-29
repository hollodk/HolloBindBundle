<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RecordMxAddCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:record:mx:add')
      ->setDescription('Add an MX record.')
      ->setDefinition(array(
        new InputArgument('domain', InputArgument::REQUIRED, 'The domain'),
        new InputArgument('address', InputArgument::REQUIRED, 'The address'),
        new InputArgument('priority', InputArgument::REQUIRED, 'The priority'),
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $domain = $input->getArgument('domain');
    $address = $input->getArgument('address');
    $priority = $input->getArgument('priority');

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $domain = $em->getRepository('HolloBindBundle:Domain')->findOneBy(array(
      'domain' => $domain
    ));

    $record = new \Hollo\BindBundle\Entity\Record();
    $record->setDomain($domain);
    $record->setAddress($address);
    $record->setType('MX');
    $record->setPriority($priority);

    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($domain);
    $queue->setType('modified');

    $em->persist($record);
    $em->persist($queue);
    $em->flush();

    $output->writeln(sprintf('Added MX record for <comment>%s</comment>', $domain->getDomain()));
  }
}
