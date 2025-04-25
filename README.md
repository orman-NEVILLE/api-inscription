# Service d'Inscription Étudiant

Ce service PHP permet de gérer les informations des étudiants dans une base de données.

## Fonctionnalités

Le service prend en charge les cas suivants :

### 1. **Récupération de tous les étudiants**
- Retourne tous les étudiants enregistrés dans la base de données.
- **URL** : `https://api-service-inscription.onrender.com/getStudent.php`
- **Méthode** : GET
- **Paramètres** : Aucun.
- **Exemple de réponse** :
  ```json
  {
    "students": [
      {
        "id": 1,
        "nom": "Dupont",
        "postNom": "Jean",
        "preNom": "Pierre",
        "date_naissance": "2000-01-01",
        "option": "Informatique",
        "pourcentage_obtenu": 85,
        "genre": "M",
        "lieu_naissance": "Paris",
        "nationalite": "Française"
      }
    ]
  }

## 2. Récupération d'un étudiant spécifique
Retourne les informations d'un étudiant donné.
URL : https://api-service-inscription.onrender.com/getStudent.php?etudiant_id={id}
Méthode : GET
Paramètres : etudiant_id (ID de l'étudiant).
Exemple de réponse :
Succès :
  {
  "id": 1,
  "nom": "Dupont",
  "postNom": "Jean",
  "preNom": "Pierre",
  "date_naissance": "2000-01-01",
  "option": "Informatique",
  "pourcentage_obtenu": 85,
  "genre": "M",
  "lieu_naissance": "Paris",
  "nationalite": "Française"
}

Echec :
{
  "message": "Étudiant non trouvé"
}

## 3. Ajout d'un nouvel étudiant
Permet d'ajouter un étudiant dans la base de données.
URL :https://api-service-inscription.onrender.com/getStudent.php
Méthode : POST
Données (JSON) :

{
  "nom": "Dupont",
  "postNom": "Jean",
  "preNom": "Pierre",
  "date_naissance": "2000-01-01",
  "option": "Informatique",
  "pourcentage_obtenu": 85,
  "genre": "M",
  "lieu_naissance": "Paris",
  "nationalite": "Française"
}

Exemple de réponse :
Succès :
{
  "success": true,
  "message": "Étudiant ajouté avec succès"
}

Echec : 

{
  "success": false,
  "message": "Champs manquants ou invalides"
}
