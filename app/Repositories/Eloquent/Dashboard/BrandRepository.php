<?php

namespace App\Repositories\Eloquent\Dashboard;

use App\Models\Brand;
use App\Repositories\Contracts\Dashboard\BrandInterface;

class BrandRepository implements BrandInterface
{
   protected $model;
    public function __construct( Brand  $brand)
    {
    $this->model = $brand;
    }
    public function get()
    {
        $query = $this->model->newQuery();
        return $query->get();
    }
    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
    
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update($id, array $data)
    {
        $brand = $this->model->findOrFail($id);
        $brand->update($data);
        return $brand;
    }
    public function delete($id)
    {
        $brand = $this->model->findOrFail($id);
        $brand->delete();
        return response()->json(['message' => "Brand Id: {$brand->id} deleted successfully"]);
    }
}
