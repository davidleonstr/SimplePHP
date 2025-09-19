<?php
require_once __DIR__ . '/../helpers/ValidationHelper.php';

abstract class BaseModel {
    protected $connection;
    protected $table;
    protected $primaryKey;
    protected $fillable = [];
    protected $validationRules = [];

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function findAll() {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY {$this->primaryKey}";
            $stmt = $this->connection->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error getting records:" . $e->getMessage());
        }
    }

    public function findById($id) {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error getting record: " . $e->getMessage());
        }
    }

    public function create($data) {
        try {
            $this->validate($data);
            $filteredData = $this->filterFillable($data);
            
            $fields = array_keys($filteredData);
            $placeholders = ':' . implode(', :', $fields);
            
            $sql = "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES ({$placeholders}) RETURNING {$this->primaryKey}";
            
            $stmt = $this->connection->prepare($sql);
            
            foreach ($filteredData as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            $newId = $stmt->fetchColumn();
            
            return $this->findById($newId);
        } catch (PDOException $e) {
            throw new Exception("Error creating record: " . $e->getMessage());
        }
    }

    public function update($id, $data) {
        try {
            $existing = $this->findById($id);
            if (!$existing) {
                throw new Exception("Record not found");
            }
            
            $this->validate($data, $id);
            $filteredData = $this->filterFillable($data);
            
            $setParts = [];
            foreach ($filteredData as $key => $value) {
                $setParts[] = "{$key} = :{$key}";
            }
            
            $sql = "UPDATE {$this->table} SET " . implode(', ', $setParts) . " WHERE {$this->primaryKey} = :id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            foreach ($filteredData as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
            
            $stmt->execute();
            
            return $this->findById($id);
        } catch (PDOException $e) {
            throw new Exception("Error updating record:" . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $existing = $this->findById($id);
            if (!$existing) {
                throw new Exception("Record not found");
            }
            
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id";
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting record: " . $e->getMessage());
        }
    }

    protected function filterFillable($data) {
        return array_intersect_key($data, array_flip($this->fillable));
    }

    protected function validate($data, $id = null) {
        $errors = [];
        
        foreach ($this->validationRules as $field => $rules) {
            $value = $data[$field] ?? null;
            
            foreach ($rules as $rule) {
                $error = null;
                
                if ($rule === 'required') {
                    $error = ValidationHelper::required($value, $field);
                } elseif ($rule === 'email') {
                    $error = ValidationHelper::email($value, $field);
                } elseif ($rule === 'integer') {
                    $error = ValidationHelper::integer($value, $field);
                } elseif ($rule === 'float') {
                    $error = ValidationHelper::float($value, $field);
                } elseif (is_array($rule) && $rule[0] === 'in_list') {
                    $error = ValidationHelper::inList($value, $rule[1], $field);
                } elseif (is_array($rule) && $rule[0] === 'unique') {
                    $error = $this->validateUnique($value, $field, $id);
                }
                
                if ($error) {
                    $errors[$field][] = $error;
                }
            }
        }
        
        if (!empty($errors)) {
            ResponseHelper::validation($errors);
        }
    }

    protected function validateUnique($value, $field, $excludeId = null) {
        if (empty($value)) return null;
        
        $sql = "SELECT COUNT(*) FROM {$this->table} WHERE {$field} = :value";
        
        if ($excludeId) {
            $sql .= " AND {$this->primaryKey} != :exclude_id";
        }
        
        $stmt = $this->connection->prepare($sql);
        $stmt->bindParam(':value', $value);
        
        if ($excludeId) {
            $stmt->bindParam(':exclude_id', $excludeId, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            return "The value of field {$field} already exists";
        }
        
        return null;
    }
}