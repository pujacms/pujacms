<?php
namespace Puja\Bob\Controller\DataGrid\Entity;

use Puja\Bob\Model\Constant;

abstract class DataGridAbstract extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    protected $idConfigureModule;
    protected $parentId;
    protected $isDynamicOption;

    protected static $currentCfgModule;
    protected static $parents;

    /**
     * @var \Puja\Bob\Model\DataGrid\Entity\ConfigureAbstract
     */
    protected $dataGridModel;

    /**
     * @var \Puja\Bob\Model\Entity\EntityAbstract
     */
    protected $model;
    /**
     * @return \Puja\Bob\Model\Entity\CategoryAbstract
     */
    abstract protected function getCategoryModel();

    public function beforeLoadAction()
    {
        // not change the order of these line
        $this->idConfigureModule = (int) $this->getParam('typeid', 0);
        $this->parentId = (int) $this->getParam('parentid', 0);
        parent::beforeLoadAction();
        if (empty($this->cfgModules[$this->idConfigureModule])) {
            throw new \Exception('Your module is not configured yet');
        }
        // end
    }

    public function getCurrentCfgModule()
    {
        if (null === self::$currentCfgModule) {
            self::$currentCfgModule = \Puja\Bob\Model\Configure\Module::getInstance()->getById($this->idConfigureModule);
        }
        return self::$currentCfgModule;
    }

    public function getParentId()
    {
        return (int) $this->getParam('parentid', 0);
    }

    public function getParents()
    {
        if (null == self::$parents) {
            $categoryModel = $this->getCategoryModel();
            if ($this->parentId) {

                self::$parents = $categoryModel->getParentsByPkId($this->parentId);
            } elseif ('category' == $this->controllerId) {
                // get parent in case update category
                self::$parents = $categoryModel->getParentsByPkId($this->getParam('pkid'));
            }
        }

        return self::$parents;
    }
    
    public function indexAction()
    {
        $this->addJsonStore(array(
            'pkField' => $this->dataGridModel->getPkField(),
            'moduldeId' => $this->getModuleId(),
            'controllerId' => $this->getControllerId(),
            'typeId' => $this->idConfigureModule,
            'parentId' => $this->parentId,
        ));
        $this->view->parse('Entity/DataGrid.tpl', $this->getIndexActionData());

    }

    protected function getIndexActionData()
    {
        $data = parent::getIndexActionData();
        $data['breadcrumb_categories'] = self::getParents();
        return $data;
    }

    public function updateAction()
    {
        $pkId = (int) $this->getParam('pkid', 0);
        $parentId = (int) $this->getParam('parentid', 0);

        if ($_POST) {
            return $this->json(array(
                'status' => true,
                'entityId' => $this->setUpdateData($pkId, $parentId)
            ), 'text/html');
        }

        $cfgModule = $this->getCurrentCfgModule();

        $this->addJsonStore(array(
            'moduleId' => $this->getModuleId(),
            'moduleType' => $cfgModule['fk_module_type'],
            'typeId' => $cfgModule['id_configure_module'],
            'recordType' => $this->model->getRecordType(),
            //'parentId' => $this->getParam('parentid', 0),
            'pkId' => $this->getParam('pkid', 0),
        ));

        $parents = self::getParents();
        if ($this->getParam('pkid', null) ) {
            //edit
        }
        
        
        $level = count($parents);
        if (!$this->getParam('pkid', null)) {
            $level = $level + 1;
        }


        $this->render(
            'Entity/Update.tpl',
            $this->getUpdateData($pkId, $parentId, $level)
        );
    }

    protected function setUpdateData($pkId, $parentId)
    {

        $entityId =  $this->model->setEntity(
            $pkId,
            $parentId,
            $this->getParam(Constant::MAIN_ENTITY),
            static::getParents()
        );
        if ($this->configureLanguageId) {
            $this->model->getLocalizeModel()->setEntityLocalize(
                $entityId,
                $this->getParam(Constant::LN_ENTITY)
            );
        }

        return $entityId;
    }

    protected function getUpdateData($pkId, $parentId, $level)
    {
        $this->model->setLevel($level);
        $data = array(
            'MainEntity' => $this->model->getEntityByPkId($pkId),
            'IsDynamicOption' => $this->isDynamicOption,
            'BackUrl' => './?module=' . $this->getModuleId() . '&parentid=' . $parentId . '&typeid=' . $this->idConfigureModule,
        );

        $this->addJsonStore(array('parentId' => $this->getParam('parentid', 0) ? $this->getParam('parentid', 0) : $data['MainEntity']['parent']));
        
        if ($this->configureLanguageId) {
            $data['LnEntities'] = $this->model->getLocalizeModel()->getEntityByPkId($pkId);
            $data['IsMultiLang'] = true;
        }

        return $data;
    }

    protected function listSortDefault()
    {
        return 'order_id';
    }

    public function updateOrdersAction()
    {
        if ($_POST) {
            $orderRecords = $this->getParam('orderrecord');
            $this->model->updateOrders($orderRecords[$this->getControllerId()]);
            return $this->json(array(
                'status' => true,
            ));
        }
    }

    public function getLinkContentContentAction()
    {

    }

    protected function processDelete($pkId)
    {

        $content = $this->model->getByPkId($pkId);
        if (empty($content)) {
            return null;
        }

        $this->model->updateOrderBeforeDelete($content);
        parent::processDelete($pkId); // TODO: Change the autogenerated stub

    }


}