<?php

class Database
{
    private static $instance = null;
    private $dataDir;

    private function __construct()
    {
        $this->dataDir = __DIR__ . '/../../data/';
        if (!file_exists($this->dataDir)) {
            mkdir($this->dataDir, 0777, true);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function read($table)
    {
        $file = $this->dataDir . $table . '.json';
        if (!file_exists($file)) return [];
        return json_decode(file_get_contents($file), true) ?? [];
    }

    public function write($table, $data)
    {
        $file = $this->dataDir . $table . '.json';
        file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));
    }

    // Simulate Auto Increment
    public function nextId($table)
    {
        $data = $this->read($table);
        $max = 0;
        foreach ($data as $row) {
            if ($row['id'] > $max) $max = $row['id'];
        }
        return $max + 1;
    }
}
