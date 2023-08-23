<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Todo List</span>
        </div>
    </nav>
    <div class="card">
        <div class="card-header">
            Your Todos
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "todo_app");

                if (!$conn) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                if (isset($_POST['delete'])) {
                    $todoId = $_POST['delete'];
                    $sql = "DELETE FROM todos WHERE id = $todoId";
                    mysqli_query($conn, $sql);
                }

                if (isset($_POST['todo'])) {
                    $todo = $_POST['todo'];
                    $sql = "INSERT INTO todos (task, status) VALUES ('$todo', 0)";
                    mysqli_query($conn, $sql);
                }

                if (isset($_POST['update_status'])) {
                    $todoId = $_POST['update_status'];
                    $sql = "UPDATE todos SET status = NOT status WHERE id = $todoId";
                    mysqli_query($conn, $sql);
                }

                $result = mysqli_query($conn, "SELECT * FROM todos");

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li class="list-group-item">
        <div class="form-check">
            <form method="post" style="display: inline;">
                <input type="hidden" name="update_status" value="' . $row['id'] . '">
                <input class="form-check-input" type="checkbox" value="1" name="status" 
                ' . ($row['status'] ? 'checked' : '') . ' onchange="this.form.submit()">
                <label class="form-check-label">
                    ' . $row['task'] . '
                </label>
            </form>
            <form method="post" style="display: inline;">
                <input type="hidden" name="delete" value="' . $row['id'] . '">
                <button class="btn btn-sm" type="submit" style="color: red">Delete</button>
            </form>
        </div>
    </li>';
                }


                $_POST['todo'] = "";
                $_POST['update_status'] = "";
                $_POST['delete'] = "";

                mysqli_close($conn);
                ?>
            </ul>

            <form method="post">
                <div class="input-group mb-3">
                    <span class="input-group-text">New Todo</span>
                    <input type="text" class="form-control" name="todo">
                    <button class="btn btn-primary" type="submit">Add</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>