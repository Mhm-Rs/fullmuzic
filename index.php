<?php
require_once "admin/database.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>ZoO albums</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/styles.css">
</head>

<!-- //*Barre de navigation avec les différentes catégories -->

<body class="container">

    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="#" class="navbar-brand">fUll MuZiC</a>
            </div>
            <ul class="nav navbar-nav navbar-right">

                <?php
                //*connexion à la base de données
                $db = Database::connect();

                //* récupération des catégories et leurs id

                //*ligne permettant de récupérer
                $statement = $db->query("SELECT * from genres");

                //*récupération
                $genres = $statement->fetchAll();

                //*afficher toutes les catégories, la première étant active (conversion du html en php)
                foreach ($genres as $genre) {
                    if ($genre["id"] == "1") {
                        echo '<li role="presentation" class="active" data-genres="' . $genre["id"] . '">';
                        echo '<a data-toggle="tab" href="#' . $genre["id"] . '">' . $genre["name"] . '</a></li>';
                    } else {
                        echo '<li role="presentation" data-genres="' . $genre["id"] . '">';
                        echo '<a data-toggle="tab" href="#' . $genre["id"] . '">' . $genre["name"] . '</a></li>';
                    }
                }
                ?>


            </ul>
        </div>
    </nav>
    <div class="tab-content">
        <?php
        //* Afficher une tab pane active ou non en fonction de la catégorie
        foreach ($genres as $genre) {
            if ($genre["id"] == "1") {
                echo '<div class="tab-pane active" id="' . $genre["id"] . '">';
            } else {
                echo '<div class="tab-pane" id="' . $genre["id"] . '">';
            }

            //* ligne du contenu
            echo '<div class ="row">';

            //* récupérer toutes les infos à afficher:
            $statement = $db->prepare("SELECT * from albums where albums.genre = ?");
            $statement->execute(array($genre["id"]));

            //*afficher les éléments tant qu'il y en a 
            while ($item = $statement->fetch()) {
                echo '<div class="col-xs-12 col-md-6">';
                echo '<div class="thumbnail">';
                echo '<img src="images/' . $item["image"] . '" alt="' . $item["name"] . '"> ';
                echo '<div class="prize">' . $item["price"] .  '€</div>';
                echo ' <div class="caption"> ';
                echo ' <h4>' . $item["name"] . '</h4>';
                echo ' <p><i>Artiste: </i>' . $item["artist"] . '</p>';
                echo ' <button type="button" class="btn btn-order button-modal" data-toggle="modal" data-target="#elt' . $item["id"] . '">
                                Voir le détail
                            </button>';
                echo ' </div>
                    </div>
                </div>';
            }
            //*fermer la row
            echo '</div>';

            //*fermer le tabpane
            echo '</div>';
        }


        // *La modal qui apparaît au click sur "voir le détail", gérée pour chaque album de la bdd
        $statement = $db->query("SELECT * from albums");
        $items = $statement->fetchAll();
        foreach ($items as $item) {
            echo '<div class="modal fade" id="elt' . $item["id"] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"> ';
            echo '<div class="modal-dialog" role="document">';
            echo '   <div class="modal-content">';
            echo ' <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel' . $item["id"] .'">'  . $item["name"] .  '</h4>
            </div>';
            echo '<div class="modal-body">
                <div class="thumbnail">';
            echo '<img class="image" src="images/' . $item["image"] . '" alt="' . $item["name"] . '"> ';
            echo '<div class="prize">' . $item["price"] .  '€</div>
                    <div class="caption">';
            echo ' <h4><span class="titre">' . $item["name"] . '</span> (<span class="annee">' . $item["year"] . '</span>)</h4>';
            echo ' <p><i>Artiste: </i><b class="artist">' . $item["artist"] . '</b></p>';
            echo '<p class="description"></p>
                        <p><a class="btn btn-order" role="button" href="#">Acheter</a></p>
                    </div>
                </div>
            </div>';
            echo ' <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>';
            echo ' </div>
                     </div>
                     </div>';
        }

        Database::disconnect();
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</body>

</html>