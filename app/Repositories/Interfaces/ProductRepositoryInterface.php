<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function all();
    public function show($slug);
    public function store($data);
    public function update($data, $slug);
    public function destroy($slug);
}
