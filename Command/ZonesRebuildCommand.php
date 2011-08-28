<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ZonesRebuildCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:zones:rebuild')
      ->setDescription('Rebuild zones');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
  }
}
