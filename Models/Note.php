<?php
class Note {
    private $id = ['title' => 'id', 'type' => 'int', 'autoIncrement' => true, 'primaryKey' => true];
    private $title = ['title' => 'title', 'type' => 'varchar(25)'];
    private $content = ['title' => 'content', 'type' => 'text'];

    public function __construct() {

    }

    public function getAttributes() {
        return [$this->id, $this->title, $this->content];
    }

    public function getModelName() {
        return __CLASS__;
    }

}