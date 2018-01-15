<?php
namespace Puja\Library\Queue;

use Puja\Configure\Configure;

class Queue
{
    /**
     * @var \Puja\Library\Queue\Provider\ProviderInterface
     */
    protected $queue;
    public function __construct()
    {
        $clsName = Configure::getInstance('queue')->get('class');
        if (!($clsName instanceof \Puja\Library\Queue\Provider\ProviderInterface)) {
            throw new \Exception($clsName . ' must be instance of \\Puja\\Library\\Queue\\Provider\\ProviderInterface');
        }

        $this->queue = new $clsName;

    }

    public function add(Entity\Queue $queue)
    {
        return $this->add($queue);
    }

    public function process()
    {
        return $this->process();
    }
}