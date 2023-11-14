<?php
// (A) DATABASE CONFIG 
define("DB_HOST", "localhost");
define("DB_NAME", "touch_and_go_test");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "test");
define("DB_PASSWORD", "test123");

// (B) CONNECT TO DATABASE
$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
    DB_USER,
    DB_PASSWORD,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

// (C) SEARCH
$stmt = $pdo->prepare("SELECT student.firstName, student.lastName, professor.firstName, student.lastName, admin.firstName, admin.lastName, user.userEmail, user.userType
                       FROM `student`
                         INNER JOIN user on student.userId = user.userId
                         INNER JOIN professor on professor.userId = user.userId
                         INNER JOIN admin on admin.userId = user.userId
                       WHERE `firstName` LIKE ? OR `lastName` LIKE ? or user.userEmail LIKE ?");
$stmt->execute(["%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%"]);
$results = $stmt->fetchAll();
if (isset($_POST["ajax"])) {
    echo json_encode($results);
}

?>