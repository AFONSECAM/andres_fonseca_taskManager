<?php

class Task{
    private $pdo;

    public function __construct($pdo){
        $this->pdo = $pdo;
    }

    public function getAll($userId){
        $query = "SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($userId, $title, $description, $due_date, $priority, $attachment){
        $query = "INSERT INTO tasks (user_id, title, description, due_date, priority, attachment) VALUES (?,?,?,?,?,?)";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$userId, $title, $description, $due_date, $priority, $attachment]);        
    }

    public function update($taskId, $title, $description, $due_date, $priority, $completed, $userId, $attachment){        
        if($attachment){
            $query = "UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, completed = ?, attachment = ? WHERE id= ? AND user_id = ?";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $description, $due_date, $priority, $completed, $attachment, $taskId, $userId]);
        }else{
            $query = "UPDATE tasks SET title = ?, description = ?, due_date = ?, priority = ?, completed = ? WHERE id= ? AND user_id = ?";
            $stmt = $this->pdo->prepare($query);
            return $stmt->execute([$title, $description, $due_date, $priority, $completed, $taskId, $userId]);
        }
    }

    public function delete($taskId, $userId){
        $query = "DELETE FROM tasks WHERE id = ? AND user_id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$taskId, $userId]);
    }

    public function changeStatus($taskId, $status){        
        $query = "UPDATE tasks SET completed = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute([$status, $taskId]);
    }

    public function filterTasks($userId, $priority = null, $status = null, $dueOrder = null){
        $query = "SELECT * FROM tasks WHERE user_id = ?";
        $params = [$userId];

        if($priority !== null && $priority !== ''){
            $query .= "AND priority = ?";
            $params[] = $priority;
        
        }
        
        if($status !== null && $status !== ''){
            $query .= "AND completed = ?";
            $params[] = $status;
        }

        if($dueOrder === 'asc'){
            $query .= " ORDER BY due_date ASC";
        } elseif($dueOrder === 'desc'){
            $query .= " ORDER BY due_date DESC";
        }else{
            $query .= " ORDER BY created_at DESC";
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}