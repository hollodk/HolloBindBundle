<?php

namespace Hollo\BindBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DigCommand extends ContainerAwareCommand
{
  protected function configure()
  {
    $this
      ->setName('bind:dig')
      ->setDescription('Dig all records from nameserver')
      ->setDefinition(array(
        new InputArgument('domain', InputArgument::REQUIRED, 'The domain'),
        new InputArgument('ns', InputArgument::REQUIRED, 'The nameserver')
      ));
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $zone = $this->dig($input->getArgument('ns'), $input->getArgument('domain'));

    $em = $this->getContainer()->get('doctrine.orm.entity_manager');
    $domain = $em->getRepository('HolloBindBundle:Domain')->findOneBy(array(
      'domain' => $zone['domain']
    ));

    if (!$domain) {
      $domain = $this->buildDomain($zone);
      $em->persist($domain);
      $em->flush();

      $event = new \Hollo\BindBundle\Event\FilterDomainEvent($domain);
      $this->getContainer()->get('event_dispatcher')->dispatch(\Hollo\BindBundle\Event\Events::onDomainAdd, $event);
    }
  }

  private function buildDomain($zone)
  {
    $domain = new \Hollo\BindBundle\Entity\Domain;
    $domain->setDomain($zone['domain']);
    $domain->setDescription('Migrated');

    if (preg_match("/arpa$/", $zone['domain'])) {
      $domain->setType('ptr');
    } else {
      $domain->setType('domain');
    }

    return $domain;
  }

  private function dig($nameserver, $domain)
  {
    exec('dig @'.$nameserver.' '.$domain.' axfr', $o);

    $zone = array();
    $zone['domain'] = $domain;
    foreach ($o as $line) {
      $record = null;

      if (!preg_match("/^;/", $line) && !preg_match("/^$/", $line)) {
        $line = preg_replace("/\t+/", " ", $line);
        $line = preg_replace("/\s+/", " ", $line);

        $res = preg_split("/\s/", $line);
        $name = $res[0];
        $ttl = $res[1];
        $type = $res[3];

        if (!isset($zone[$type]))
          $zone[$type] = array();

        switch ($type) {
        case 'SOA':
          $record = array(
            'name' => $name,
            'ttl' => $ttl,
            'primary_name_server' => $res[4],
            'hostmaster_email' => $res[5],
            'serial_number' => $res[6],
            'time_to_refresh' => $res[7],
            'time_to_retry' => $res[8],
            'time_to_expire' => $res[9],
            'minimum_ttl' => $res[10]
          );
          break;
        case 'MX':
          $record = array(
            'name' => $name,
            'ttl' => $ttl,
            'priority' => $res[4],
            'destination' => $res[5]
          );
          break;
        case 'A':
        case 'CNAME':
        case 'NS':
          $record = array(
            'name' => $name,
            'ttl' => $ttl,
            'destination' => $res[4]
          );
          break;
        case 'PTR':
          $record = array(
            'name' => $name,
            'ttl' => $ttl,
            'destination' => $res[4]
          );
          break;
        }

        if (isset($record))
          $zone[$type][] = $record;
      }
    }

    return $zone;
  }
}
