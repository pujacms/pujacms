<?php
namespace Puja\Library\TemplateEngine;
class CustomFilter extends \Puja\Template\Lexer\Filter\FilterAbstract
{
    public function navigationFilter($var, $arg)
    {
        list ($navigation) = explode($var, '-');
        return $navigation;
    }

    public function classNameNormalizeFilter($var, $arg)
    {
        return str_replace(array('[', ']'), '', $var);
    }
}