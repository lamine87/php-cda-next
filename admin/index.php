<!DOCTYPE html>
<html lang="en">
<head>
    
   <?php 
    if(file_exists('./inc/_head.php')) include'./inc/_head.php';
   ?>

    <title>Document</title>
</head>
<body>
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
        </div>

        <div class="modal-body">
            <form action="" method="post" enctype="multipart/form">
                <div class="form-group">
                    <label for="login">Login :</label>
                    <input type="text" name="login" id="login" class="form-control" placeholder="Login">
                </div>
                <div class="form-group">
                    <label for="password">Password :</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-info mt-3">Connexion</button>
            </form>
        </div>
    </div>
    </div>
</body>
</html>