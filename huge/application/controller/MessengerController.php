<?php

/**
 * The messenger controller: Just an example of simple create, read, update and delete (CRUD) actions.
 */
class MessengerController extends Controller {

    /**
     * Constructor for the MessengerController class.
     * It initializes the parent controller and checks if the user is authenticated.
     */
    public function __construct() {
        parent::__construct(); // Call the parent constructor
        Auth::checkAuthentication(); // Ensure the user is authenticated
    }

    /**
     * Load the messenger view.
     * If a conversation ID is provided, fetch messages for that conversation and mark them as read.
     * Otherwise, load an empty message list.
     */
    public function index(): void
    {
        $conversation_id = Request::get('conversation_id'); // The selected user ID

        if ($conversation_id) {
            // Mark unread messages in the conversation as read
            MessengerModel::markMessagesAsRead(Session::get('user_id'), $conversation_id);

            // Fetch all messages between the current user and the selected user
            $messages = MessengerModel::getMessagesByUser(Session::get('user_id'), $conversation_id);

            // Render the messenger view with fetched messages and data
            $this->View->render('messenger/index', [
                'messages' => $messages, // Messages for the current conversation
                'unreadCount' => MessengerModel::getUnreadMessagesCount(Session::get('user_id')), // Count of unread messages
                'currentConversation' => $conversation_id // Current conversation ID
            ]);
        } else {
            // Render the messenger view with an empty message list
            $this->View->render('messenger/index', [
                'messages' => [], // Empty messages list
                'unreadCount' => MessengerModel::getUnreadMessagesCount(Session::get('user_id')), // Count of unread messages
                'currentConversation' => null // No conversation selected
            ]);
        }
    }

    /**
     * Send a message to a recipient.
     * This handles both GET and POST requests for sending messages.
     */
    public function sendMessage(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate that the recipient ID is provided
            if (Request::post('recipient_id') == null || Request::post('recipient_id') == '') {
                Redirect::to('messenger'); // Redirect to the messenger index if no recipient ID is provided
                return;
            }

            $recipient_id = Request::post('recipient_id'); // Get the recipient ID from the POST request
            error_log('Recipient ID: ' . $recipient_id); // Log the recipient ID for debugging

            $message_text = Request::post('message_text'); // Get the message text from the POST request

            // Attempt to send the message
            if (MessengerModel::sendMessage(Session::get('user_id'), $recipient_id, $message_text)) {
                // Redirect to the current conversation on success
                Redirect::to('messenger/index?conversation_id=' . $recipient_id);
            } else {
                // Render the sendMessage view with an error message if sending fails
                $this->View->render('messenger/sendMessage', [
                    'error' => 'Failed to send the message.', // Error message to display
                    'users' => UserModel::getAllUsers() // List of all users for the dropdown
                ]);
            }
        } else {
            // Render the sendMessage view for GET requests
            $this->View->render('messenger/sendMessage', [
                'users' => UserModel::getAllUsers() // List of all users for the dropdown
            ]);
        }
    }

    /**
     * Mark all messages in a conversation as read.
     * Redirects to the messenger index after marking the messages.
     */
    public function markAsRead(): void
    {
        $conversation_id = Request::post('conversation_id'); // Get the conversation ID from the POST request
        MessengerModel::markMessagesAsRead(Session::get('user_id'), $conversation_id); // Mark the messages as read
        Redirect::to('messenger'); // Redirect to the messenger index
    }
}
