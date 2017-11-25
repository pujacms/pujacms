<?php
namespace Puja\Bob\Model\AbstractLayer;

abstract class ModelAbstract extends BaseAbstract
{
    public static function getInstance()
    {
        if (empty(static::$modelName)) {
            return new static();
        }

        if (empty(static::$instances[static::$modelName])) {
            static::$instances[static::$modelName] = new static();
        }

        return static::$instances[static::$modelName];
    }

    


}