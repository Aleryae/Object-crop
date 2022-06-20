<?php
    function loadClass($class){
        require $class.'.php';
    }

    spl_autoload_register('loadClass');

    if (isset($_POST['submit'])){
        if(isset($_FILES['photo']) && $_FILES['photo'] != NULL) {
            $dossier = 'images';
            $identifiant = time();
            $nom = $identifiant;
            $extensions_valides = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
            $extension_upload = substr(strrchr($_FILES['photo']['name'],'.'),1);

             if(in_array($extension_upload, $extensions_valides)) {
                $nom = $nom.'.'.$extension_upload;
                $chemin = $dossier."/".$nom;
                $original = $chemin;

                $resultat = move_uploaded_file($_FILES['photo']['tmp_name'], $chemin);
                if($resultat) {
                    echo '<br />Transfert reussi<br />';
                    $crop1 = new Crop(Crop::CROP_XS, Crop::CROP_MIDDLE, 'images/');
                    $crop1->cropImg($original);
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
        <form method="post" enctype="multipart/form-data">
            <div class="input-group">
                <div class="form-group">
                    <h4>Image</h4>
                    fichier : <input name="photo" type="file">
                </div>
                <button type="submit" name="submit">Click</button>
            </div>
        </form>
    </body>
</html>