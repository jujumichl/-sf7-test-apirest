# Suppression d'une Fiche Forfait
<table>
    <tr>
        <td>Titre</td>
        <td>Supprimer une fiche frais forfait</td>
    </tr>
    <tr>
        <td>URL</td>
        <td>/fraisforfait/:id</td>
    </tr>
    <tr>
        <td>Méthode</td>
        <td>DELETE</td>
    </tr>
    <tr>
        <td>Paramètres d&#39;URL</td>
        <td>:id de type string sur 3 caractères majuscules</td>
    </tr>
    <tr>
        <td>Payload (données du corps de requête)</td>
        <td>Aucun</td>
    </tr>
    <tr>
        <td>Réponse en cas de réussite</td>
        <td>Retourne le code statut 200 avec un libellé <br>
            Code Status : 200   <br>
            {<br>
                "message": "Frais forfait supprimé"<br>
            } </td>
    </tr>
    <tr>
        <td>Réponse en cas d'échec</td>
        <td>Retourne le code statut 404 si l'identifiant demandé n'existe pas <br>
        Code Status : 404<br>
        {<br>
            "message": "Id frais forfait inexistant"<br>
        }
        </td>
    </tr>
    <tr>
    <td>Exemple complet<td>
    <td>Requête émise :<br>
    DELETE /fraisforfait/NUI<br>
    Réponse reçus :<br>
    Code status : 200<br>
    Contenue : <br>
    {<br>
        "message": "Frais forfait supprimé"<br>
    }<br>
    *****************<br>
    Requête émise :<br>
    DELETE /fraisforfait/ABC<br>
    Réponse reçus :<br>
    Code status : 404<br>
    Contenue : <br>
    {<br>
        "message": "Id frais forfait inexistant"<br>
    }<br>
    </td>
</table>


-------
Pour supprimer une fiche forfait il faut appeler 
filtrer les FF sur libelle + doc