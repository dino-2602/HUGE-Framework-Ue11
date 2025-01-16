# reCAPTCHA Integration in Huge Framework

## Beschreibung
Dieses Projekt integriert Google reCAPTCHA V2 in das Huge Framework, um sicherzustellen, dass nur echte Benutzer auf das Formular zugreifen können. Die Implementierung umfasst Frontend- und Backend-Komponenten, um die Benutzerregistrierung abzusichern.

---

## Voraussetzungen
- **Google reCAPTCHA Konto**: Registriere eine neue Site in der [Google reCAPTCHA Admin-Konsole](https://www.google.com/recaptcha/admin).
- **Site Key** und **Secret Key**: Diese werden bei der Registrierung in der Konsole bereitgestellt.

---

## Implementierungsschritte

### 1. Frontend-Integration
1. **reCAPTCHA Script einbinden**:
   Füge in der Datei `views/register/index.php` das folgende Skript hinzu:
   ```html
   <script src="https://www.google.com/recaptcha/api.js" async defer></script>
   ```

2. **reCAPTCHA-Widget hinzufügen**:
   Platziere das Widget im Formular, vorzugsweise vor dem Submit-Button:
   ```html
   <form action="/register/register_action" method="post">
       <!-- Andere Formularfelder -->
       <div class="g-recaptcha" data-sitekey="YOUR_SITE_KEY"></div>
       <button type="submit">Benutzer registrieren</button>
   </form>
   ```
   Ersetze `YOUR_SITE_KEY` durch den Google reCAPTCHA Site Key.

### 2. Backend-Integration
1. **Controller anpassen**:
   Öffne die Datei `controllers/RegisterController.php` und füge die reCAPTCHA-Validierung in der Methode `register_action` hinzu:
   ```php
   public function register_action(): void
   {
       // reCAPTCHA-Validierung
       $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';

       $response = file_get_contents(
           "https://www.google.com/recaptcha/api/siteverify?secret=YOUR_SECRET_KEY&response={$recaptchaResponse}"
       );
       $result = json_decode($response, true);

       if (empty($result['success']) || !$result['success']) {
           Session::add('feedback_negative', 'reCAPTCHA-Überprüfung fehlgeschlagen.');
           Redirect::to('register/index');
           return;
       }

       // Benutzer registrieren, falls reCAPTCHA erfolgreich
       RegistrationModel::registerNewUser();
       Redirect::to('login/index');
   }
   ```
   Ersetze `YOUR_SECRET_KEY` durch den Google reCAPTCHA Secret Key.

2. **Feedback anzeigen**:
   Stelle sicher, dass Fehlermeldungen in der View `register/index.php` angezeigt werden:
   ```php
   if (Session::get('feedback_negative')) {
       echo '<div class="error">' . Session::get('feedback_negative') . '</div>';
   }
   ```

---

## Testen
1. **Fehlende reCAPTCHA-Antwort:**
   Übermittle das Formular ohne reCAPTCHA-Antwort und überprüfe, ob die Registrierung blockiert wird.

2. **Ungültige reCAPTCHA-Antwort:**
   Simuliere eine ungültige Antwort, um sicherzustellen, dass die Fehlermeldung korrekt angezeigt wird.

3. **Gültige reCAPTCHA-Antwort:**
   Teste das Formular mit einer gültigen Antwort und überprüfe, ob die Registrierung erfolgreich abgeschlossen wird.

---

## Fehlerbehebung
- **Fehlermeldung: "localhost ist nicht in der Liste der unterstützten Domains":**
  - Füge `localhost` in der Google reCAPTCHA Admin-Konsole zur Liste der erlaubten Domains hinzu.
- **Kein Feedback angezeigt:**
  - Überprüfe, ob `Session::add` und `Session::get` korrekt implementiert sind.

---

## Ressourcen
- [Google reCAPTCHA Dokumentation](https://developers.google.com/recaptcha/docs/display?hl=de)
- [Huge Framework Dokumentation](https://huge-framework.readthedocs.io/)

---

## Autor
Dieses Projekt wurde als Teil des IT-Labors erstellt, um die Sicherheit der Benutzerregistrierung zu erhöhen.
