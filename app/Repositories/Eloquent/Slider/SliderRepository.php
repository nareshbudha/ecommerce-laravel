<?php
namespace App\Repositories\Eloquent\Slider;
use App\Models\Slider;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\Slider\SliderInterface;

class SliderRepository implements SliderInterface
{
    /**
     * Create a new class instance.
     */
    protected $model;
    public function __construct( Slider  $slide)
    {
    $this->model = $slide;
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
       return DB::transaction(function () use ($data) {
            return $this->model->create($data);
        });
    }
    public function update($id, array $data)
    {
        $slider = $this->model->findOrFail($id);
        return DB::transaction(function () use ($slider, $data) {
            $slider->update($data);
            return $slider;
        });
    }

    public function delete($id)
    {
        $slider = $this->model->find($id);

        if (!$slider) {
            return response()->json(['message' => "Slider Id: $id not found"], 404);
        }

        DB::transaction(function () use ($slider) {
            $slider->delete();
        });

        return response()->json(['message' => "Slider Id: {$slider->id} deleted successfully"]);
    }
}
