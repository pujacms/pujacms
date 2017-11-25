<?php
namespace Puja\Bob\Model\DataGrid\Entity;

abstract class ConfigureAbstract extends \Puja\Bob\Model\DataGrid\ConfigureAbstract
{
    /**
     * @var \Puja\Bob\Controller\DataGrid\Entity\DataGridAbstract
     */
    protected $controller;

    public function getTitle()
    {
        return null;
    }

    public function getToolbars()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        $catLevel = count($this->controller->getParents());
        
        $acts = array();
        $actContent = $this->getContentToolbar($cfgModule, $catLevel);
        if ($actContent) {
            $acts[] = $actContent;
        }

        $actCategory = $this->getCategoryToolbar($cfgModule, $catLevel);
        if ($actCategory) {
            $acts[] = $actCategory;
        }

        return $acts;
    }

    protected function getContentToolbar($cfgModule, $catLevel)
    {
        $act = array('name' => 'New Item', 'icon' => 'tree-file', 'fn' => 'addContent');

        if (empty($cfgModule['cfg_data']['content']['actions']['new'])) {
            return null;
        }


        if (!empty($cfgModule['cfg_data']['category'])) {
            if ($cfgModule['cfg_data']['category']['limitation']['nonew_content_in_category_levels'] != '-1') {
                $levels = explode(',', $cfgModule['cfg_data']['category']['limitation']['nonew_content_in_category_levels']);
                if (in_array($catLevel, $levels)) {
                    return null;
                }
            }

            if ($cfgModule['cfg_data']['category']['limitation']['nonew_content_in_category_ids'] != '-1') {
                $catIds = explode(',', $cfgModule['cfg_data']['category']['limitation']['nonew_content_in_category_ids']);
                if (in_array($this->controller->getParentId(), $catIds)) {
                    return null;
                }
            }
        }

        return $act;

    }

    protected function getCategoryToolbar($cfgModule, $catLevel)
    {
        $act = array('name' => 'New Category', 'icon' => 'tree-folder', 'fn' => 'addCategory');

        if (empty($cfgModule['cfg_data']['category']['actions']['new'])) {
            return null;
        }

        if (!empty($cfgModule['cfg_data']['category'])) {
            //category limitations
            if ($cfgModule['cfg_data']['category']['limitation']['max_level'] != '-1' && $catLevel >= $cfgModule['cfg_data']['category']['limitation']['max_level']) {
                return null;
            }
        }

        return $act;

    }

    public function getEvents()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        if (empty($cfgModule['cfg_data']['dragdrop'])) {
            return array();
        }

        return array('onLoadSuccess' => 'onLoadSuccess', 'onDrop' => 'onDrop');
    }

    public function getJsHandler()
    {
        return 'Puja.Entity.Grid';
    }

    public function getPkField()
    {
        return 'pkid';
    }

    public function getActions()
    {
        // built in datasource
        return null;
    }

    public function isEnableDnd()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        return !empty($cfgModule['cfg_data']['dragdrop']);
    }

    public function getSearchBox()
    {
        $cfgModule = $this->controller->getCurrentCfgModule();
        return array(
            'enabled' => !empty($cfgModule['cfg_data']['searchbox']),
        );
    }

    public function getUrl()
    {
        return './?module=' . $this->controller->getModuleId() .
        '&ctrl=' . $this->controller->getControllerId() .
        '&act=list&parentid=' . $this->controller->getParam('parentid', 0) .
        '&typeid=' . $this->controller->getParam('typeid', 0);
    }

    public function getFields()
    {
        $fields =  array(
            'name' => array('title' => 'Name', 'formatter' => 'name', 'width' => '30%', 'resizable' => true, 'sortable' => true),
            'created_at' => array('title' => 'Created At', 'width' => '10%', 'align' => 'center', 'resizable' => true, 'sortable' => true),
            'status' => array('title' => 'Status', 'formatter' => 'status', 'align' => 'center', 'width' => '5%', 'resizable' => true, 'sortable' => true),
        );

        if ($this->isEnableDnd()) {
            $fields['order_id'] = array('title' => 'Sort#', 'align' => 'center', 'width' => '5%', 'resizable' => true, 'sortable' => true);
        }

        return $fields;
    }

    public function getIsCustomToobarIcons()
    {
        return true;
    }

    public function getSimple()
    {
        $grid = parent::getSimple();
        $grid['enabledDnd'] = $this->isEnableDnd();
        $grid['searchbox'] = $this->getSearchBox();
        return $grid;
    }
}