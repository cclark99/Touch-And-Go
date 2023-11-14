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
$stmt = $pdo->prepare("
    SELECT 
        student.userId AS studentUserId, student.firstName AS studentFirstName, student.lastName AS studentLastName, student.userEmail AS studentUserEmail, student.userType AS studentUserType,
        professor.userId AS professorUserId, professor.firstName AS professorFirstName, professor.lastName AS professorLastName, professor.userEmail AS professorUserEmail, professor.userType AS professorUserType,
        admin.userId AS adminUserId, admin.firstName AS adminFirstName, admin.lastName AS adminLastName, admin.userEmail AS adminUserEmail, admin.userType AS adminUserType,
        user.userId AS userUserId, user.firstName AS userFirstName, user.lastName AS userLastName, user.userEmail AS userUserEmail, user.userType AS userUserType
    FROM user
    LEFT JOIN student ON user.userId = student.userId
    LEFT JOIN professor ON user.userId = professor.userId
    LEFT JOIN admin ON user.userId = admin.userId
    WHERE 
        student.firstName LIKE ? OR student.lastName LIKE ? OR student.userEmail LIKE ? OR student.userType LIKE ? OR
        professor.firstName LIKE ? OR professor.lastName LIKE ? OR professor.userEmail LIKE ? OR professor.userType LIKE ? OR
        admin.firstName LIKE ? OR admin.lastName LIKE ? OR admin.userEmail LIKE ? OR admin.userType LIKE ? OR
        user.firstName LIKE ? OR user.lastName LIKE ? OR user.userEmail LIKE ? OR user.userType LIKE ?
");

$stmt->execute([
    "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%",
    "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%",
    "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%",
    "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%", "%" . $_POST["search"] . "%"
]);

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST["ajax"])) {
    echo json_encode($results);
}
?>
