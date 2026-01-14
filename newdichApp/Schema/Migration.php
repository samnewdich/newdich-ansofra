<?php
namespace NewdichSchema;
// MANUAL INCLUDES (REQUIRED)
require_once __DIR__ . '/Settings.php';
require_once __DIR__ . '/Platform.php';

use NewdichSchema\Settings;
use NewdichSchema\Platform;
use PDO;
use PDOException;

//NOTE: WHEN PUSHING TO PRODUCTION, COMMENT OUT OR DELETE THE createDB() and createTB() methods

class Migration{
    private $table;
    private $columns = [];
    private $rows = [];
    private $conn;
    private $conndb;


    public function __construct(?array $columns = null, ?string $table = null)
    {
        // Assign only if provided
        if ($table !== null) {
            $this->table = $table;
        }

        if ($columns !== null) {
            $this->columns = $columns;
        }
        
        $rootDir ="/"; //the root directory of the project
        //$rootDir can be / and it can be something like /vtu
        //for example, let's say you have one server/host and you have many project in it.
        //Example, in your localhost(/var/www/html), let's say you have 3 different projects:
        //ecommerce, vtu, fintech.
        //inside your localhost(/var/www/html), you will have
        // var/www/html/ecommerce
        // var/www/html/vtu
        // var/www/html/fintech
        //so, for ecommerce, the root directory is /ecommerce
        //for vtu, the root directory is /vtu and for fintech the root directory is /fintech
        //and if it is only one project you have, and the one project is inside (/var/www/html)
        // then the root directory will be /

        require $_SERVER["DOCUMENT_ROOT"] . $rootDir."/Schema/Dealer.php";
        $this->conn = $connnewdich;
        $this->conndb = $connnewdichdb;
    }


    public function createDB(string $dbname)
    {
        $dbname = preg_replace('/[^a-zA-Z0-9_]/', '', $dbname);

        $sql = "CREATE DATABASE IF NOT EXISTS `$dbname`
                CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

        $this->conndb->exec($sql);
        echo "Database $dbname successfully created";
        exit;
    }



    public function createTB()
    {
        $columns = array_filter($this->columns);

        if (empty($columns)) {
            throw new Exception("No columns supplied");
        }

        $columnsSQL = implode(",\n", $columns);

        $sql = "
            CREATE TABLE IF NOT EXISTS `{$this->table}` (
                $columnsSQL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ";

        // DEBUG (use once)
        // echo "<pre>$sql</pre>"; exit;

        $this->conn->exec($sql);
        echo "Table $usableTable was created successfully";
        exit;
    }



    public function getTableColumns(PDO $pdo, string $table): array
    {
        //sanitize table name
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);

        $stmt = $pdo->query("DESCRIBE `$table`");

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }



    public function saveUnique(string $uniqueCol, $uniqueValue, array $rowsInKeyValue)
    {
        try {
            if (empty($rowsInKeyValue)) {
                return [
                    "status" => "failed",
                    "response" => "No data supplied"
                ];
            }

            //get table columns
            $columns = $this->getTableColumns($this->conn, $this->table);
            //print_r($columns);

            //VALIDATE UNIQUE COLUMN
            if (!in_array($uniqueCol, $columns, true)) {
                return [
                    "status" => "failed",
                    "response" => "Invalid unique column"
                ];
            }

            //FILTER ONLY ALLOWED COLUMNS
            $data = [];
            foreach ($rowsInKeyValue as $col => $val) {
                if (in_array($col, $columns, true)) {
                    $data[$col] = $val;
                }
            }

            if (empty($data)) {
                return [
                    "status" => "failed",
                    "response" => "No valid columns supplied"
                ];
            }

            $table = $this->table;

            //DUPLICATE CHECK
            $check = $this->conn->prepare(
                "SELECT 1 FROM `$table` WHERE `$uniqueCol` = :val LIMIT 1"
            );
            $check->bindValue(':val', $uniqueValue);
            $check->execute();

            if ($check->fetchColumn()) {
                return [
                    "status" => "failed",
                    "response" => "duplicate entry"
                ];
            }

            //BUILD INSERT
            $cols = array_keys($data);
            $placeholders = array_map(fn($c) => ":$c", $cols);

            $sql = "INSERT INTO `$table` (`" . implode('`,`', $cols) . "`)
                    VALUES (" . implode(',', $placeholders) . ")";

            $stmt = $this->conn->prepare($sql);

            foreach ($data as $col => $val) {
                $stmt->bindValue(":$col", $val);
            }

            $stmt->execute();

            return [
                "status" => "success",
                "response" => "saved successfully",
                "id" => $this->conn->lastInsertId()
            ];

        } catch (PDOException $e) {
            return [
                "status" => "failed",
                "response" => $e->getMessage()
            ];
        }
    }





