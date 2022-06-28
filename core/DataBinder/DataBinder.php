<?php


namespace core\DataBinder;


use src\Data\DTO\UserDTO;

class DataBinder implements DataBinderInterface
{

    public function bind(array $postData, string $className): object
    {
        $model = new $className;

        foreach ($postData as $key => $value) {
            $method = "set" .
                implode("",
                    array_filter(
                        explode("_", $key),
                        function ($element) {
                            return ucfirst($element);
                        }
                    )
                );

            if (method_exists($model, $method)) {
                $model->$method($value);
            }
        }

        return $model;
    }
}