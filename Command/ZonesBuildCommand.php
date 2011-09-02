<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ZonesBuildCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:zones:build')
      ->setDescription('Build zones');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $bind = $this->getContainer()->get('hollo_bind.bind');
    $bind->buildZones();
  }
}
