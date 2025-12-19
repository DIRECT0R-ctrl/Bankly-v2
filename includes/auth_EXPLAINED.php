<?php
/**
 * includes/auth.php
 * 
 * FICHIER D'AUTHENTIFICATION - VERSION EXPLIQUÉE LIGNE PAR LIGNE
 * 
 * Ce fichier gère l'authentification des utilisateurs avec des sessions PHP.
 * Chaque ligne est expliquée en détail pour que tu comprennes VRAIMENT ce qui se passe.
 */

// ============================================================================
// LIGNE 1 : session_start();
// ============================================================================
/**
 * QU'EST-CE QUE ÇA FAIT ?
 * 
 * Cette fonction démarre une session PHP. Voici ce qui se passe VRAIMENT :
 * 
 * 1. PHP génère un ID de session unique (ex: "abc123def456")
 *    - Utilise un générateur cryptographique sécurisé
 *    - Probabilité de collision : 1 sur 2^128 (quasiment impossible)
 * 
 * 2. PHP crée un fichier sur le disque
 *    - Chemin Linux : /tmp/sess_abc123def456
 *    - Chemin Windows : C:\Windows\Temp\sess_abc123def456
 *    - Ce fichier stockera les données de session (sérialisées)
 * 
 * 3. PHP envoie un cookie au navigateur
 *    - Nom : PHPSESSID
 *    - Valeur : abc123def456 (l'ID de session)
 *    - Le navigateur stocke ce cookie automatiquement
 * 
 * 4. PHP initialise le tableau $_SESSION en mémoire (RAM)
 *    - C'est un tableau associatif vide au début
 *    - Tu peux y stocker n'importe quelle donnée
 * 
 * POURQUOI "always start the session" ?
 * - Parce que si tu essaies d'utiliser $_SESSION avant session_start(),
 *   PHP génère une erreur
 * - Il faut TOUJOURS appeler session_start() en premier
 * 
 * CE QUI SE PASSE PHYSIQUEMENT :
 * - Appel système : fopen("/tmp/sess_abc123", "w+")
 * - Le noyau Linux crée le fichier
 * - Le système de fichiers alloue des secteurs sur le disque
 * - PHP écrit l'ID de session dans le header HTTP
 */
session_start(); // always start the session


