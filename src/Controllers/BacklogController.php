<?php

require_once __DIR__ . '/../Models/Backlog.php';

class BacklogController {
    private Backlog $backlog;

    public function __construct(Backlog $backlog) {
        $this->backlog = $backlog;
    }

    public function lister(): void {
        echo json_encode($this->backlog->getToutes());
    }
}
