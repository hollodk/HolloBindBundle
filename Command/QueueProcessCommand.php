<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QueueProcessCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:queue:process')
      ->setDescription('Process Queue');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    // create lock
    // processmodqueue
    // processaddqueue
    // processdelqueue
    // remove lock
  }
}
