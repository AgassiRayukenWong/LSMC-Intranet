<?php
    session_start();
    require_once "config.php";

    // Info : Si la session existe pas soit si l'on est pas connecté on redirige
    if (!isset($_SESSION["user"])) {
        header("Location: index.php");
        die();
    }

    // Info : Récupération données de l'effectif connecté
    $req = $bdd->prepare("SELECT * FROM effectif WHERE token = ?");
    $req->execute([$_SESSION["user"]]);
    $data = $req->fetch();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Prise de Service</title>
		<link rel="stylesheet" href="./css/style.css">
		<style>
		    body {
		        color: #ffffff;
		        background-color: #01161e;
		    }
		</style>
        <script language="javascript" type="text/javascript">

		    // Info : Gestion d'erreur Prise de Service
			function errorCheck_PriseDeService() {
				var gotStatut
				var gotVehicule
				var gotCommentaire

				gotStatut       = document.forms[0].Statut.value
				gotVehicule     = document.forms[0].Vehicule.value
				gotCommentaire  = document.forms[0].Commentaire.value
				if (gotStatut == "" || gotStatut == null) {
					alert("Merci de choisir un statut valide.")
				}
				if (gotVehicule == "" || gotVehicule == null) {
					alert("Merci de choisir un véhicule valide.")
                }
			}

		    // Info : Gestion d'erreur Mise à Jour
			function errorCheck_MiseAJour() {
				var gotStatut
				var gotVehicule
				var gotCommentaire

				gotStatut       = document.forms[0].Statut.value
				gotVehicule     = document.forms[0].Vehicule.value
				gotCommentaire  = document.forms[0].Commentaire.value
				if (gotStatut == "" || gotStatut == null) {
					alert("Merci de choisir un statut valide.")
				}
				if (gotVehicule == "" || gotVehicule == null) {
					alert("Merci de choisir un véhicule valide.")
                }
			}

		    // Info : Gestion d'erreur Fin de Service
			function errorCheck_FinDeService() {

			}
		</script>
	</head>

	<body style="width: 100%; text-align: center;">
	<?php
        // Info : Donnée de connexion au serveur PHPMyAdmin
        $servername = "localhost";
        $username   = "root";
        $password   = "";
        $dbname     = "lsmc";

        // Info : Méthode dès que l'on appuie sur Prise de Service
        if (isset($_POST["button_PriseDeService"])) {

            // Info : Récupération des paramètres du formulaire
            $nouveauStatut      = $_POST['Statut'];
            $nouveauVehicule    = $_POST['Vehicule'];
            $nouveauCommentaire = $_POST['Commentaire'];

            // Info : Création de la connexion + Vérification de la connexion
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $idEffectifActuel = $data["id"];
            $serviceEffectifActuel = $data["service"];
            $sql    = "UPDATE effectif SET service='1', intervention='$nouveauStatut', vehicule='$nouveauVehicule', commentaire='$nouveauCommentaire', debutservice=now() WHERE id=$idEffectifActuel";
            $sql2   = "INSERT INTO `service` (`id`, `effectif`, `debutservice`, `finservice`, `heure`, `minute`, `dernier`) VALUES (NULL, '2', NOW(), NULL, 0, 0, '1')";

            if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            $conn->close();

            // Info : Actualisation vers la même page pour ne pas duppliquer la requête de formulaire
            header("Location: service.php");
        }

        // Info : Méthode dès que l'on appuie sur Mettre à Jour
        if (isset($_POST["button_MiseAJour"])) {

            // Info : Récupération des paramètres du formulaire
            $nouveauStatut      = $_POST['Statut'];
            $nouveauVehicule    = $_POST['Vehicule'];
            $nouveauCommentaire = $_POST['Commentaire'];

            // Info : Création de la connexion + Vérification de la connexion
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $idEffectifActuel = $data["id"];
            $sql = "UPDATE effectif SET intervention='$nouveauStatut', vehicule='$nouveauVehicule', commentaire='$nouveauCommentaire' WHERE id=$idEffectifActuel";

            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
            } else {
                echo "Error updating record: " . $conn->error;
            }
            $conn->close();

            // Info : Actualisation vers la même page pour ne pas duppliquer la requête de formulaire
            header("Location: service.php");
        }

        if (isset($_POST["button_FinDeService"])) {

            $nouveauStatut      = "";
            $nouveauVehicule    = "";
            $nouveauCommentaire = "";

            // Info : Création de la connexion + Vérification de la connexion
            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
            }

            $idEffectifActuel = $data["id"];
            $sql    = "UPDATE effectif SET service='0', intervention='$nouveauStatut', vehicule='$nouveauVehicule', commentaire='$nouveauCommentaire', debutservice='' WHERE id=$idEffectifActuel";

            $start_datetime = new DateTime($data["debutservice"]);
            $end_datetime   = new DateTime('NOW');
            $difference     = $start_datetime->diff($end_datetime);
            echo $difference->days.' days total<br>';
            echo $difference->y.' years<br>';
            echo $difference->m.' months<br>';
            echo $difference->d.' days<br>';
            echo $difference->h.' hours<br>';
            echo $difference->i.' minutes<br>';
            echo $difference->s.' seconds<br>';
            $heure = $difference->h;
            $minute = $difference->i;
            $seconde = $difference->s;

            $sql2   = "UPDATE service SET finservice=now(), heure=$heure, minute=$minute, seconde=$seconde, dernier='0' WHERE effectif=$idEffectifActuel AND dernier='1' LIMIT 1";

            if ($conn->query($sql) === TRUE && $conn->query($sql2) === TRUE) {
              echo "Record updated successfully";
            } else {
              echo "Error updating record: " . $conn->error;
            }
            $conn->close();

            // Info : Actualisation vers la même page pour ne pas duppliquer la requête de formulaire
            header("Location: service.php");
        }
        ($connect = mysqli_connect("localhost", "root", "")) or die("erreur de connection à MySQL");
        mysqli_select_db($connect, "lsmc") or die("erreur de connexion à la base de données");
        //                                                       0      1          2         3        4      5     6         7        8            9            10          11            12
        $result                 = mysqli_query($connect, "SELECT id, hospital, firstname, lastname, grade, role, agregation, phone, intervention, commentaire, vehicule, debutservice, service FROM effectif WHERE service = true");
        $nbrTotalService        = mysqli_num_rows($result);
        $nbrTotalService_LSMC   = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM effectif WHERE service = true AND hospital = 'lsmc'"));
        $nbrTotalService_BCMC   = mysqli_num_rows(mysqli_query($connect, "SELECT * FROM effectif WHERE service = true AND hospital = 'bcmc'"));
    ?>
    <h4>Prise de service</h4>
    <form method="post" action="service.php" style="width: 100%; text-align: center;">
        <table style="width: 100%; text-align: center;">
            <tbody>
                <tr>
                    <td>
                        Bonjour <?php echo $data["firstname"];?> <?php echo $data["lastname"];?>
                    </td>
                </tr>
                <tr>
                    <td>
                        Satut
                    </td>
                </tr>
                <tr>
                    <td>
                        <select name="Statut">
                            <option value="Code 3">Code 3</option>
                            <option selected="selected" value="Code 6">Code 6</option>
                            <option value="Code 7">Code 7</option>
                            <option value="Code 10">Code 10</option>
                            <option value="Code 15">Code 15</option>
                            <option value="Autopsie">Autopsie</option>
                            <option value="Morgue">Morgue</option>
                            <option value="Fusillade">Fusillade</option>
                            <option value="Consultation">Consultation</option>
                            <option value="Entretien">Entretien</option>
                            <option value="Formation">Formation</option>
                            <option value="Examen">Examen</option>
                            <option value="Rendez-vous">Rendez-vous</option>
                            <option value="Evenement">Évênement</option>
                            <option value="Reunion">Réunion</option>
                            <option value="Gestion Direction">Gestion Direction</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Véhicule utilisé</td>
                </tr>
                <tr>
                    <td>
                        <select name="Vehicule">
                            <option selected="selected" value="Aucune">Aucun</option>
                            <option value="Ambulance 1">Ambulance 1</option>
                            <option value="Ambulance 2">Ambulance 2</option>
                            <option value="Vapide">Vapide</option>
                            <option value="4x4">4x4</option>
                            <option value="Caracara">Caracara</option>
                            <option value="Alamo">Alamo</option>
                            <option value="Predator">Predator</option>
                            <option value="Buffalo Direction">Buffalo Direction</option>
                            <option value="Helicoptere">Helicoptere</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Unité | Remarque | Zone
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="Commentaire"/>
                    </td>
                </tr>
            </tbody>
        </table>
        <?php if($data["service"] === 0) echo '<input type="submit" onmousover="errorCheck_PriseDeService()" name="button_PriseDeService" value="Prise de Service" class="btn btn-danger btn-lg"/>'?>
        <?php if($data["service"] === 1) echo '<input type="submit" onmousover="errorCheck_MiseAJour()" name="button_MiseAJour" value="Mettre à jour" class="btn btn-danger btn-lg"/>'?>
        <?php if($data["service"] === 1) echo '<input type="submit" onmousover="errorCheck_FinDeService()" name="button_FinDeService" value="Fin de service" class="btn btn-danger btn-lg"/>'?>
        <a href="landing.php" class="btn btn-danger btn-lg">Retour Profil</a>
    </form>

    <p>Nombre en Service : <?php echo $nbrTotalService ?></p>
    <p>Nombre en Service LSMC : <?php echo $nbrTotalService_LSMC ?></p>
    <p>Nombre en Service BCMC : <?php echo $nbrTotalService_BCMC ?></p>

    <table border="1" cellpadding="2" cellspacing="2">
                <tr>
                    <th>Id</th>
                    <th>Hôpital</th>
                    <th>Prénom Nom</th>
                    <th>Grade</th>
                    <th>Rôle</th>
                    <th>Agrégations</th>
                    <th>Téléphone</th>
                    <th>Intervention</th>
                    <th>Commentaire</th>
                    <th>Véhicule</th>
                    <th>Début du service</th>
                </tr>
<?php    while ($row = mysqli_fetch_row($result)) {
        $id                 = $row[0];
        $hopital            = $row[1];
        $prenom             = $row[2];
        $nom                = $row[3];
        $grade              = $row[4];
        $role               = $row[5];
        $agregations        = $row[6];
        $phone              = $row[7];
        $intervention       = $row[8];
        $commentaire        = $row[9];
        $vehicule           = $row[10];
        $debutservice       = $row[11];
        $service            = $row[12];

    echo "<tr>
            <td>$id</td>
            <td>$hopital</td>
            <td>$prenom $nom</td>
            <td>$grade</td>
            <td>$role</td>
            <td>$agregations</td>
            <td>$phone</td>
            <td>$intervention</td>
            <td>$commentaire</td>
            <td>$vehicule</td>
            <td>$debutservice</td>
        </tr>";
    }
?>
<?php
    //Déconnexion de la base de données
    mysqli_close($connect);
?>
	</body>
</html>