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
      ->setDescription('Add zone to Bind');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
  }
}
