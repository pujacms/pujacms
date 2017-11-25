<?php
namespace Puja\Bob\Middleware;
use Puja\Bob\Model\Configure;
use Puja\Bob\Module\Acl\Model\User;
use Puja\Bob\Service\ModuleType;
use Puja\Session\Session;

class Controller extends \Puja\Middleware\Controller
{
    protected $jsonStore;
    /**
     * @var Session
     */
    protected $user;
    protected $navigationId = 'none';
    protected $configureLanguageId = 1;
    protected $navigation;
    protected $cfgModules;

    /**
     * @var User
     */
    protected $acl;
    /**
     * @var \Puja\Breadcrumb\Breadcrumb
     */
    protected $breadcrumb;
    public function beforeLoadAction()
    {
        $this->init();
        $this->user = new \Puja\Bob\Model\User();
        $this->breadcrumb = new \Puja\Breadcrumb\Breadcrumb();
        $this->acl = new User(
            $this->user,
            $this->getModuleId(),
            $this->getControllerId(),
            $this->getActionId()
        );

        $this->view->addData('cfg', \Puja\Configure\Configure::getInstance('application')->getAll());
        if ($this->user->isGuest() && $this->getUri() != '/auth/login/') {
            $this->render('Auth/login.tpl', array());
            $this->afterLoadAction();
        }

        list ($this->cfgModules, $this->navigation) = Configure\CmsMenu::getInstance()->getMenuItem($this, true, true);
        $this->view->addData('navigation', $this->navigation);
        $this->view->addData('breadcrumb', $this->breadcrumb->getData());

        $cmsTheme = Configure\CmsTheme::getInstance()->getByPkId(
            $this->user->get('cmstheme_id', 1)
        );
        $this->view->addData('CmsTheme', $cmsTheme);
        
        list ($navigationType) = explode('-', $cmsTheme['theme_data']['navigation_id']);
        $this->view->addData('navigation_type', $navigationType);


        $this->view->addData('current_user', $this->user->getCurrentUser());
        $this->view->addData('request', $this->getParams());
    }

    protected function init()
    {

    }

    public function setBreadCrumb($title, $url)
    {
        $this->breadcrumb->add($title, $url);
    }

    public function afterLoadAction()
    {
        $this->view->addData('navigationId', $this->navigationId);
        $this->view->addData('jsonStore', json_encode($this->jsonStore));
        parent::afterLoadAction();
    }

    public function addJsonStore($data)
    {
        if ($this->jsonStore === null) {
            $this->jsonStore = array();
        }

        $this->jsonStore = array_merge($data, $this->jsonStore);
    }
}