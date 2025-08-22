<?php
// Si le fichier __DIR__.'/config_ok' existe, interdiction de revenir ici !
if(file_exists(__DIR__.'/config_ok')) { header("location:index.php"); }

if(sizeof($_POST)) { 
    if(!empty($_POST['host']) && !empty($_POST['apikey'])) {
        if(!empty($_POST['lights'])) {
            $defaults = array(
                CURLOPT_POST => 1,
                CURLOPT_HEADER => 0,
                CURLOPT_URL => "http://webserver2:8080/config.php",
                CURLOPT_FRESH_CONNECT => 1,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FORBID_REUSE => 1,
                CURLOPT_TIMEOUT => 4,
                CURLOPT_POSTFIELDS => http_build_query(['host' => $_POST['host']??"", 'apikey' => $_POST['apikey']??"", 'lights' => $_POST['lights']??[]])
            );
            $ch = curl_init();
            curl_setopt_array($ch,$defaults);
            $result = curl_exec($ch);
            curl_close($ch);
            if($result == 'ok') {
                file_put_contents(__DIR__.'/config_ok', "");
                header("location:index.php");
            } else {
                $messageError = 'Le serveur lumiere du challenge n\'a pas réussi à créer le script souhaité !';
            }
        } else {
            $messageError = 'Vous devez sélectionner des lumières !';
        }
    } 
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration challenge</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        form {
            width: 680px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        label:not(.inline) {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        label small {
            font-weight: normal;
        }


        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        input[type="text"]:disabled,
        input[type="email"]:disabled,
        input[type="password"]:disabled {
            background-color: #f5f5f5;
        }

        button[type="button"]:not(.no_style),
        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 3px;
            font-size: 16px;
            cursor: pointer;
        }

        button[type="button"]:hover,
        button[type="submit"]:hover {
            background-color: #0056b3;
        }
        #btn_help { float: right;}

        .error {
            background-color: #f44336; /* Couleur de fond rouge */
            color: #fff; /* Couleur du texte blanc */
            padding: 10px; /* Marge intérieure pour l'espace autour du texte */
            border: 1px solid #d32f2f; /* Bordure rouge */
            border-radius: 4px; /* Coins arrondis */
            margin-bottom: 10px; /* Marge en bas pour séparer d'autres éléments */
            font-size: 16px; /* Taille de police */
            text-align: center; /* Centrer le texte horizontalement */
            max-width:500px;
            margin:auto;
            margin-bottom:20px;
        }
    </style>
</head>
<body>
    <h1>Configurez le challenge</h1>
    <?php if (isset($messageError)) : ?>
        <div class="error"><?= htmlspecialchars($messageError); ?></div>
    <?php endif; ?>
    <form action="init.php" method="post">
        <button type="button" class="no_style" id="btn_help">📌</button>
        <pre id="help" style="display:none;">
            <strong>Récupérer l'API_KEY de votre pont Philips Hue</strong>
            Mettez votre pont en appairage (en appuyant sur le bouton)
            Exécuter une requête POST avec la chaîne json suivante : 
            {"devicetype":"my_hue_app#nom_de_l_appareil"} sur l’url :
            http://<b>IP_PONT</b>/api/

            Si vous recevez une réponse de type :
            [{"error":{"type":101,"address":"","description":"link button not pressed"}}]

            c’est que le pont n’était pas en attente d’appairage !

            Si tout c’est bien passé vous recevez une réponse du type :
            [
                {
                    "success": {
                        "username": "API_KEY"
                    }
                }
            ]
        </pre>
    
        <label for="host">Adresse IP (ou host sans protocol) de votre pont Philips Hue :</label>
        <input type="text" id="host" name="host" value="<?= htmlspecialchars($_POST['host']??"") ?>" required>
        <br><br>

        <label for="apikey">Votre API_KEY Philips Hue :</label>
        <input type="text" id="apikey" name="apikey" value="<?= htmlspecialchars($_POST['apikey']??"") ?>" required><br><br>

        <div style="width:100%; text-align:center;">
            <button type="button" id="searchLights">Choisir les ampoules</buttton>
        </div>
        <hr /> 
        <template id="lights_tpl">
            <p>
                <button type="button" class="no_style btn_test">💡</button>
                <label class="inline"><span class="name"></span>
                    <input type="checkbox" name="lights[]" class="checkbox">
                </label>
            </p>   
        </template>
        <div id="ligths">
        <!-- Les boutons radio seront créés ici -->
        </div>

        <div style="width:100%; text-align:center;">
            <button type="submit">Enregistrer</buttton>
        </div>
    </form>

    <script>
        let btnHelp = document.getElementById("btn_help");
        let preHelp = document.getElementById("help");
        // Ajoutez un gestionnaire d'événement pour le clic sur le bouton
        btnHelp.addEventListener("click", function() {
            // Vérifiez si le style "display" est actuellement "none"
            if (preHelp.style.display === "none") {
                // Si oui, affichez l'élément <pre>
                preHelp.style.display = "block";
            } else {
                // Sinon, masquez l'élément <pre>
                preHelp.style.display = "none";
            }
        });

        let host = document.getElementById("host");
        let search = document.getElementById("searchLights");
        let apikey = document.getElementById("apikey");
        // Fonction pour activer le champ "flag" au double-clic
        search.addEventListener("click", function() {
           if(apikey.value=="" || host.value=="") {
                alert("Vous devez saisir les valeurs des champs host et apikey");
           } else {
                fetch(`http://${host.value}/api/${apikey.value}/lights`).then(res => res.json()).then(jsonData => {

                    const lightsContainer = document.getElementById('ligths');
                    lightsContainer.innerHTML = ""; // on vide les données
                    const template = document.getElementById('lights_tpl');
                    // Boucle à travers les clés de l'objet JSON
                    for (const key in jsonData) {
                        if (jsonData.hasOwnProperty(key)) {
                            // Clonez le template
                            const clone = document.importNode(template.content, true);

                            // Obtenez les éléments à l'intérieur du template
                            const label = clone.querySelector('label');
                            const nameSpan = clone.querySelector('.name');
                            const checkbox = clone.querySelector('.checkbox');
                            const btnTestSpan = clone.querySelector('.btn_test');

                            // Remplissez les éléments avec les données JSON
                            nameSpan.textContent = jsonData[key].name;
                            checkbox.value = key; // Utilisez la clé comme valeur de la case à cocher
                            btnTestSpan.dataset.num = key
                            btnTestSpan.dataset.state = !jsonData[key].state.on;
                            if(btnTestSpan.dataset.state == "true") btnTestSpan.style.background = '#000000';
                            else btnTestSpan.style.background = '#bbbbbb';
                            // Ajoutez le clone du template au conteneur des lumières
                            lightsContainer.appendChild(clone);

                            // allumer / éteindre la lumière
                            btnTestSpan.addEventListener("click", (e) => {
                                let currentLight = e.currentTarget;
                                // Configuration de la requête
                                const options = {
                                    method: 'PUT',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: `{"on": ${currentLight.dataset.state}}`,
                                };
                                fetch(`http://${host.value}/api/${apikey.value}/lights/${currentLight.dataset.num}/state`, options) .then((response) => {
                                    if (!response.ok) throw new Error('La requête a échoué');
                                    return response.text();
                                })
                                .then((responseData) => {
                                     // On inverse la valeur permettant d'allumer et éteindre
                                    if(currentLight.dataset.state == "true") {
                                        currentLight.dataset.state = false;
                                        currentLight.style.background = '#bbbbbb';
                                    }
                                    else {
                                        currentLight.dataset.state = true;
                                        currentLight.style.background = '#000000';
                                    }
                                });                               
                            });
                        }
                    }
                });
            }
        });

    </script>

</body>
</html>