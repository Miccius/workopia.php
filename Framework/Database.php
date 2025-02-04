<?php
namespace Framework;

use PDO;

class Database
{
    public $conn;

    public function __construct($config)
    {
        $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        ];
        try {
            $this->conn = new PDO($dsn, $config['username'], $config['password'], $options);
        } catch (\PDOException $e) {
            throw new \Exception("Database connection failed: {$e->getMessage()}");
        }
    }

    public function query($query, $params = [])
    {
        try {
            $sth = $this->conn->prepare($query);

            // Validate placeholders
            preg_match_all('/:([a-zA-Z0-9_]+)/', $query, $matches);
            $placeholders = array_unique($matches[1]);
            foreach ($placeholders as $placeholder) {
                if (!array_key_exists($placeholder, $params)) {
                    throw new \Exception("Missing parameter for placeholder ':{$placeholder}' in query.");
                }
            }

            // Log the query and parameters
            error_log("Executing query: {$query}");
            error_log("Parameters: " . json_encode($params));

            // Bind named params
            foreach ($params as $param => $value) {
                $sth->bindValue(':' . $param, $value);
            }
            $sth->execute();
            return $sth;
        } catch (\PDOException $e) {
            throw new \Exception("Query failed to execute: {$e->getMessage()}\nQuery: {$query}\nParams: " . json_encode($params));
        }
    }

    public function fetchAll($query, $params = [])
    {
        $sth = $this->query($query, $params);
        return $sth->fetchAll();
    }

    public function beginTransaction()
    {
        $this->conn->beginTransaction();
    }

    public function commit()
    {
        $this->conn->commit();
    }

    public function rollBack()
    {
        $this->conn->rollBack();
    }
}