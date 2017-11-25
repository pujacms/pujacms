<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Model\Configure;
use Puja\Bob\Module\System\Model\DataGrid;

class CmsThemeController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    protected $isGridDnD = true;
    public function updateAction()
    {
        if ($_POST) {
            $form = new \Puja\Bob\Module\System\Form\CmsTheme($this->getParam('theme'));
            if ($form->validate()) {
                if ($this->getParam('pkid')) {
                    $this->getModel()->update(
                        $form->getAttributes(),
                        $this->getParam('pkid')
                    );
                } else {
                    $insertId = $this->getModel()->insert(
                        $form->getAttributes()
                    );
                }
                $this->json(array('status' => true));
            } else {
                $this->json(array('status' => false, 'msg' => 'Something wrong!'));
            }
        }
        $data = array(
            'EasyUITheme' => \Puja\Configure\Configure::getInstance('EasyUITheme')->getAll(),
            'NavigationTheme' => \Puja\Configure\Configure::getInstance('NavigationTheme')->getAll(),
        );

        if ($this->getParam('pkid')) {
            $data['CmsTheme'] = $this->getModel()->getByPkId($this->getParam('pkid'));
        }
        $this->render('System/Update/CmsTheme.tpl', $data);
    }

    protected function getModel()
    {
        return Configure\CmsTheme::getInstance();
    }
    
    protected function getDataGridModel()
    {
        return DataGrid\CmsTheme::getInstance($this);
    }


    
}