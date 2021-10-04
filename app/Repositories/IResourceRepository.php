<?php


namespace App\Repositories;


interface IResourceRepository
{
    public function list($perPage);

    public function get($id);

    public function create($postData);

    public function update($model, $data);

    public function delete($model);

}