<?php
include 'tasks.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $description = $_POST['description'];
        createTask($title, $description);
    } elseif (isset($_POST['update'])) {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        updateTask($id, $title, $description);

        // Adiciona a linha abaixo para redirecionar após a atualização
        header("Location: index.php");
        exit(); // Certifica-se de encerrar a execução após o redirecionamento

    } elseif (isset($_POST['delete'])) {
        $id = $_POST['id'];
        deleteTask($id);
    } elseif (isset($_POST['custom_update'])) {
        // Lógica para lidar com a operação 'custom_update'
        // ...
    }
}

$tasks = readTasks();

?>

<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #3498db;
            color: #fff;
            margin: 20px;
        }

        h1, h2 {
            text-align: center;
        }

        form {
            margin-bottom: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label, textarea, strong, p {
            color: #000; 
        }

        textarea {
            margin-top: 5px; 
            margin-bottom: 5px;
            width: 100%;
            height: 40px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            background-color: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        li strong {
            font-size: 1.2em;
        }

        li p {
            margin-top: 10px;
            flex-grow: 1;
        }

        li button {
            margin-top: 10px;
            cursor: pointer;
            background-color: #e74c3c;
            border: none;
            color: #fff;
            padding: 5px 10px;
            border-radius: 3px;
            transition: background-color 0.3s ease;
        }

        li button:hover {
            background-color: #c0392b;
        }

        button[name="create"], button[name="update"] {
            background-color: #2ecc71;
        }

        button[name="create"]:hover, button[name="update"]:hover {
            background-color: #27ae60;
        }
    </style>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto;">
        <h1>Gerenciador de Tarefas</h1>

        <h2>Adicionar Tarefa</h2>
        <form action="index.php" method="post">
            <label for="title">Título:</label>
            <input type="text" id="title" name="title" required>
            <label for="description">Descrição:</label>
            <textarea id="description" name="description"></textarea>
            <button type="submit" name="create">Adicionar Tarefa</button>
        </form>

        <h2>Lista de Tarefas</h2>
        <ul>
          <?php foreach ($tasks as $index => $task): ?>
                <li>
                    <strong><?= $task['title']; ?></strong>
                    <p><?= $task['description']; ?></p>
                    <form action="index.php" method="post">
                        <input type="hidden" name="id" value="<?= $task['id']; ?>">
                        <button type="submit" name="delete">Excluir</button>
                    </form>
                    <button onclick="editTask(<?= $task['id']; ?>, '<?= $task['title']; ?>', '<?= $task['description']; ?>')">Editar</button>
                </li>
           <?php endforeach; ?>
        </ul>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        function editTask(id, title, description) {
            const newTitle = prompt('Novo título:', title);
            const newDescription = prompt('Nova descrição:', description);

            if (newTitle !== null && newDescription !== null) {
                $.post('index.php', {
                    id: id,
                    title: newTitle,
                    description: newDescription,
                    update: true
                }, function (data) {
                    window.location.href = 'index.php';
                }).fail(function (error) {
                    console.error('Erro:', error.statusText);
                });
            }
        }

    </script>
</body>
</html>
