<?php

class NoteController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAllNotes()
    {
        $query = "SELECT * FROM note";
        $statement = $this->pdo->query($query);
        $notes = $statement->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($notes, JSON_UNESCAPED_UNICODE);
    }

    public function getNoteById($id)
    {
        $query = "SELECT * FROM note WHERE id = $id";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $note = $statement->fetch(PDO::FETCH_ASSOC);
        echo json_encode($note, JSON_UNESCAPED_UNICODE);
    }

    public function createNote($data)
    {
        $query = "INSERT INTO note (title, content) VALUES (:title, :content)";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':title', $data['title']);
        $statement->bindParam(':content', $data['content']);
        $statement->execute();
        echo json_encode(['message' => 'Note has been created']);
    }

    public function updateNote($id, $data)
    {
        $query = "UPDATE note SET title = :title, content = :content WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':title', $data['title']);
        $statement->bindParam(':content', $data['content']);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        echo json_encode(['message' => "Note with id: $id has been updated"]);
    }

    public function deleteNote($id)
    {
        $query = "DELETE FROM note WHERE id = :id";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        echo json_encode(['message' => "Note with id: $id has been deleted"]);
    }
}
