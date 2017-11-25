<?php
namespace Puja\Bob\Model\Entity\Processor;

class FormTransfer
{
    protected $dynamicOptions = array();

    public static function getInstance()
    {
        return new static();
    }

    protected function __construct()
    {
    }


    public function convertToHtmlData($field, $cfg, $entityData, $mediaData, $dynamicOptions)
    {
        $value = null;
        if (array_key_exists($field, $entityData)) {
            $value = $entityData[$field];
        }

        switch ($cfg['field_type']) {
            case 'multi_input':
            case 'multi_textarea':
                $value = $value ? json_decode($value) : array();
                break;
            case 'static_option':
                if ($cfg['setting']['static_option_type'] == 'checkbox' || $cfg['setting']['static_option_type'] == 'select_multi') {
                    $value = $value ? json_decode($value) : array();
                }
                break;
            case 'dynamic_option':
                $value = null;
                if (!empty($dynamicOptions[$field])) {
                    $value = $dynamicOptions[$field];
                }
                break;
            case 'file':
            case 'file_img':
                if (!empty($value)) {
                    $mediaIds = explode(',', $value);
                    $value = array();
                    foreach ($mediaIds as $mediaId) {
                        if (empty($mediaData[$mediaId])) {
                            continue;
                        }

                        $value[] = $mediaData[$mediaId];
                    }
                }
                
                break;
            default:
                break;

        }

        return $value;
    }

    public function convertToDbData($entityData, $entityCfg, &$uploadedMediaIds)
    {
        if (empty($entityData)) {
            return array();
        }

        foreach ($entityData as $field => $value) {
            if (empty($entityCfg[$field])) {
                continue;
            }

            $entityData[$field] = $this->getDbValue(
                $entityCfg[$field],
                $value,
                $uploadedMediaIds
            );

            if ($entityCfg[$field]['field_type'] == 'dynamic_option') {
                $this->dynamicOptions[$field] = $value;
            }
        }

        return $entityData;
    }

    public function getDbValue($cfg, $value, &$uploadedMediaIds)
    {
        switch ($cfg['field_type']) {
            case 'multi_input':
            case 'multi_textarea':
                $value = $value ? json_encode($value) : null;
                break;
            case 'static_option':
                if ($cfg['setting']['static_option_type'] == 'checkbox' || $cfg['setting']['static_option_type'] == 'select_multi') {
                    $value = $value ? json_encode($value) : null;
                }
                break;
            case 'dynamic_option':
                $value = empty($value) ? null : implode(',', $value);
                break;
            case 'file':
            case 'file_img':
                if (!empty($value)) {
                    $uploadedMediaIds = array_merge($uploadedMediaIds, $value);
                    $value = implode(',', $value);
                }
                break;
        }

        return $value;
    }
}