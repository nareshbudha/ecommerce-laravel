<?php

namespace App\Repositories\Contracts\Slider;

interface SliderInterface
{
    public function get();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
