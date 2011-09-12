<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:check')
      ->setDescription('Check environment');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $bind = $this->getContainer()->get('hollo_bind.bind');
    $errors = array();

    if (!file_exists($bind->getZonePath())) {
      $errors[] = 'Zone path does not exists.';
      $errors[] = '<comment>mkdir -p '.$bind->getZonePath().'</comment>';

    } elseif (!is_writeable($bind->getZonePath())) {
      $errors[] = 'Zone path is not writeable.';
      $errors[] = '<comment>chmod 740 '.$bind->getZonePath().'</comment>';
    }

    if (!file_exists($bind->getConfigPath())) {
      $errors[] = 'Config path does not exists.';
      $errors[] = '<comment>mkdir -p '.$bind->getConfigPath().'</comment>';

    } elseif (!file_exists($bind->getConfigPath().'/'.$bind->getConfigFile())) {
      $errors[] = 'Config file does not exists.';
      $errors[] = '<comment>touch '.$bind->getConfigPath().'/'.$bind->getConfigFile().'</comment>';

    } elseif (!is_writeable($bind->getConfigPath().'/'.$bind->getConfigFile())) {
      $errors[] = 'Config file is not writeable.';
      $errors[] = '<comment>chmod 740 '.$bind->getConfigPath().'/'.$bind->getConfigFile().'</comment>';
    }

    if (!file_exists($bind->getBindInit()))
      $errors[] = 'Init file not found.';

    // check init
    // exists

    if (count($errors)) {
      $output->writeln('<error>Your setup is not ready yet, validate the following:</error>');
      foreach ($errors as $error) {
        $output->writeln($error);
      }
    } else {
      $output->writeln('<info>Everything seems just fine :)</info>');
    }
  }
}
