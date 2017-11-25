<?php
namespace Puja\Bob\Model\DataGrid\Entity;

abstract class DataSourceAbstract
{
    /**
     * @var \Puja\Bob\DbTable\Entity\EntityAbstract
     */
    protected $contentTable;

    /**
     * @var \Puja\Bob\DbTable\Entity\EntityAbstract
     */
    protected $categoryTable;

    protected $idConfigureModule;
    protected $idConfigureLanguage;
    protected $cfgModule;

    abstract protected function getContentTable();
    abstract protected function getCategoryTable();

    public static function getInstance($idConfigureModule, $cfgModule = null, $idConfigureLanguage = null)
    {
        return new static($idConfigureModule, $cfgModule, $idConfigureLanguage);
    }

    public function __construct($idConfigureModule, $cfgModule, $idConfigureLanguage)
    {
        $this->idConfigureModule = $idConfigureModule;
        $this->cfgModule = $cfgModule;
        $this->idConfigureLanguage = $idConfigureLanguage;

        if (empty($this->cfgModule)) {
            $this->cfgModule = \Puja\Bob\Model\Configure\Module::getInstance()->getById($idConfigureModule);
        }

        $this->contentTable = $this->getContentTable();
        $this->categoryTable = $this->getCategoryTable();
    }

    public function getList($parentId = 0, $query = null, $orderBy = 'order_id', $page = 0, $limit = 0)
    {
        $queryData = $this->getListQuery($parentId, $query, $orderBy, $page, $limit);


        $actions = array(
            'content' => empty($this->cfgModule['cfg_data']['content']['actions']) ? null : $this->cfgModule['cfg_data']['content']['actions'],
            'category' => empty($this->cfgModule['cfg_data']['category']['actions']) ? null : $this->cfgModule['cfg_data']['category']['actions'],
        );

        $adapter = \Puja\Bob\DbTable\TableAbstract\TableAbstract::getAdapter();

        $result = $adapter->query($queryData['unionQuery']);
        $rows = array();
        while ($rs = $result->fetch()) {
            $rs['actions'] = $actions[$rs['recordType']];
            $rows[] = $rs;
        }

        $total = 0;
        $countContent = $adapter->query($queryData['totalContentQuery'])->fetch();
        $total += $countContent['total'];

        if ($queryData['totalCategoryQuery']) {
            $countCategory = $adapter->query($queryData['totalCategoryQuery'])->fetch();
            $total += $countCategory['total'];
        }


        return array(
            'total' => $total,
            'rows' => $rows
        );
    }

    protected function getSearchFields(\Puja\Bob\DbTable\Entity\EntityAbstract $table, $recordType, $query)
    {
        if (empty($query)) {
            return '1=1';
        }

        $query = addslashes($query);
        $conds = array();
        if (!empty($this->cfgModule['cfg_data'][$recordType]['main_fields'])) {
            foreach ($this->cfgModule['cfg_data'][$recordType]['main_fields'] as $field => $fieldData) {
                if (!empty($fieldData['is_search'])) {
                    $conds[] = $table->getShortTableName() . '.' . $field . ' LIKE "%' . $query . '%"';
                }
            }
        }

        if (!empty($this->cfgModule['cfg_data'][$recordType]['ln_fields'])) {
            foreach ($this->cfgModule['cfg_data'][$recordType]['ln_fields'] as $field => $fieldData) {
                if (!empty($fieldData['is_search'])) {
                    $conds[] = $table->getShortTableName() . '_ln.' . $field . ' LIKE "%' . $query . '%"';
                }
            }
        }
        return $conds ? implode(' OR ', $conds) : '1=0';
    }

    protected function getListQuery($parentId = 0, $query = null, $orderBy = 'order_id', $page = 0, $limit = 0)
    {
        $cond = null;
        $result = array(
            'unionQuery' => null,
            'totalContentQuery' => null,
            'totalCategoryQuery' => null,
        );


        $contentCond = null;
        $categoryCond = null;
        if ($query) {
            $parentId = -1;
        }

        $contentCond = $this->getSearchFields($this->contentTable, 'content', $query);
        $contentUnion = $this->contentTable->getUnionQuery('content', $this->idConfigureModule, $parentId, $contentCond, $orderBy, $page, $limit);
        $result['totalContentQuery'] = $contentUnion->getCount();
        if (empty($this->categoryTable)) {
            $query = $contentUnion->getQuery();
        } else {
            $categoryCond = $this->getSearchFields($this->categoryTable, 'category', $query);
            $categoryUnion = $this->categoryTable->getUnionQuery('category', $this->idConfigureModule, $parentId, $categoryCond, $orderBy, $page, $limit);
            $query = $categoryUnion->getQuery() . ' UNION ' . $contentUnion->getQuery();
            $result['totalCategoryQuery'] = $categoryUnion->getCount();
        }

        $query .= ' ORDER BY recordType, ' . $orderBy . sprintf(' LIMIT %d, %d', $page * $limit, $limit);
        $result['unionQuery'] = $query;

        return $result;
    }
}