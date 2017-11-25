<?php
namespace Puja\Bob\DbTable\Configure;

class Module extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    protected $tableName = 'configure_module';
    protected $pkField = 'id_configure_module';
    protected static $instanceName = 'configuremodule';

    public function getMaxTypeId($moduleType)
    {
        $adapter = self::getAdapter();
        $select = $adapter->select()
            ->from($this->getTableName(), array('mx__exact' => 'MAX(type_id)'))
            ->where('fk_module_type=%d', $moduleType);

        $result = $adapter->query($select);
        $data = $result->fetch();
        return $data['mx'];
    }
}