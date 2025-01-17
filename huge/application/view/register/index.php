<div class="container">

    <!-- echo out the system feedback (error and success messages) -->
    <?php $this->renderFeedbackMessages(); ?>

    <!-- login box on the left side -->
    <div class="login-box" style="width: 50%; display: block;">
        <h2>Register a new account</h2>

        <!-- register form -->
        <form method="post" action="<?php echo Config::get('URL'); ?>register/register_action">

            <!-- the username input field uses an HTML5 pattern check -->
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>

            <!-- the username input field uses an HTML5 pattern check -->
            <label>
            <input type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" placeholder="Username (letters/numbers, 2-64 chars)" required />
            <input type="text" name="user_email" placeholder="email address (a real address)" required />
            <input type="text" name="user_email_repeat" placeholder="repeat email address (to prevent typos)" required />
            <input type="password" name="user_password_new" pattern=".{6,}" placeholder="Password (6+ characters)" required autocomplete="off" />
            <input type="password" name="user_password_repeat" pattern=".{6,}" required placeholder="Repeat your password" autocomplete="off" />
            </label>

            <!-- set CSRF token at the end of the form -->
            <input type="hidden" name="csrf_token" value="<?=csrf::makeToken();?>" />

            <!-- Google reCAPTCHA -->
            <div class="g-recaptcha" data-sitekey="6LcGVrkqAAAAALeAlqQuY0PNl63M_a__1rdhSxus"></div>

            <input type="submit" value="Register" />
        </form>
    </div>
</div>
