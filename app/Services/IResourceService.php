<?php


namespace App\Services;


interface IResourceService
{
    public function get($limit);
    public function create($postData);
    public function update($model,$putData);
    public function delete($model);
}