<?php
// database config 
define("DB_HOST", "localhost");
define("DB_NAME", "touch_and_go_test");
define("DB_CHARSET", "utf8mb4");
define("DB_USER", "test");
define("DB_PASSWORD", "test123");

// connect to database
$pdo = new PDO(
    "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
    DB_USER,
    DB_PASSWORD,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]
);

// search
$stmt = $pdo->prepare("
    SELECT 
        user.userId,
        user.userEmail,
        user.userType,
        student.firstName AS studentFirstName,
        student.lastName AS studentLastName,
        professor.firstName AS professorFirstName,
        professor.lastName AS professorLastName,
        admin.firstName AS adminFirstName,
        admin.lastName AS adminLastName
    FROM user
    LEFT JOIN student ON user.userId = student.userId
    LEFT JOIN professor ON user.userId = professor.userId
    LEFT JOIN admin ON user.userId = admin.userId
    WHERE 
        (user.userEmail LIKE ? OR
        student.firstName LIKE ? OR student.lastName LIKE ? OR
        professor.firstName LIKE ? OR professor.lastName LIKE ? OR
        admin.firstName LIKE ? OR admin.lastName LIKE ?)
        AND (? = '' OR (user.userType = ? AND user.userId != 1))
");

$searchTerm = "%" . $_POST["search"] . "%";
$userType = $_POST["userType"];
$stmt->execute([
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $searchTerm,
    $userType,
    $userType
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["ajax"])) {
    echo json_encode($results);
}
?>