<?php
class DatabaseConnectionException extends Exception {
    protected $details;
    public function __construct($details) {
        $this->details = $details;
    }

    public function __toString() {
        return 'Exception: ' . $this->details;
    }

}
