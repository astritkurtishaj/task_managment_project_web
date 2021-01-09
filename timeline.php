<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<section class="container-fluid">
    <section class="row justify-content-center">
        <section class="col-12 col-sm-8 col-md-5">
        <h5>Task Management - ADD TASK</h5>
            <form class="form-container-add-task col-12">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="title">
                    <label for="description">Description</label>
                    <textarea id="description" class="form-control" name="description" rows="4" cols="55.7">
                    </textarea>
                </div>
                <div class="form-group">
                    <label for="status">Status</label><br>
                    <select name="status" class="form-control">
                        <option value="toDo">To Do</option>
                        <option value="inProgress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary" id="btn-add">Add Task</button>
            </form>
        </section>
    </section>
</section>
</body>
</html>