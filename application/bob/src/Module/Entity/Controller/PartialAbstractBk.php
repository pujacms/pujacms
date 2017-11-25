<?php
namespace Puja\Bob\Module\Entity\Controller;
use Puja\Bob\Middleware\Controller;
use Puja\Bob\Service\Module;
use Puja\Bob\Service\ModuleType;
use Puja\Middleware\Exception\Exception;

abstract class PartialAbstract extends Controller
{
    protected $cfgModule;
    protected $moduleType;
    protected $moduleTypeId;
    protected $typeId;
    protected $parentId;
    public function beforeLoadAction()
    {
        parent::beforeLoadAction();
        if (null === $this->moduleType) {
            $this->moduleType = $this->getModuleId();
        }
        $this->typeId = (int) $this->getParam('typeid');
        $this->parentId = (int) $this->getParam('parentid');

        $moduleType = ModuleType::getInstance()->getByModuleType($this->moduleType);
        $this->moduleTypeId = $moduleType['configure_module_type_id'];
        $this->cfgModule = Module::getInstance()->getByModuleTypeIdAndTypeId(
            $this->moduleTypeId,
            $this->typeId
        );

        if (empty($this->cfgModule)) {
            throw new Exception('This module doesnt configure yet!');
        }
    }

    /**
     * @return \Puja\Bob\Module\Entity\Model\Partial\PartialAbstract
     */
    abstract protected function getModel();

    public function updateAction()
    {
        $pkId = (int) $this->getParam('pkid', 0);
        $parentId = (int) $this->getParam('parentid', 0);
        $model = $this->getModel();

        if ($_POST) {
            $entityId = $model->saveMainEntity($pkId, $parentId, $this->getParam('MainEntity'));
            $model->saveLnEntity($entityId, $this->getParam('LnEntity'));
            $this->json(array('status' => true, 'entityId' => $entityId));
        }

        $data = array(
            'MainEntity' => $model->getMainEntity($pkId),
            'LnEntity' => $model->getLnEntity($pkId),
        );

        $this->addJsonStore(array(
            'moduleType' => $this->cfgModule['module_type'],
            'typeId' => $this->cfgModule['type_id'],
            'recordType' => $model->getRecordType(),
            'parentId' => $this->getParam('parentid', 0),
            'pkId' => $this->getParam('pkid', 0),
        ));

        $this->render('Entity/Update.tpl', $data);
    }

    public function dynamicOptionDataAction()
    {
        $model = $this->getModel();
        $options = $this->getParam('options');

        if ($options['type'] == 'datagrid_list') {
            $entities = $model->getEntities();
            $dataOptions = $model->getDynamicOptionsData($options['contentid'], $options['field']);

            if (!empty($dataOptions[$options['field']])) {
                foreach ($entities as $key => $entity) {
                    if (empty($dataOptions[$options['field']][$entity['pkid']])) {
                        continue;
                    }

                    $entity['checked'] = true;
                    $entities[$key] = $entity;
                }
            }

        } elseif ($options['type'] == 'datagrid_search') {
            $entities = $model->getSearchEntities($this->getParam('excludeIds'), $this->getParam('q'));
        }
        return $this->json($entities);
    }
}