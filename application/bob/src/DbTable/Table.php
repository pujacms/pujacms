<?php
namespace Puja\Bob\DbTable;

class Table extends \Puja\Bob\DbTable\TableAbstract\TableAbstract
{
    public function getSchema()
    {
        $adapter = self::getAdapter();
        return $adapter->query("SHOW FULL FIELDS FROM " . $this->tableName . " WHERE SUBSTR(Comment,1,6) != 'system'");
    }

    public function addField($fieldName, $fieldType, $fieldLength, $fieldDefault = null)
    {
        $adapter = self::getAdapter();
        $sql = sprintf('ALTER TABLE `%s` ADD COLUMN `%s` %s', $this->getTableName(), $fieldName, $fieldType);
        if ($fieldLength) {
            $sql .= '(' . $fieldLength . ')';
        }
        if ($fieldDefault) {
            $sql .= ' DEFAULT ' . $fieldDefault;
        }

        return $adapter->query($sql);
    }

    public function createCustomizeTable($pkField, $parentField) {
        $adapter = self::getAdapter();
        $sql = sprintf('CREATE TABLE `%s` (
              `%s` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT "system",
              `fk_configure_module` int(3) NOT NULL COMMENT "system",
              `%s` int(10) NOT NULL COMMENT "system",
              `name` VARCHAR(255) NULL,
              `order_id` int(10) NOT NULL COMMENT "system",
              `status` tinyint(1) DEFAULT NULL COMMENT "system",
              `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP  COMMENT "system",
              `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP  COMMENT "system",
              PRIMARY KEY (`%s`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;', $this->getTableName(), $pkField, $parentField, $pkField);

        return $adapter->query($sql);
    }

    public function createCustomizeLinkCategoryTable($fkField, $fkCatField)
    {
        $adapter = self::getAdapter();
        $sql = sprintf('CREATE TABLE `%s` (
              `%s` int(11) NOT NULL,
              `%s` int(11) NOT NULL,
              PRIMARY KEY (`%s`,`%s`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;',$this->getTableName(),$fkField, $fkCatField, $fkField, $fkCatField);
        return $adapter->query($sql);
    }

    public function createCustomizeLinkMediaTable($fkField)
    {
        $adapter = self::getAdapter();
        $sql = sprintf('CREATE TABLE `%s` (
              `record_type` VARCHAR (255) NOT NULL DEFAULT "content",
              `%s` int(11) NOT NULL,
              `fk_media` int(11) NOT NULL,
              PRIMARY KEY (`record_type`,`%s`,`fk_media`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;', $this->getTableName(), $fkField, $fkField);
        return $adapter->query($sql);
    }
}