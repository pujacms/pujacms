<?php
namespace Puja\Bob\DbTable\Entity;

abstract class EntityMultiLnAbstract extends EntityAbstract
{
    protected $idConfigureLanguageDefault;
    public function __construct($tableName = null)
    {
        parent::__construct($tableName);
        $this->lnTable = $this->getLnTable();
    }

    public function setIdConfigureLanguageDefault($idConfigureLanguageDefault)
    {
        $this->idConfigureLanguageDefault = $idConfigureLanguageDefault;
    }

    abstract protected function getLnTable();

    protected function joinLn(\Puja\SqlBuilder\Builder $builder, $fkConfigureLanguage, $selectedCols = array('*'))
    {
        if (empty($this->idConfigureLanguageDefault)) {
            throw new \Exception('Must set $idConfigureLanguageDefault for EntityMultiLn object');
        }

        $builder->joinInner(
            array($this->lnTable->getShortTableName() => $this->lnTable->getTableName()),
            sprintf(
                '%s.%s=%s.%s AND %s.%s=%d',
                $this->shortTableName,
                $this->pkField,
                $this->lnTable->getShortTableName(),
                $this->lnTable->getPkField(),
                $this->lnTable->getShortTableName(),
                'fk_configure_language',
                $fkConfigureLanguage
            ),
            $selectedCols
        );

        return $builder;
    }

    public function getUnionQuery($recordType, $configureModuleId, $parentId = -1, $additionCond = null, $orderBy = null, $offset = 0, $limit = 0)
    {
        $select = parent::getUnionQuery($recordType, $configureModuleId, $parentId, $additionCond, $orderBy, $offset, $limit);
        return $this->joinLn($select, $this->idConfigureLanguageDefault, array('name'));
    }

    protected function getUnionFields($recordType)
    {
        $fields = parent::getUnionFields($recordType);
        unset($fields['name']);
        return $fields;
    }

    protected function getFindByCriteriaBuilder($criteria, $orderBy = null, $offset = 0, $limit = 0)
    {
        $select = parent::getFindByCriteriaBuilder($criteria, $orderBy, $offset, $limit);
        return $this->joinLn($select, $this->idConfigureLanguageDefault);
    }
}