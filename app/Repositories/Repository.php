<?php
namespace App\Repositories;

use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface
{
    // Model property on class instances
    protected $model;

    // Constructor to bind modelto repo
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // Create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // Update record in database
    public function update(array $data, $id)
    {
        $record = $this->model->findOrFail($id);
        return $record->update($data);
    }

    // Show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Remove record from database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // Set the associated model
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    // Get the associated model
    public function getModel() : Model
    {
        return $this->model;
    }

    // Eager load database relations
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}