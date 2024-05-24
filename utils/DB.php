<?php

namespace Utils;

use \PDO;
use PDOException;

class DB
{
	public PDO $pdo;
    private string $dsn = 'mysql:dbname=optimy;host=127.0.0.1';
    private string $user = 'root';
    private string $password = '';
	private static DB $instance;

	protected function __construct()
	{
        try {
            $this->pdo = new \PDO($this->dsn, $this->user, $this->password);
        }catch (PDOException $ex) {
            die("Database Connection: Error " . $ex->getMessage());
        }
	}

	public static function getDBInstance(): self
	{
        if (self::$instance === null) {
            self::$instance = new self();
        }

		return self::$instance;
	}

	public function select(string $sql): array|false
	{
		$sth = $this->pdo->query($sql);
		return $sth->fetchAll();
	}

	public function exec(string $sql): false|int
	{
		return $this->pdo->exec($sql);
	}

	public function lastInsertId(): int|false
	{
		return $this->pdo->lastInsertId();
	}
}