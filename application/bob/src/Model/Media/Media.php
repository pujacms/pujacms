<?php
namespace Puja\Bob\Model\Media;
use Puja\Bob\DbTable;
use Puja\Configure\Configure;

class Media extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected function getTable()
    {
        return DbTable\Media\Media::getInstance();
    }

    public function uploadNormal()
    {
        $uploadSetting = \Puja\Configure\Configure::getInstance('upload_config')->getAll();
        $uploadSetting['allowFileExt'] = '.jpg,.png,.gif';
        $uploader = new \Puja\Upload\Upload(
            $uploadSetting
        );
        $img = $uploader->upload('file');
        $mediaId = $this->table->insert(array(
            'src' => $img,
        ));

        return array(
            'media_id' => $mediaId,
            'src' => $img,
        );
    }

    public function upload($idConfigureMododule, $recordType, $fieldName)
    {
        $settings = $this->getUploadAndResizeSetting($idConfigureMododule, $recordType, $fieldName);
        if (empty($settings)) {
            throw new \Exception('Cannot load settings');
        }

        $uploader = new \Puja\Upload\Upload(
            $settings['upload']
        );
        $img = $uploader->upload('file');

        $this->resizeImage($img, $settings['resize']);
        $mediaId = $this->table->insert(array(
            'src' => $img,
        ));

        return array(
            'media_id' => $mediaId,
            'src' => $img,
        );
    }

    protected function getUploadAndResizeSetting($idConfigureMododule, $recordType, $fieldName)
    {
        $cfgModule = \Puja\Bob\Model\Configure\Module::getInstance()->getById($idConfigureMododule);
        if (empty($cfgModule)) {
            throw new \Exception('ConfigureModule not found');
        }

        $field = array();


        if (!empty($cfgModule['cfg_data'][$recordType]['main_fields'][$fieldName])) {
            $field = $cfgModule['cfg_data'][$recordType]['main_fields'][$fieldName];
        } elseif (!empty($cfgModule['cfg_data'][$recordType]['ln_fields'][$fieldName])) {
            $field = $cfgModule['cfg_data'][$recordType]['ln_fields'][$fieldName];
        }

        if ($field['field_type'] != 'file' && $field['field_type'] != 'file_img') {
            return null;
        }

        if (empty($field['setting'])) {
            return null;
        }

        if (empty($field['setting']['allowed_fileext']) && $field['field_type'] == 'file_img') {
            $field['setting']['allowed_fileext'] = '.jpg,.png,.gif';
        }

        $uploadSetting = \Puja\Configure\Configure::getInstance('upload_config')->getAll();
        $uploadSetting['allowFileExt'] = $field['setting']['allowed_fileext'];
        
        $resizeSetting = $field['setting'];
        $resizeSetting['uploadDir'] = $uploadSetting['uploadDir'];
        return array('upload' => $uploadSetting, 'resize' => $resizeSetting);
    }

    protected function resizeImage($image, $setting)
    {
        if (empty($setting['thumb']) && empty($setting['resize'])) {
            return false;
        }

        $model = \Puja\Image\Image::getInstance($setting['uploadDir'] . $image);

        if (!empty($setting['thumb'])) {
            $this->processResizeImage($model, $setting['thumb_w'], $setting['thumb_h'], $setting['uploadDir'] . 'thumb/' . $image);
        }


        if (!empty($setting['resize'])) {
            if (!empty($setting['original'])) {
                $model->copyTo($setting['uploadDir'] . 'original/' . $image);
            }
            $this->processResizeImage($model, $setting['resize_w'], $setting['resize_h'], $setting['uploadDir'] . $image);
        }
    }

    protected function processResizeImage(\Puja\Image\Image $model, $width, $height, $dest)
    {
        if ($width == 0 && $height == 0) {
            return false;
        }

        if ($width == 0) {
            $model->resize($width, $height, \Puja\Image\Image::MODE_FIT_Y)->saveTo($dest);
        }

        if ($height == 0) {
            $model->resize($width, $height, \Puja\Image\Image::MODE_FIT_X)->saveTo($dest);
        }

        $model->resize($width, $height, \Puja\Image\Image::MODE_FIT)->saveTo($dest);
    }
}