// ============================================================================
// LIGNE 2 : Fonction is_logged_in()
// ============================================================================
/**
 * QU'EST-CE QUE ÇA FAIT ?
 * 
 * Cette fonction vérifie si un utilisateur est connecté.
 * Elle regarde si la clé 'user_id' existe dans $_SESSION.
 * 
 * COMMENT ÇA MARCHE ?
 * 
 * 1. isset($_SESSION['user_id'])
 *    - isset() = fonction PHP qui vérifie si une variable existe
 *    - $_SESSION['user_id'] = on accède à la clé 'user_id' du tableau $_SESSION
 *    - Retourne true si la clé existe ET n'est pas null
 *    - Retourne false sinon
 * 
 * 2. return ...
 *    - Retourne directement le résultat de isset()
 *    - Si user_id existe → retourne true (connecté)
 *    - Si user_id n'existe pas → retourne false (pas connecté)
 * 
 * POURQUOI 'user_id' ?
 * - C'est une convention : on stocke l'ID de l'utilisateur dans $_SESSION['user_id']
 * - Quand l'utilisateur se connecte, on fait : $_SESSION['user_id'] = 123
 * - Quand on vérifie, on regarde si cette clé existe
 * 
 * CE QUI SE PASSE PHYSIQUEMENT :
 * - PHP lit dans la RAM (tableau $_SESSION)
 * - Opération très rapide (O(1) en moyenne)
 * - Pas d'accès disque nécessaire (les données sont déjà en RAM)
 * 
 * EXEMPLE :
 * 
 * Si $_SESSION = ['user_id' => 123, 'username' => 'admin']
 * → isset($_SESSION['user_id']) = true
 * → is_logged_in() retourne true
 * 
 * Si $_SESSION = [] (vide)
 * → isset($_SESSION['user_id']) = false
 * → is_logged_in() retourne false
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}


// ============================================================================
// LIGNE 3 : Fonction require_login()
// ============================================================================
/**
 * QU'EST-CE QUE ÇA FAIT ?
 * 
 * Cette fonction protège une page. Si l'utilisateur n'est pas connecté,
 * elle le redirige vers la page de login.
 * 
 * COMMENT ÇA MARCHE ?
 * 
 * 1. if (!is_logged_in())
 *    - ! = opérateur de négation logique
 *    - is_logged_in() retourne true/false
 *    - !true = false
 *    - !false = true
 *    - Donc : si pas connecté (!is_logged_in() = true), on entre dans le if
 * 
 * 2. header("Location: /auth/login.php")
 *    - header() = fonction PHP qui ajoute un header HTTP à la réponse
 *    - "Location: ..." = header HTTP spécial qui dit au navigateur de rediriger
 *    - Le navigateur voit ce header et fait automatiquement une NOUVELLE requête
 * 
 * 3. exit()
 *    - exit() = arrête immédiatement l'exécution du script PHP
 *    - Aucun code après exit() ne sera exécuté
 *    - Le serveur web envoie la réponse au navigateur
 * 
 * POURQUOI exit() après header() ?
 * - Parce que si on ne fait pas exit(), le code continue à s'exécuter
 * - On pourrait afficher du contenu après la redirection (pas voulu)
 * - exit() garantit que rien ne s'exécute après
 * 
 * CE QUI SE PASSE PHYSIQUEMENT :
 * 
 * 1. PHP exécute is_logged_in()
 *    - Lit $_SESSION['user_id'] en RAM
 *    - Retourne false (pas connecté)
 * 
 * 2. PHP entre dans le if
 *    - !false = true
 * 
 * 3. PHP appelle header()
 *    - Ajoute "Location: /auth/login.php" dans les headers HTTP
 *    - Ces headers sont stockés en mémoire, prêts à être envoyés
 * 
 * 4. PHP appelle exit()
 *    - Appel système : exit(0)
 *    - Le noyau arrête le processus PHP
 *    - Toute la mémoire est libérée
 * 
 * 5. Le serveur web envoie la réponse
 *    - Headers HTTP : Location: /auth/login.php
 *    - Le navigateur voit ce header
 *    - Le navigateur fait automatiquement une NOUVELLE requête vers /auth/login.php
 * 
 * EXEMPLE D'UTILISATION :
 * 
 * // Au début d'une page protégée
 * require_login(); // Si pas connecté → redirection automatique
 * 
 * // Le reste du code ne s'exécute que si connecté
 * echo "Contenu protégé";
 */
function require_login() {
    if (!is_logged_in()) {
        header("Location: /auth/login.php");
        exit();
    }
}


