<?php
//ok es sieht so als als ob das include hier nicht auf den oberordner zugreifn kann
include_once '../includes/db_connect.php';


function sec_session_start() {
    $session_name = 'sec_session_id';
    $secure = false;
    $httponly = true;
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../index.php?error=2");
        exit();
    }
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);
    session_name($session_name);
    session_start();
    session_regenerate_id();
}

function login($email, $password, $mysqli) {
    //global $mysqli;
    // Das Benutzen vorbereiteter Statements verhindert SQL-Injektion.
    $mysqli = new mysqli(localhost, user, hallo123, website);
    if ($stmt = $mysqli->prepare("SELECT id, username, password, salt 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Führe die vorbereitete Anfrage aus.
        $stmt->store_result();
        // hole Variablen von result.
        $stmt->bind_result($user_id, $username, $db_password, $salt);
        $stmt->fetch();

        // hash das Passwort mit dem eindeutigen salt.
        $password = hash('sha512', $password . $salt);
        if ($stmt->num_rows == 1) {
            // Wenn es den Benutzer gibt, dann wird überprüft ob das Konto
            // blockiert ist durch zu viele Login-Versuche
            if (checkbrute($user_id, $mysqli) == true) {
                // Konto ist blockiert
                // Schicke E-Mail an Benutzer, dass Konto blockiert ist
                return false;
            } else {
                // Überprüfe, ob das Passwort in der Datenbank mit dem vom
                // Benutzer angegebenen übereinstimmt.
                if ($db_password == $password) {
                    // Passwort ist korrekt!
                    // Hole den user-agent string des Benutzers.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS-Schutz, denn eventuell wir der Wert gedruckt
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                        "",
                        $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                        $password . $user_browser);
                    // Login erfolgreich.
                    return true;

                } else {
                    // Passwort ist nicht korrekt
                    // Der Versuch wird in der Datenbank gespeichert
                    $now = time();
                    $mysqli->query("INSERT INTO login_attempts(user_id, time)
                                    VALUES ('$user_id', '$now')");
                    return false;
                }
            }
        } else {
            //Es gibt keinen Benutzer.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    $now = time();

    $valid_attempts = $now - (2 * 60 * 60);

    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts <code><pre>
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);

        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    if (isset($_SESSION['user_id'],
        $_SESSION['username'],
        $_SESSION['login_string'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];

        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $password = "";

        if ($stmt = $mysqli->prepare("SELECT password 
                                      FROM members 
                                      WHERE id = ? LIMIT 1")) {
            $stmt->bind_param('i', $user_id);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 1) {
                $stmt->bind_result($password);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        return '';
    } else {
        return $url;
    }
}
