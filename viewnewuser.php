<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>TP10</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
          integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
            integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
            crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
            integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
            crossorigin="anonymous"></script>
</head>
<body>

    <div class="container">
        <div class="row">
            <div class="col col-md-12" style="text-align: center">
                <h1>Ajout utilisateur</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <form action='controller.php?func=ajout_new_utilisateur' method="post">
                    <div class="form-group">
                        <label for="fname">Nom</label>
                        <input class="form-control" type="text" name="fname" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Prénom</label>
                        <input class="form-control" type="text" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="mail">mail</label>
                        <input class="form-control" type="text" name="mail" required>
                    </div>
                    <div class="form-group">
                        <label for="citation">login</label>
                        <input class="form-control" type="text" name="login" required>
                    </div>
                    <div class="form-group">
                        <label for="citation">password</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>


                    <input type="submit" class="btn btn-primary" value="Ajouter"/>
                    <?php echo $_POST["login"];?>
                </form>
            </div>

        </div>
    </div>

</body>
</html>

