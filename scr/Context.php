<?php

require_once 'Models/Note.php';
require_once 'DataBase/DataBaseConfiguration.php';
require 'DataBase/dbContext.php';
require 'Routes/NotesRouter.php';

class Context extends dbContext {
    private $models = [];
    private $routes = [];
    private function Connect() {
        return new DataBaseConfiguration("localhost", "5432", "notes_db", "postgres", "postgres");
    }

    private function modelConfigurator() {
        $this->models = [new Note()];
    }

    private function RouteRegistrator($pdo) {
        $this->routes['note'] = new NotesRouter(new NoteController($pdo));
    }

    public function handleRequest($route, $method) {
        try {
            $this->routes[$route]->$method();
        } catch (BadMethodCallException $error) {
            die('Incorrect metod called.');
        }
    }

    public function __construct() {
        $dbConfig = $this->Connect();
        $this->modelConfigurator();
        $this->RouteRegistrator($dbConfig->getPDO());

        parent::initDataBase($dbConfig->getPDO(), $this->models);
    }
}