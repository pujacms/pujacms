<?php
namespace Puja\Bob\Module\System\Controller;
use Puja\Bob\Module\System\Form\ModuleCreate;
use Puja\Bob\Module\System\Form\ModuleUpdate;
use Puja\Bob\Service\ModuleType;
use Puja\Configure\Configure;
use Puja\Bob\Module\System\Model\DataGrid;

class ModuleController extends \Puja\Bob\Controller\DataGrid\DataGridAbstract
{
    /**
     * @return \Puja\Bob\Model\Configure\Module
     */
    protected function getModel()
    {
        return \Puja\Bob\Model\Configure\Module::getInstance();
    }

    protected function getDataGridModel()
    {
        return DataGrid\Module::getInstance($this);
    }



    public function createAction()
    {
        if ($_POST) {
            $form = new ModuleCreate($this->getParam('ConfigureModule'));
            if ($form->validate()) {
                $this->getModel()->create($form->getAttributes());
                $this->json(array('status' => true));
            }
        }
        $data = array(
            'ModuleTypes' => ModuleType::getInstance()->getAll(),
        );
        $this->render('System/Module/partial/core_create.tpl', $data);
    }

    public function updateAction()
    {
        if ($_POST) {
            $form = new ModuleUpdate($this->getParam('ConfigureModule'));
            if ($form->validate()) {
                $this->getModel()->update($form->getAttributes(), $this->getParam('pkid'));
                $this->redirect('./?module=system&ctrl=module');
            }
        }

        $this->render('System/Update/Module.tpl', $this->getData());
    }

    protected function getData()
    {
        $data = array();
        if (!$this->getParam('pkid')) {
            return $data;
        }

        $configureModule = $this->getModel()->getById($this->getParam('pkid'));
        
        if ($configureModule['module_type'] == 'system') {
            return array('ConfigureModule' => $configureModule);
        }

        $data = array(
            'ConfigureModule' => $configureModule,
            'content' => array(
                'tbl' => $this->getModel()->getSchema(
                    $configureModule['core_data']['content']['tbl']['name'],
                    empty($configureModule['cfg_data']['content']['main_fields']) ? array() : $configureModule['cfg_data']['content']['main_fields']
                ),

                'actions' => $configureModule['module_type'] == 'html' ? array('new', 'update', 'delete') : array('new', 'update', 'delete', 'move'),
            ),
            'moduleList' => $this->getModel()->getAll(),
            'CfgFieldType' => Configure::getInstance('FieldTypes')->getAll(),
        );

        if (!empty($configureModule['core_data']['content']['ln_tbl'])) {
            $data['content']['ln_tbl'] = $this->getModel()->getSchema(
                $configureModule['core_data']['content']['ln_tbl']['name'],
                empty($configureModule['cfg_data']['content']['ln_fields']) ? array() : $configureModule['cfg_data']['content']['ln_fields']
            );
        }

        if (empty($configureModule['core_data']['category']['tbl'])) {
            return $data;
        }

        $data['category'] = array(
            'tbl' => $this->getModel()->getSchema(
                $configureModule['core_data']['category']['tbl']['name'],
                empty($configureModule['cfg_data']['category']['main_fields']) ? array() : $configureModule['cfg_data']['category']['main_fields']
            ),
            'actions' => array('new', 'update', 'delete'),
            'limitation' => array(
                'max_level' => array('name' => 'Max Level' , 'description' => 'Exp: 5 = can only create maximum 5 category levels. -1: no limit'),
                'nonew_content_in_category_levels' => array('name' => 'No new content in category levels' , 'description' => 'Exp: 1,2,3: cannot create content in category levels: 1,2,3. -1: no limit'),
                'nonew_content_in_category_ids' => array('name' => 'No new content in category ids' , 'description' => '1,2,3: cannot create content in category ids: 1,2,3. -1: no limit'),
                'nodel_content_in_category_levels' => array('name' => 'No delete content in category levels' , 'description' => 'Exp: 1,2,3: cannot delete content in category levels: 1,2,3. -1: no limit'),
                'nodel_content_in_category_ids' => array('name' => 'No delete content in category levels' , 'description' => 'Exp: 1,2,3: cannot delete content in category ids: 1,2,3. -1: no limit'),
            ),
        );

        if (!empty($configureModule['core_data']['category']['ln_tbl'])) {
            $data['category']['ln_tbl'] = $this->getModel()->getSchema(
                $configureModule['core_data']['category']['ln_tbl']['name'],
                empty($configureModule['cfg_data']['category']['ln_fields']) ? array() : $configureModule['cfg_data']['category']['ln_fields']
            );
        }

        if (!empty($data['category']['limitation'])) {
            foreach ($data['category']['limitation'] as $key => $values) {
                $data['category']['limitation'][$key]['value'] = null;
                if (!empty($configureModule['cfg_data']['category']['limitation']) && array_key_exists($key, $configureModule['cfg_data']['category']['limitation'])) {
                    $data['category']['limitation'][$key]['value'] = $configureModule['cfg_data']['category']['limitation'][$key];
                }
            }
        }
        
        return $data;
    }
    
    public function addFieldAction()
    {
        if ($_POST) {
            $data = array('status' => true, 'msg' => 'Field has been added, pls refresh page to see the update!');
            try {
                $this->getModel()->addField($this->getParam('table'), $this->getParam('field'));
            } catch (\Exception $e) {
                $data['status'] = false;
                $data['msg'] = $e->getMessage();
            }

            $this->json($data);
            return;
        }
        $data = array(
            'FieldTypes' => Configure::getInstance('FieldTypes')->getAll()
        );
        $this->render('System/Module/partial/table_add_field.tpl', $data);
    }

}