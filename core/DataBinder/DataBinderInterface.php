<?php


namespace core\DataBinder;


interface DataBinderInterface
{
    public function bind(array $postData, string $className): object;
}