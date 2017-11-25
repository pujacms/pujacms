<?php
namespace Puja\Bob\Module\Entity\Helper;

class Transfer
{
    public static function getValue($field, $cfg, $entityData, $dynamicOptions)
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
            default:
                break;

        }
        return $value;
    }

    public static function setValue($cfg, $value)
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
        }

        return $value;
    }



}