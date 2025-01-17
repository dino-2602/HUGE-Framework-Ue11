<?php

use Random\RandomException;

/**
 * RegisterController
 * Register new user
 */
class RegisterController extends Controller
{
    /**
     * Construct this object by extending the basic Controller class. The parent::__construct thing is necessary to
     * put checkAuthentication in here to make an entire controller only usable for logged-in users (for sure, not
     * needed in the RegisterController).
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Register page
     * Show the register form, but redirect to main-page if user is already logged in
     */
    public function index(): void
    {
        $this->View->render('register/index');
        Auth::checkAdminAuthentication();
    }

    /**
     * Register page action with csrf token
     * POST-request after form submitted
     * @throws RandomException
     */
    public function register_action(): void
    {
        // check if csrf token is valid
        if (!Csrf::isTokenValid()) {
            LoginModel::logout();
            Redirect::home();
            exit();
        }

        // check if we have a reCAPTCHA response
        $recaptchaResponse = Request::post('g-recaptcha-response');
        $recaptchaSecret = '6LcGVrkqAAAAALLyrKKt6MMVeDCi0TdVZ0jAgo1m';

        $recaptchaVerifyUrl = 'https://www.google.com/recaptcha/api/siteverify';
        $response = file_get_contents($recaptchaVerifyUrl . '?secret=' . $recaptchaSecret . '&response=' . $recaptchaResponse);
        $responseData = json_decode($response);

        if (!$responseData->success) {
            Session::add('feedback_negative', 'Invalid reCAPTCHA. Please try again.');
            Redirect::to('login/index');
            exit();
        }

        RegistrationModel::registerNewUser();
        Redirect::to('login/index');
    }

    /**
     * Verify user after activation mail link opened
     * @param int $user_id user's id
     * @param string $user_activation_verification_code user's verification token
     */
    public function verify(int $user_id, string $user_activation_verification_code): void
    {
        if (RegistrationModel::verifyNewUser($user_id, $user_activation_verification_code)) {
            $this->View->render('register/verify');
        } else {
            Redirect::to('login/index');
        }
    }


    /**
     * Generate a captcha, write the characters into $_SESSION['captcha'] and returns a real image which will be used
     * like this: <img src="......./login/showCaptcha" />
     * IMPORTANT: As this action is called via <img ...> AFTER the real app has finished executing (!), the
     * SESSION["captcha"] has no content when the app is loaded. The SESSION["captcha"] gets filled at the
     * moment the end-user requests the <img. >
     * Maybe refactor this sometime.
     */
    /** public function showCaptcha()
    {
        CaptchaModel::generateAndShowCaptcha();
    }*/
}
