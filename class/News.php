<?php
namespace Class;
/*
 * extends ModelProperties
 * to inherit the method and properties
 * from ModelProperties
 * DRY principles
 * */

class News extends ModelProperties
{
    public function __construct()
    {
        parent::__construct();
    }
}