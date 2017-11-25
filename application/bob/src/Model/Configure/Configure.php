<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;

class Configure extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Configure\Configure::getInstance();
    }

    public function getGroup()
    {
        $cfgGroup = ConfigureGroup::getInstance();
        $groups = array();
        $result = $cfgGroup->getActive();
        foreach ($result as $rs) {
            $groups[$rs['id_configure_group']] = $rs;
        }
        return $groups;
    }

    protected function getCondByParentId($parentId)
    {
        if ($parentId) {
            return 'configure_group_id=' . (int) $parentId;
        }

        return '1';
    }

    public function update($data, $pkId = 0)
    {
        $data['configure']['cfg_data'] = serialize($data['configure']['setting']);
        unset($data['configure']['setting']);
        return parent::update($data['configure'], $pkId);
    }
    
    public function getByPkId($pkId)
    {
        $data = parent::getByPkId($pkId); 
        if ($data['cfg_data']) {
            $data['setting'] = unserialize($data['cfg_data']);
        }
        
        return $data;
    }
}