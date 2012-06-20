<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-20
 * Time: 08:22
 */


class ControllerBase
{
    protected $app;
    function __construct($app) {
        $this->app = $app;
    }
}
