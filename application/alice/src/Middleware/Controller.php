<?php
namespace Puja\Alice\Middleware;

class Controller extends \Puja\Middleware\Controller
{
    protected $metaTitle;
    protected $metaKeyword;
    protected $metaDescription;
    protected $canonical;
    protected $localeId;

    public function getLocaleId()
    {
        return $this->localeId;
    }

    public function beforeLoadAction()
    {
        $localizeCfg = \Puja\Configure\Configure::getInstance('localization');
        $this->localeId = \Puja\Session\Session::getInstance(\Puja\Alice\Constant::SESSION_LOCALE_INSTANCE)->get(
            \Puja\Alice\Constant::SESSION_LOCALE_KEY,
            $localizeCfg->get('defaultLocaleId')
        );

        $dict = \Puja\I18n\I18n::getInstance($this->localeId)->setDebug($localizeCfg->get('debug'))->importTranslationFile(
            sprintf(
                $localizeCfg->get('cache_dir'),
                $this->localeId
            )
        )->getDict();
        
        $this->view->addData('translate', $dict);
        parent::beforeLoadAction();
    }

    public function setMetaData($data)
    {
        if (!empty($data['meta_title'])) {
            $this->metaTitle = $data['meta_title'];
        }

        if (!empty($data['meta_keyword'])) {
            $this->metaTitle = $data['meta_keyword'];
        }

        if (!empty($data['meta_description'])) {
            $this->metaTitle = $data['meta_description'];
        }
    }

    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;
    }
}