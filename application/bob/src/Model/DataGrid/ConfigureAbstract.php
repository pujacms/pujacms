<?php
namespace Puja\Bob\Model\DataGrid;
use Puja\Bob\Middleware\Controller;
use Puja\Middleware\Exception\Exception;

abstract class ConfigureAbstract
{
    protected static $instance;
    protected $controller;
    protected $title;
    protected $url;
    protected $fields;
    protected $jsHandler;
    protected $toolbars;
    protected $events;
    protected $actions;

    abstract public function getTitle();
    abstract public function getUrl();
    abstract public function getFields();
    abstract public function getToolbars();
    abstract public function getEvents();
    abstract public function getJsHandler();
    abstract public function getActions();
    abstract public function getPkField();

    public static function getInstance(Controller $controller)
    {
        if (null == static::$instance) {
            static::$instance = new static($controller);
        }
        
        return static::$instance;
    }

    public function getIsCustomToobarIcons()
    {
        return false;
    }

    protected function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $this->setJsHandler($this->getJsHandler())
            ->setFields($this->getFields());
    }

    protected function setJsHandler($jsHandler)
    {
        $this->jsHandler = $jsHandler;
        return $this;
    }

    protected function setFields($fields)
    {
        if (empty($fields)) {
            throw new Exception('$fields must not empty');
        }
        $fieldWidth = round(80 / count($fields)) . '%';

        foreach ($fields as $key => $field) {
            if (is_string($field)) {
                $fields[$key] = array('title' => $field, 'options' => array('width' => $fieldWidth));
                continue;
            }

            if (!array_key_exists('title', $field)) {
                throw new Exception('Missing *title* in $field = ' . print_r($field, true));
            }
            $options = $field;
            unset($options['title']);
            if (!array_key_exists('width', $options)) {
                $options['width'] = $fieldWidth;
            }

            if (!empty($options['formatter'])) {
                $options['formatter'] = $this->jsHandler . '.formatter.' . $options['formatter'];
            }

            if (empty($options['resizable'])) {
                $options['resizable'] = false;
            }

            $fields[$key] = array('title' => $field['title'], 'options' => $options);
        }

        $this->fields = $fields;
        return $this;
    }

    public function getSimple()
    {
        return array(
            'title' => $this->getTitle(),
            'url' => $this->getUrl(),
            'fields' => $this->fields,
            'fieldWidth' => round(80 / count($this->fields)), // action column always take 20%
            'JsGrid' => $this->jsHandler,
            'toolbars' => $this->getToolbars(),
            'events' => $this->getEvents(),
            'IsCustomToolbarIcons' => $this->getIsCustomToobarIcons(),
        );
    }
}