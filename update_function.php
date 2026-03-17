<?php
include("include_files.php"); 

$db = new db();
$con = $db->connect();
$updatedCount = 0;
$errors = [];

try {
    // ✅ Step 1: Get all tables
    $pdo = $con->prepare("SHOW TABLES");
    $pdo->execute();
    $tables = $pdo->fetchAll(PDO::FETCH_COLUMN);

    if (empty($tables)) {
        throw new Exception("No tables found in database.");
    }

    echo "<h3>🛠 Updating default values for database...</h3><br>";

    // ✅ Step 2: Loop through tables
    foreach ($tables as $table) {
        if (!empty($GLOBALS['table_prefix']) && strpos($table, $GLOBALS['table_prefix']) === false) {
            continue;
        }

        $colStmt = $con->prepare("SHOW COLUMNS FROM `$table`");
        $colStmt->execute();
        $columns = $colStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($columns as $col) {
            $field = $col['Field'];
            $type = strtolower($col['Type']);
            $null = $col['Null'];
            $extra = $col['Extra'];
            $default = $col['Default'];
            $alterSQL = "";

            // MEDIUMTEXT → DEFAULT NULL
            if (strpos($type, 'mediumtext') !== false) {
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` MEDIUMTEXT DEFAULT NULL";
            }
            // DATETIME → DEFAULT CURRENT_TIMESTAMP
            elseif (strpos($type, 'datetime') !== false) {
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` DATETIME DEFAULT NULL";
            }
            // DATE → DEFAULT NULL
            elseif (strpos($type, 'date') !== false && strpos($type, 'datetime') === false) {
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` DATE DEFAULT NULL";
            }
            // INT → DEFAULT 0
            elseif (preg_match('/int\((\d+)\)/', $type, $m)) {
                $size = $m[1];
                $notnull = ($null == 'NO') ? 'NOT NULL' : 'NULL';
                $autoinc = ($extra == 'auto_increment') ? 'AUTO_INCREMENT' : '';
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` INT($size) $notnull DEFAULT 0 $autoinc";
            }

            // MEDIUMINT → DEFAULT NULL
            elseif (preg_match('/mediumint\((\d+)\)/', $type, $m)) {
                $size = $m[1];
                $notnull = ($null === 'NO') ? 'NOT NULL' : 'NULL';
                $autoinc = ($extra === 'auto_increment') ? 'AUTO_INCREMENT' : '';
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` MEDIUMINT($size) $notnull DEFAULT NULL $autoinc";
            }

            // DOUBLE / FLOAT / DECIMAL → DEFAULT 0
            elseif (
                strpos($type, 'double') !== false ||
                strpos($type, 'float') !== false ||
                strpos($type, 'decimal') !== false
            ) {
                $notnull = ($null === 'NO') ? 'NOT NULL' : 'NULL';
                $alterSQL = "ALTER TABLE `$table` MODIFY `$field` $type $notnull DEFAULT 0";
            }

            if (!empty($alterSQL)) {
                try {
                    $con->exec($alterSQL);
                    echo "✅ Updated `$field` in `$table`<br>";
                    $updatedCount++;
                } catch (Exception $ex) {
                    $errors[] = "⚠️ Skipped `$field` in `$table`: " . $ex->getMessage();
                }
            }
        }
    }

    echo "<hr>";
    echo "<strong>✅ Total Columns Updated: $updatedCount</strong><br>";

    if (!empty($errors)) {
        echo "<h4>⚠️ Skipped Columns / Errors:</h4>";
        echo "<pre>" . implode("\n", $errors) . "</pre>";
    } else {
        echo "<strong>🎉 All columns updated successfully!</strong>";
    }

} catch (Exception $e) {
    echo "<strong>❌ Error: " . $e->getMessage() . "</strong>";
}
?>