// ============================================================================
// LIGNE 4 : Fonction login_user()
// ============================================================================
/**
 * QU'EST-CE QUE ÇA FAIT ?
 * 
 * Cette fonction connecte un utilisateur. Elle stocke ses informations
 * dans la session pour qu'on s'en souvienne lors des prochaines requêtes.
 * 
 * COMMENT ÇA MARCHE ?
 * 
 * 1. function login_user($user)
 *    - $user = paramètre de la fonction (un tableau avec les infos de l'utilisateur)
 *    - Exemple : $user = ['id' => 123, 'username' => 'admin', 'email' => 'admin@example.com']
 * 
 * 2. $_SESSION['user_id'] = $user['id']
 *    - On accède à la clé 'id' du tableau $user
 *    - On assigne cette valeur à $_SESSION['user_id']
 *    - C'est une écriture en RAM (très rapide)
 * 
 * 3. $_SESSION['username'] = $user['username']
 *    - Même principe pour le username
 *    - On stocke aussi le username dans la session
 * 
 * CE QUI SE PASSE PHYSIQUEMENT :
 * 
 * 1. Pendant l'exécution (en RAM) :
 *    $_SESSION = [
 *        'user_id' => 123,
 *        'username' => 'admin'
 *    ]
 * 
 * 2. À la fin du script PHP :
 *    - PHP sérialise $_SESSION en texte
 *    - Format : "user_id|i:123;username|s:5:\"admin\";"
 *    - PHP écrit ce texte dans le fichier de session : /tmp/sess_abc123
 *    - Appel système : fwrite($file, $serialized_data)
 * 
 * 3. Lors de la prochaine requête :
 *    - PHP lit le cookie PHPSESSID=abc123
 *    - PHP charge le fichier /tmp/sess_abc123
 *    - PHP désérialise le contenu
 *    - PHP remplit $_SESSION avec les données
 *    - Tu peux utiliser $_SESSION['user_id'] et $_SESSION['username']
 * 
 * POURQUOI stocker user_id ET username ?
 * - user_id = pour les requêtes SQL (plus rapide, unique)
 * - username = pour afficher dans l'interface (plus lisible)
 * 
 * EXEMPLE D'UTILISATION :
 * 
 * // Après vérification du mot de passe
 * $user = [
 *     'id' => 123,
 *     'username' => 'admin'
 * ];
 * 
 * login_user($user); // Connecte l'utilisateur
 * 
 * // Maintenant, is_logged_in() retournera true
 * // Et $_SESSION['user_id'] = 123
 */
function login_user($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
}


// ============================================================================
// LIGNE 5 : Fonction logout_user()
// ============================================================================
/**
 * QU'EST-CE QUE ÇA FAIT ?
 * 
 * Cette fonction déconnecte un utilisateur. Elle supprime toutes les données
 * de session et détruit le fichier de session.
 * 
 * COMMENT ÇA MARCHE ?
 * 
 * 1. session_unset()
 *    - Vide le tableau $_SESSION en RAM
 *    - Toutes les clés/valeurs sont supprimées
 *    - $_SESSION devient un tableau vide : []
 *    - C'est une opération mémoire (très rapide)
 * 
 * 2. session_destroy()
 *    - Supprime le fichier de session sur le disque
 *    - Appel système : unlink("/tmp/sess_abc123")
 *    - Le noyau supprime le fichier
 *    - Le système de fichiers libère les secteurs
 * 
 * IMPORTANT : Le cookie reste dans le navigateur !
 * - session_destroy() supprime le FICHIER de session
 * - Mais le COOKIE reste dans le navigateur
 * - La prochaine fois que session_start() est appelé, un NOUVEAU ID sera généré
 * 
 * POUR SUPPRIMER AUSSI LE COOKIE :
 * 
 * function logout_user() {
 *     session_unset();
 *     session_destroy();
 *     
 *     // Supprimer aussi le cookie
 *     if (isset($_COOKIE[session_name()])) {
 *         setcookie(session_name(), '', time() - 3600, '/');
 *     }
 * }
 * 
 * CE QUI SE PASSE PHYSIQUEMENT :
 * 
 * 1. session_unset()
 *    - Vide $_SESSION en RAM
 *    - $_SESSION = [] (vide)
 * 
 * 2. session_destroy()
 *    - Appel système : unlink("/tmp/sess_abc123")
 *    - Le noyau supprime le fichier
 *    - Le disque libère les secteurs
 * 
 * 3. Résultat :
 *    - RAM : $_SESSION = [] (vide)
 *    - Disque : /tmp/sess_abc123 = (fichier supprimé)
 *    - Navigateur : Cookie PHPSESSID=abc123 (toujours là, mais inutile)
 * 
 * EXEMPLE D'UTILISATION :
 * 
 * // Sur la page de déconnexion
 * logout_user(); // Déconnecte l'utilisateur
 * 
 * // Rediriger vers la page de login
 * header("Location: /auth/login.php");
 * exit();
 */
function logout_user() {
    session_unset();
    session_destroy();
}

?>
