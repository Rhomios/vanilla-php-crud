<?php

require_once __DIR__ . '/../Controllers/NotesController.php';
class NotesRouter
{
    private $controller;

    public function __construct(NoteController $controller)
    {
        $this->controller = $controller;
    }

    public function handleRequest()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $urlReq = explode('/', trim($uri, '/'));

        if ($urlReq[0] == 'notes' || ($urlReq[0] == 'index.php' && $urlReq[1] == 'notes')) {
            switch ($method) {
                case 'GET':
                    if (isset($_GET['id'])) {
                        $this->controller->getNoteById($_GET['id']);
                    } else {
                        $this->controller->getAllNotes();
                    }
                    break;
    
                case 'POST':
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->controller->createNote($data);
                    break;
    
                case 'PUT':
                    $id = $_GET['id'];
                    $data = json_decode(file_get_contents('php://input'), true);
                    $this->controller->updateNote($id, $data);
                    break;
    
                case 'DELETE':
                    $id = $_GET['id'];
                    $this->controller->deleteNote($id);
                    break;
    
                default:
                    echo json_encode(['error' => 'Unsupported method']);
                    break;
            }
        }   
    }
}
