<?php
namespace Puja\Alice\Model;
class Language
{
    public function getCurrentLanguage()
    {

    }

    public function switchLanguage($localeId)
    {

    }

    public function getAll()
    {
        $bobAdapter = \Puja\Alice\Model\Bob\Adapter::getInstance();
        $languages = $bobAdapter->get('ConfigureLanguage');
    }
}