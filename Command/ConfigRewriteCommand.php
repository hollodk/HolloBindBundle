<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ConfigRewriteCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:config:rewrite')
      ->setDescription('Rewrite bind config');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
  }
}
