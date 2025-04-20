<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Форма студента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-5">
    <h2 class="mb-4">Добавить информацию о студенте</h2>

    <?php
    $filename = "students.txt";
    $delimiter = " | "; // Разделитель между полями

    // Обработка формы
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = trim($_POST["name"]);
        $age = trim($_POST["age"]);
        $topic = trim($_POST["topic"]);

        if ($name && $age && $topic) {
            $entry = $name . $delimiter . $age . $delimiter . $topic . PHP_EOL;
            file_put_contents($filename, $entry, FILE_APPEND);
            header("Location: " . $_SERVER['PHP_SELF']); // Перезагрузка страницы (чтобы избежать повторной отправки)
            exit();
        } else {
            echo '<div class="alert alert-danger">Пожалуйста, заполните все поля.</div>';
        }
    }
    ?>

    <!-- Форма -->
    <form method="post" class="row g-3 mb-5">
        <div class="col-md-4">
            <label class="form-label">Имя студента</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Возраст</label>
            <input type="text" name="age" class="form-control" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Тема диплома</label>
            <input type="text" name="topic" class="form-control" required>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </form>

    <!-- Вывод данных -->
    <h4>Список студентов</h4>
    <ul class="list-group">
        <?php
        if (file_exists($filename)) {
            $lines = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $lines = array_reverse($lines); // Обратный порядок

            foreach ($lines as $line) {
                echo '<li class="list-group-item">' . htmlspecialchars($line) . '</li>';
            }
        } else {
            echo '<li class="list-group-item">Нет записей</li>';
        }
        ?>
    </ul>
</div>
</body>
</html>