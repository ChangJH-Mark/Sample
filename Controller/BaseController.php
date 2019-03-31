<?php
/**
 * Created by PhpStorm.
 * User: 常佳辉
 * Date: 2019/3/25
 * Time: 21:43
 */

namespace Controller;
use Symfony\Component\HttpFoundation\Request;

class BaseController
{
    protected $baseDir;
    protected $request;

    public function __construct()
    {
        $this->request=Request::createFromGlobals();
        $this->baseDir=__DIR__.'/../';
    }
}