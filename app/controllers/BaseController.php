<?php
abstract class BaseController {
    protected $model;

    public function __construct($model) {
        $this->model = $model;
    }

    public function index() {
        try {
            $data = $this->model->findAll();
            ResponseHelper::success($data, 'Records successfully obtained');
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function show($id) {
        try {
            $data = $this->model->findById($id);
            if (!$data) {
                ResponseHelper::notFound('Record not found');
            }
            ResponseHelper::success($data, 'Registration successfully obtained');
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 500);
        }
    }

    public function store() {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                ResponseHelper::error('Invalid JSON data', 400);
            }
            
            $data = $this->model->create($input);
            ResponseHelper::success($data, 'Record created successfully', 201);
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function update($id) {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (!$input) {
                ResponseHelper::error('Invalid JSON data', 400);
            }
            
            $data = $this->model->update($id, $input);
            ResponseHelper::success($data, 'Registration successfully updated');
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 400);
        }
    }

    public function destroy($id) {
        try {
            $result = $this->model->delete($id);
            if ($result) {
                ResponseHelper::success(null, 'Record deleted successfully');
            } else {
                ResponseHelper::error('The record could not be deleted', 500);
            }
        } catch (Exception $e) {
            ResponseHelper::error($e->getMessage(), 400);
        }
    }
}