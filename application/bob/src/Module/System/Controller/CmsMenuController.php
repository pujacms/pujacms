<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Module\System\Model\DataGrid;

class CmsMenuController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    protected $isGridDnD = true;

    public function manageAction()
    {
        $gridFields = array(
            'configure_cmsmenu_id' => '#',
            'name' => 'Name',
        );

        $cmsMenus = $this->navigation;
        unset($cmsMenus['system'], $cmsMenus['root_admin']);

        $data = array(
            'cms_menus' => $cmsMenus,
            'configure_modules' => $this->cfgModules,
        );
        
        $this->render('System/Update/CmsMenu.Manage.tpl', $data);
    }

    public function updateAction()
    {
        if ($_POST) {
            return parent::updateAction();

        }
        $data = array();
        if ($this->getParam('pkid')) {
            $data['entity'] = $this->getModel()->getByPkId($this->getParam('pkid'));
        }
        $this->render('System/Update/CmsMenu.tpl', $data);
    }

    public function updateOrderIdAction()
    {
        foreach ($this->getParam('order_ids') as $orderId => $pkId) {
            $this->getModel()->updateOrderId($orderId, $pkId);
        }
        $this->json(array('status' => true));
    }

    public function deleteAction()
    {
        $this->getModel()->delete($this->getParam('pkid'));
        $this->json(array('status' => true));
    }

    public function insertAction()
    {

        $this->getModel()->insert($this->getParam('name'));
        $this->json(array('status' => true));
    }

    public function updateChildAction()
    {
        foreach ($this->getParam('child') as $pkId => $moduleIds) {
            $this->getModel()->updateChild($moduleIds, $pkId);
        }
        $this->json(array('status' => true));

    }

    protected function getModel()
    {
        return \Puja\Bob\Model\Configure\CmsMenu::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\CmsMenu::getInstance($this);
    }


}