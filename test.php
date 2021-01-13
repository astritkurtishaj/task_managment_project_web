<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>

<div class="container pt-4">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Add New Task</button>
</div>
    <div class="container">
        <ul class="list-group pt-2">
            <li class="list-group-item">
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 ">
                    <h5 class="card-title">Title</h5>
                    <p class="card-text">Description</p>
                </div>
                    <div class="p-2">
                        <select class="form-select  p-2" aria-label="Default select example">
                            <option value="1" >One</option>
                            <option value="2" >Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div>
                <div class="p-2">
                    <button type="button" class="btn btn-danger">Delete</button>
                </div>
                </div>
            </li>
        </ul>   
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</body>
</html>


