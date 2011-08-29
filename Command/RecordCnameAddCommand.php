<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RecordCnameAddCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:record:cname:add')
      ->setDescription('Add an CNAME record.')
      ->setDefinition(array(
        new InputArgument('name', InputArgument::REQUIRED, 'The name'),
        new InputArgument('domain', InputArgument::REQUIRED, 'The domain'),
        new InputArgument('address', InputArgument::REQUIRED, 'The address'),
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $name = $input->getArgument('name');
    $domain = $input->getArgument('domain');
    $address = $input->getArgument('address');

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $domain = $em->getRepository('HolloBindBundle:Domain')->findOneBy(array(
      'domain' => $domain
    ));

    $record = new \Hollo\BindBundle\Entity\Record();
    $record->setDomain($domain);
    $record->setName($name);
    $record->setAddress($address);
    $record->setType('CNAME');

    $queue = new \Hollo\BindBundle\Entity\ModQueue();
    $queue->setDomain($domain);
    $queue->setType('modified');

    $em->persist($record);
    $em->persist($queue);
    $em->flush();

    $output->writeln(sprintf('Added record <comment>%s</comment>', $name.'.'.$domain->getDomain()));
  }
}
