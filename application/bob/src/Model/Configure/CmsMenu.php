<?php
namespace Puja\Bob\Model\Configure;
use Puja\Bob\DbTable;
use Puja\Configure\Configure;

class CmsMenu extends \Puja\Bob\Model\AbstractLayer\ModelAbstract
{
    protected static $modelName = 'Configure_CmsMenu';
    protected $currentCmsMenu = array();
    protected function getTable()
    {
        return DbTable\Configure\CmsMenu::getInstance();
    }


    public function getMenuId($module, $typeId = null, $ctrl = null)
    {
        $menuId = null;
        switch ($module) {
            case 'entity':
            case 'html':
            case 'customize':
                $menuId = $module . '_' . $typeId;
                break;
            case 'system':
            case 'configure':
                $menuId = $module . '_' . $ctrl;
                break;
            default:
                $menuId = $module . '_' . $ctrl;
                break;
        }

        return $menuId;
    }

    public function checkCurrentCmsMenu(\Puja\Bob\Middleware\Controller $controller, &$cmsMenu, $buildBreadCrumb = false)
    {
        $menuId = $this->getMenuId(
            $controller->getModuleId(),
            $controller->getParam('typeid', 0),
            $controller->getControllerId()
        );
        if (!empty($cmsMenu['child'][$menuId])) {
            $cmsMenu['is_current'] = true;
            $cmsMenu['child'][$menuId]['is_current'] = true;
            $controller->setBreadCrumb($cmsMenu['name'], '/');
            $controller->setBreadCrumb($cmsMenu['child'][$menuId]['name'], $cmsMenu['child'][$menuId]['url']);
        }
    }


    public function getMenuItem(\Puja\Bob\Middleware\Controller $controller, $withRoot = false, $buildBreadCrumb = false, $module = null, $typeId = null, $ctrl = null)
    {
        $moduleTypes = array();
        $moduleTypeResult = \Puja\Bob\Model\Configure\ModuleType::getInstance()->getAll();
        foreach ($moduleTypeResult as $rs) {
            $moduleTypes[$rs['id_configure_module_type']] = $rs;
        }

        $controller->addJsonStore(array(
            'module_types' => $moduleTypes,
        ));

        $cfgModules = array();
        $result = \Puja\Bob\Model\Configure\Module::getInstance()->getAll();
        foreach ($result as $rs) {
            $rs['menu_available'] = true;
            $rs['module_type'] = $moduleTypes[$rs['fk_module_type']]['module_type'];

            if ($rs['module_type'] == 'system') {
                $cfgModules['system'][] = $rs;
            }

            $cfgModules[$rs['id_configure_module']] = $rs;
        }

        $result = self::getInstance()->getAll();
        $cmsMenu = array();
        foreach($result as $key => $rs) {
            if (!empty($rs['child'])) {
                $child = unserialize($rs['child']);
                $rs['child'] = array();
                foreach ($child as $cfgModuleId) {
                    if (!array_key_exists($cfgModuleId, $cfgModules)) {
                        continue;
                    }

                    $cfgModules[$cfgModuleId]['menu_available'] = false;

                    $child = $cfgModules[$cfgModuleId];
                    if ($child['module_type'] == 'html') {
                        $child['url'] = './?module=html&ctrl=content&act=update&pkid=' . $cfgModuleId . '&typeid=' . $cfgModuleId;
                    } elseif ($child['module_type'] == 'entity' || $child['module_type'] == 'customize') {
                        $child['url'] = './?module=' . $child['module_type'] . '&typeid=' . $cfgModuleId;
                    }
                    $child['navigationId'] = $this->getMenuId($child['module_type'], $cfgModuleId);
                    $rs['child'][$child['navigationId']] = $child;
                }

            }


            $this->checkCurrentCmsMenu($controller, $rs, $buildBreadCrumb);
            $cmsMenu[$rs['id_configure_cmsmenu']] = $rs;
        }

        if ($withRoot) {
            $cmsMenu['system'] = array(
                'name' => 'System',
                'id_configure_cmsmenu' => 'system_menu',
                'child' => array(
                    'configure_index' => array('name' => 'Configuration', 'url' => './?module=configure', 'navigationId' => 'configure_index'),
                    'configure_pagemeta' => array('name' => 'Page Meta data', 'url' => './?module=configure&ctrl=pagemeta', 'navigationId' => 'configure_pagemeta'),
                    'acl_index' => array('name' => 'ACL', 'url' => './?module=acl', 'navigationId' => 'acl_index'),
                    'media_index' => array('name' => 'Media', 'url' => './?module=media', 'navigationId' => 'media_index'),
                    'configure_webtranslate' => array('name' => 'Webtranslate', 'url' => './?module=configure&ctrl=webtranslate', 'navigationId' => 'configure_webtranslate'),
                )
            );

            if (!empty($cfgModules['system'])) {
                $cmsMenu['system']['child'] = array_merge($cmsMenu['system']['child'], $cfgModules['system']);
            }

            $this->checkCurrentCmsMenu($controller, $cmsMenu['system'], $buildBreadCrumb);

            if (Configure::getInstance('application')->get('root_admin', null)) {
                $cmsMenu['root_admin'] = array(
                    'name' => 'Root Admin',
                    'configure_cmsmenu_id' => 'root_admin_menu',
                    'child' => array(
                        'system_module' => array('name' => 'Configure Modules', 'url' => './?module=system&ctrl=module', 'navigationId' => 'system_module'),
                        'system_cmsmenu' => array('name' => 'Configure CMS Menu', 'url' => './?module=system&ctrl=cmsmenu', 'navigationId' => 'system_cmsmenu'),
                        'system_language' => array('name' => 'Configure Languages', 'url' => './?module=system&ctrl=language', 'navigationId' => 'system_language'),
                        'system_configure' => array('name' => 'Manage Configurations', 'url' => './?module=system&ctrl=configure', 'navigationId' => 'system_configure'),
                        'system_cmstheme' => array('name' => 'Manage Cms Themes', 'url' => './?module=system&ctrl=cmstheme', 'navigationId' => 'system_cmstheme'),
                        'system_pagemeta' => array('name' => 'Manage Page Meta Datas', 'url' => './?module=system&ctrl=pagemeta', 'navigationId' => 'system_pagemeta'),
                    )
                );

                $this->checkCurrentCmsMenu($controller, $cmsMenu['root_admin'], $buildBreadCrumb);
            }
        }

        return array($cfgModules, $cmsMenu);
    }

    /*
    public function update($name, $pkId)
    {
        $tbl = new \Puja\Bob\DbTable\Configure\CmsMenu();
        $tbl->updateByCriteria(array('name' => $name), array('configure_cmsmenu_id' => $pkId));
    }

    public function clearAllChild()
    {
        $tbl = new \Puja\Bob\DbTable\Configure\CmsMenu();
        $tbl->updateByCriteria(array('child' => ''), '1');
    }*/

    public function updateChild($moduleIds, $pkId)
    {
        $this->table->updateByPkId(array('child' => serialize($moduleIds)), $pkId);
    }
    
    
}