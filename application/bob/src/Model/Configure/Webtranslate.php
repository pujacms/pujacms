<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
class Webtranslate extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected static $modelName = 'Webtranslate';
    protected function getTable()
    {
        return DbTable\Configure\Webtranslate::getInstance();
    }

    protected function getTableLn()
    {
        return DbTable\Configure\WebtranslateLn::getInstance();
    }

    protected function getCondByQuery($query = null)
    {
        if (empty($query)) {
            return '1';
        }

        return $this->table->getShortTableName() . '.translate_key LIKE "%' . $query . '%"';
    }

    public function getEntityByPkId($pkId)
    {
        $data = array(
            'mainEntity' => $this->table->getByPkId($pkId),
        );

        $translateLanguages = array();
        $result = $this->getTableLn()->getByPkId($pkId);
        foreach ($result as $row) {
            $translateLanguages[$row['fk_configure_language']] = $row;
        }

        $languages = Language::getInstance()->getActive();
        foreach ($languages as $key => $language) {
            if (empty($translateLanguages[$language['id_configure_language']])) {
                continue;
            }
            $language['fields'] = $translateLanguages[$language['id_configure_language']];
            $languages[$key] = $language;
        }

        $data['lnEntity'] = $languages;
        return $data;
    }

    public function updateEntityByPkId($pkId, $mainEntity, $lnEntity)
    {
        if ($pkId) {
            $this->table->updateByPkId($mainEntity, $pkId);
        } else {
            $pkId = $this->table->insert($mainEntity);
        }

        $this->getTableLn()->deleteByPkId($pkId);
        foreach ($lnEntity as $idConfigureLanguage => $row) {
            $row[$this->getTableLn()->getPkField()] = $pkId;
            $row['fk_configure_language'] = $idConfigureLanguage;
            $this->getTableLn()->insert($row);
        }
    }

    public function importEntityToAlice()
    {
        $translateKeys = array();
        $result = $this->table->getAll();
        foreach ($result as $row) {
            $translateKeys[$row[$this->table->getPkField()]] = $row['translate_key'];
        }

        $translateValues = array();
        $result = $this->getTableLn()->getAll();
        foreach ($result as $row) {
            if (empty($translateKeys[$row[$this->getTableLn()->getPkField()]])) {
                continue;
            }

            $translateKey = $translateKeys[$row[$this->getTableLn()->getPkField()]];
            $translateValues[$row['fk_configure_language']][$translateKey] = $row['translate_value'] == '' ? $translateKey : $row['translate_value'];
        }

        $languages = Language::getInstance()->getActive();
        foreach ($languages as $language) {
            if (empty($translateValues[$language['id_configure_language']])) {
                continue;
            }

            $file = new \Puja\Stdlib\File\File(
                \Puja\Configure\Configure::getInstance()->get('alice_cache_dir') . 'i18n_' . $language['locale'] . '.php',
                'w'
            );

            $file->fwrite('<?php return ' . var_export($translateValues[$language['id_configure_language']], true) . ';');
        }

        return true;
    }
}