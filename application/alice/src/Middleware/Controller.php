<?php
namespace Puja\Alice\Middleware;

class Controller extends \Puja\Middleware\Controller
{
    protected $metaTitle;
    protected $metaKeyword;
    protected $metaDescription;
    protected $canonical;
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