    public function save(array $rowsInKeyValue)
    {
        try {

            if (empty($rowsInKeyValue)) {
                return [
                    "status" => "failed",
                    "response" => "No data supplied"
                ];
            }

            //get table columns
            $columns = $this->getTableColumns($this->conn, $this->table);

            //FILTER ONLY ALLOWED COLUMNS
            $data = [];
            foreach ($rowsInKeyValue as $col => $val) {
                if (in_array($col, $columns, true)) {
                    $data[$col] = $val;
                }
            }

            if (empty($data)) {
                return [
                    "status" => "failed",
                    "response" => "No valid columns supplied"
                ];
            }


            $table = $this->table;

            //BUILD INSERT
            $cols = array_keys($data);
            $placeholders = array_map(fn($c) => ":$c", $cols);

            $sql = "INSERT INTO `$table` (`" . implode('`,`', $cols) . "`)
                    VALUES (" . implode(',', $placeholders) . ")";

            $stmt = $this->conn->prepare($sql);

            foreach ($data as $col => $val) {
                $stmt->bindValue(":$col", $val);
            }

            $stmt->execute();

            return [
                "status" => "success",
                "response" => "saved successfully"
            ];

        } catch (PDOException $e) {
            return json_encode([
                "status" => "failed",
                "response" => $e->getMessage()
            ], JSON_PRETTY_PRINT);
        }
    }




    public function get(array $where = [], int $offset = 0, int $limit = 20)
    {
        try {
            $table = $this->table;
            $sql = "SELECT * FROM `$table`";
            $binds = [];

            if (!empty($where)) {
                $conditions = [];
                foreach ($where as $col => $val) {
                    $conditions[] = "`$col` = :$col";
                    $binds[":$col"] = $val;
                }
                $sql .= " WHERE " . implode(" AND ", $conditions);
            }

            $sql .= " LIMIT $offset, $limit";

            $stmt = $this->conn->prepare($sql);
            foreach ($binds as $k => $v) {
                $stmt->bindValue($k, $v);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }






    public function remove(array $where)
    {
        try {
            $table = $this->table;
            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "`$col` = :$col";
            }

            $sql = "DELETE FROM `$table` WHERE " . implode(" AND ", $conditions) . " LIMIT 1";
            $stmt = $this->conn->prepare($sql);

            foreach ($where as $col => $val) {
                $stmt->bindValue(":$col", $val);
            }

            $stmt->execute();
            return ["status" => "success", "deleted" => $stmt->rowCount()];

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }




    public function edit(array $data, array $where)
    {
        try {
            $table = $this->table;

            $set = [];
            foreach ($data as $col => $val) {
                $set[] = "`$col` = :set_$col";
            }

            $conditions = [];
            foreach ($where as $col => $val) {
                $conditions[] = "`$col` = :where_$col";
            }

            $sql = "UPDATE `$table` SET " . implode(',', $set)
                . " WHERE " . implode(' AND ', $conditions)
                . " LIMIT 1";

            $stmt = $this->conn->prepare($sql);

            foreach ($data as $col => $val) {
                $stmt->bindValue(":set_$col", $val);
            }
            foreach ($where as $col => $val) {
                $stmt->bindValue(":where_$col", $val);
            }

            $stmt->execute();
            return ["status" => "success", "updated" => $stmt->rowCount()];

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }




    
}
?>