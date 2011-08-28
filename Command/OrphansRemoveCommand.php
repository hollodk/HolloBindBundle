<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class OrphansRemoveCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:orphans:remove')
      ->setDescription('Remove orphans zones');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
  }
}
