<?php
namespace Puja\Library\Queue\Provider;

interface ProviderInterface
{
    public function add(\Puja\Library\Queue\Entity\Queue $queue);
    public function process();
}