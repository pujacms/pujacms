<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
use Puja\Configure\Configure;

class CmsTheme extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Configure\CmsTheme::getInstance();
    }

    public function update($data, $pkId = 0)
    {
        $this->updateByPkId(
            array(
                'name' => $data['name'],
                'theme_data' => empty($data['theme_data']) ? null : serialize($data['theme_data'])
            ),
            $pkId
        );
    }

    public function insert($data)
    {
        $this->getTable()->insert(
            array(
                'name' => $data['name'],
                'theme_data' => empty($data['theme_data']) ? null : serialize($data['theme_data'])
            )
        );
    }

    public function getByPkId($pkId)
    {
        $data = $this->getTable()->getByPkId($pkId);
        if (!empty($data['theme_data'])) {
            $data['theme_data'] = unserialize($data['theme_data']);
        } else {
            $data['theme_data'] = Configure::getInstance('application')->get('theme_data');
        }

        return $data;
    }
}