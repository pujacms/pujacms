<?php
namespace Puja\Bob\Model\Entity\Processor\DynamicOption;
use Puja\Bob\Model\Entity\Processor\ProcessorAbstract;

abstract class DynamicOptionAbstract extends ProcessorAbstract
{
    abstract public function getData($options);
}