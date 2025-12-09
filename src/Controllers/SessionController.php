<?php

class SessionController {

    public function start() {
        session_start();
        echo "Session démarrée";
    }
}
