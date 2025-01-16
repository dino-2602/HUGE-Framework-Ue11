# reCAPTCHA Integration in Huge Framework

## Übersicht
Dieses Projekt erweitert das Huge Framework, indem es Google reCAPTCHA V2 integriert. Dadurch wird die Sicherheit der Benutzerregistrierung erhöht und Bots werden effektiv blockiert. Das Projekt umfasst sowohl die Frontend- als auch die Backend-Integration von reCAPTCHA.

---

## Ziel
Das Ziel ist es, sicherzustellen, dass nur echte Benutzer sich registrieren können. Diese Funktionalität wurde speziell für den Admin-Bereich implementiert.

---

## Anforderungen
- **Google reCAPTCHA Konto:** Melde dich bei der [Google reCAPTCHA Admin-Konsole](https://www.google.com/recaptcha/admin) an.
- **Site Key und Secret Key:** Diese erhältst du nach der Registrierung deiner Website.

---

## Installation

### 1. Frontend-Integration
1. **Script einfügen:**
   Binde das reCAPTCHA-Skript in der Datei `views/register/index.php` ein:
   ```html
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   ```

2. **Widget hinzufügen:**
   Ergänze das Widget innerhalb des Formulars:
   ```html
   <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
   ```
   Ersetze `YOUR_SITE_KEY` durch deinen Google Site Key.

3. **Formular aktualisieren:**
   Stelle sicher, dass das Formular so aussieht:
   ```html
   <form action="/register/register_action" method="post">
       <!-- Andere Felder -->
       <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
       <button type="submit">Benutzer registrieren</button>
   </form>
   ```

### 2. Backend-Integration
1. **Controller anpassen:**
   Bearbeite die Methode `register_action` in `controllers/RegisterController.php`:
   ```php
   $recaptchaResponse = Request::post('g-recaptcha-response');
   $recaptchaSecret = 'YOUR_SECRET_KEY';

   $recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
   $response = file_get_contents($recaptchaVerifyUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
   $responseData = json_decode($response);

   if (!$responseData->success) {
       Session::add('feedback_negative', 'Invalid reCAPTCHA. Please try again.');
       Redirect::to('register/index');
       exit();
   }

   RegistrationModel::registerNewUser();
   Redirect::to('login/index');
   ```
   Ersetze `YOUR_SECRET_KEY` durch deinen Google Secret Key.

---

## Testen
1. **Kein reCAPTCHA:** Überprüfe, ob das Formular blockiert wird, wenn kein reCAPTCHA vorhanden ist.
2. **Falsches reCAPTCHA:** Teste, ob bei ungültigen Antworten eine Fehlermeldung angezeigt wird.
3. **Gültiges reCAPTCHA:** Stelle sicher, dass eine erfolgreiche Registrierung möglich ist.

---

## Genutzte Technologien

![PHP](https://img.shields.io/badge/PHP-8.1%2B-blue) ![Huge Framework](https://img.shields.io/badge/Huge%20Framework-1.0-brightgreen) ![HTML5](https://img.shields.io/badge/HTML-5-orange) ![CSS3](https://img.shields.io/badge/CSS-3-blue) ![JavaScript](https://img.shields.io/badge/JavaScript-ES6%2B-yellow) ![PHPStorm](https://img.shields.io/badge/IDE-PHPStorm-purple) ![MySQL](https://img.shields.io/badge/Database-MySQL-lightblue) ![Apache](https://img.shields.io/badge/Server-Apache-lightgrey)

⚠️ **Hinweis:** In diesem Repository wurde ausschließlich der `application`-Ordner hochgeladen. Dies geschieht, um den Datenschutz zu gewährleisten und keine sensiblen Daten wie Serverkonfigurationen oder Zugangsdaten öffentlich bereitzustellen. Dateien wie `config.php` und andere Konfigurationsdateien, die möglicherweise sensible Informationen enthalten, wurden absichtlich nicht hochgeladen.

---

## Ressourcen
- [Google reCAPTCHA Admin-Konsole](https://www.google.com/recaptcha/admin)
- [Google reCAPTCHA Dokumentation](https://developers.google.com/recaptcha/docs/v2)
- [Huge Framework Dokumentation](https://huge-framework.readthedocs.io/)

---

## Lizenz
Dieses Projekt wurde im Rahmen eines IT-Labors erstellt und basiert auf dem Huge Framework.
