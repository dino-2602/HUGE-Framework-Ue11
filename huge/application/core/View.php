<?php

/**
 * Class View
 * The part that handles all the output rendering in the app.
 */
#[AllowDynamicProperties]
class View
{
    // Define the property $users to avoid deprecated warnings
    public $users;
    public $redirect;

    /**
     * Includes (renders) the view with optional data.
     * This is called from the controller to display a specific view, along with a header and footer.
     *
     * @param string $filename Path of the view file to render, usually folder/file(.php).
     * @param array|null $data Data to pass into the view.
     */
    public function render(string $filename, ?array $data = null): void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';
        require Config::get('PATH_VIEW') . $filename . '.php';
        require Config::get('PATH_VIEW') . '_templates/footer.php';
    }

    /**
     * Renders multiple views between the header and footer.
     * Useful for combining multiple views in one page.
     *
     * @param array $filenames Array of view file paths to render.
     * @param array|null $data Data to pass into the views.
     * @return bool Returns false if the filename's parameter isn't an array.
     */
    public function renderMulti(array $filenames, ?array $data = null): bool
    {

        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . '_templates/header.php';

        foreach ($filenames as $filename) {
            require Config::get('PATH_VIEW') . $filename . '.php';
        }

        require Config::get('PATH_VIEW') . '_templates/footer.php';
        return true;
    }

    /**
     * Renders a view without including the header and footer templates.
     *
     * @param string $filename Path of the view file to render.
     * @param array|null $data Data to pass into the view.
     */
    public function renderWithoutHeaderAndFooter(string $filename, ?array $data = null): void
    {
        if ($data) {
            foreach ($data as $key => $value) {
                $this->{$key} = $value;
            }
        }

        require Config::get('PATH_VIEW') . $filename . '.php';
    }

    /**
     * Renders pure JSON data to the browser, useful for API responses.
     *
     * @param mixed $data Data to encode and output as JSON.
     */
    public function renderJSON(mixed $data): void
    {
        header("Content-Type: application/json");
        echo json_encode($data);
    }

    /**
     * Renders feedback messages stored in the session to the view.
     * These messages include positive or negative feedback for the user.
     */
    public function renderFeedbackMessages(): void
    {
        require Config::get('PATH_VIEW') . '_templates/feedback.php';

        // Clear feedback messages from the session after rendering
        Session::set('feedback_positive', null);
        Session::set('feedback_negative', null);
    }

    /**
     * Checks if the provided controller matches the currently active controller.
     * Useful for marking navigation links as active.
     *
     * @param string $filename The current view's path.
     * @param string $navigation_controller The controller to check.
     * @return bool Returns true if the controller matches the active controller.
     */
    public static function checkForActiveController(string $filename, string $navigation_controller): bool
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0];

        return $active_controller === $navigation_controller;
    }

    /**
     * Checks if the provided action matches the currently active controller action (method).
     * Useful for marking navigation links as active.
     *
     * @param string $filename The current view's path.
     * @param string $navigation_action The action to check.
     * @return bool Returns true if the action matches the active action.
     */
    public static function checkForActiveAction(string $filename, string $navigation_action): bool
    {
        $split_filename = explode("/", $filename);
        $active_action = $split_filename[1] ?? null;

        return $active_action === $navigation_action;
    }

    /**
     * Checks if both the provided controller and action match the currently active controller and action.
     *
     * @param string $filename The current view's path.
     * @param string $navigation_controller_and_action The controller and action to check.
     * @return bool Returns true if both match.
     */
    public static function checkForActiveControllerAndAction(string $filename, string $navigation_controller_and_action): bool
    {
        $split_filename = explode("/", $filename);
        $active_controller = $split_filename[0] ?? null;
        $active_action = $split_filename[1] ?? null;

        $split_navigation = explode("/", $navigation_controller_and_action);
        $navigation_controller = $split_navigation[0] ?? null;
        $navigation_action = $split_navigation[1] ?? null;

        return $active_controller === $navigation_controller && $active_action === $navigation_action;
    }

    /**
     * Converts special characters to HTML entities to prevent XSS attacks.
     *
     * @param string $str The input string.
     * @return string The sanitized string with HTML entities.
     */
    public function encodeHTML(string $str): string
    {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}
