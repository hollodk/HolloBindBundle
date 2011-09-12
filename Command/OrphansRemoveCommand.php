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
      ->setDescription('Remove orphans domains');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $lock_key = "ORPHANS_".php_uname('n');

    $lock = $this->getContainer()->get('hollo_bind.lock');

    if ($lock->isLock($lock_key)) {
      $output->writeln('<info>Process is already running.</info>');
      return;
    }

    $lock->createLock($lock_key);

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $bind = $this->getContainer()->get('hollo_bind.bind');

    exec('find '.$bind->getZonePath().' -type f', $zones);

    foreach ($zones as $zone) {
      $o = preg_split("/\//", $zone);
      $domain = array_pop($o);

      $r = $em->getRepository('HolloBindBundle:Domain')->findOneBy(array(
        'domain' => $domain
      ));

      if (!$r) {
        unlink($zone);
        $output->writeln('<info>'.$zone.' has been removed.</info>');
      }
    }

    $lock->removeLock($lock_key);
  }
}
