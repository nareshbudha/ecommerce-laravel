<?php
namespace App\Repositories\Eloquent;
use App\Models\Shipping;
use App\Repositories\Contracts\ShippingInterface;
use Illuminate\Support\Facades\DB;

class ShippingRepository implements ShippingInterface
{
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(Shipping $shipping)
    {
        $this->model = $shipping;
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
        $shipping = $this->model->findOrFail($id);

        return DB::transaction(function () use ($shipping, $data) {
            $shipping->update($data);
            return $shipping;
        });
    }

    public function delete($id)
    {
        $shipping = $this->model->find($id);

        if (!$shipping) {
            return response()->json(['message' => "Shipping Id: $id not found"], 404);
        }

        DB::transaction(function () use ($shipping) {
            $shipping->delete();
        });

        return response()->json(['message' => "Shipping Id: {$shipping->id} deleted successfully"]);
    }
}
