<?php
/**
 * Author: Fredrik Enestad @ Devloop AB (fredrik@devloop.se)
 * Date: 2012-06-20
 * Time: 08:47
 */
 
interface IModel {
    public function validate();
    public function persist();
}