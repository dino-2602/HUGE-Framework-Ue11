<div class="messenger-container-page">
    <div class="container">
        <!-- Page title -->
        <h1>Messenger</h1>
        <div class="messenger-container">

            <!-- Left side: User list -->
            <div class="user-list">
                <h3>Chats</h3>
                <ul>
                    <?php foreach (UserModel::getAllUsers() as $user): ?>
                        <?php if ($user->user_id != Session::get('user_id')): ?>
                            <li>
                                <!-- Link to open a conversation with a specific user -->
                                <a href="<?= Config::get('URL') . 'messenger/index?conversation_id=' . htmlentities($user->user_id) ?>">
                                    <?= htmlentities($user->user_name) ?>
                                    <?php if (MessengerModel::getUnreadMessagesCount($user->user_id) > 0): ?>
                                        <!-- Display the count of unread messages for this user -->
                                        <span class="unread-count"><?= htmlentities(MessengerModel::getUnreadMessagesCount($user->user_id)) ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Right side: Chat frame -->
            <div class="chat-frame">
                <div class="discussion">
                    <?php foreach ($this->messages as $message): ?>
                        <?php
                        // Determine if the message is unread and wasn't sent by the current user
                        $isUnread = !$message->is_read && $message->sender_id != Session::get('user_id') ? 'unread' : '';
                        ?>
                        <div class="bubble <?= ($message->sender_id == Session::get('user_id') ? 'recipient' : 'sender') . ' ' . $isUnread ?>">
                            <!-- Display the message text -->
                            <p><?= htmlentities($message->message) ?></p>
                            <!-- Display the timestamp of the message -->
                            <p class="timestamp"><?= htmlentities($message->sent_at) ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Display message input form only if a conversation is selected -->
                <?php if ($this->currentConversation): ?>
                    <form action="<?= Config::get('URL') . 'messenger/sendMessage' ?>" method="post" class="message-form" id="message-form">
                        <!-- Hidden input for recipient ID -->
                        <input type="hidden" name="recipient_id" value="<?= htmlentities($this->currentConversation) ?>">
                        <!-- Textarea for message input -->
                        <label for="message_text"></label><textarea name="message_text" id="message_text" required placeholder="Type your message..."></textarea>
                        <!-- Submit button -->
                        <button type="submit">Send</button>
                    </form>
                <?php endif; ?>

                <script>
                    // Prevent double form submission
                    const messageForm = document.getElementById('message-form');
                    if (messageForm) {
                        messageForm.addEventListener('submit', function (event) {
                            if (!messageForm.classList.contains('submitted')) {
                                messageForm.classList.add('submitted');
                                return true; // Allow form submission
                            }
                            event.preventDefault(); // Prevent double submission
                        });
                    }

                    // Submit the form when Enter is pressed (without Shift)
                    const messageText = document.getElementById('message_text');
                    if (messageText) {
                        messageText.addEventListener('keydown', function (event) {
                            if (event.key === 'Enter' && !event.shiftKey) {
                                event.preventDefault();
                                messageForm.submit();
                            }
                        });
                    }

                    // Focus on the textarea after submitting the message
                    if (messageText) {
                        messageText.focus();
                    }

                    // Scroll to the bottom of the discussion to show the latest messages
                    const discussion = document.querySelector('.discussion');
                    if (discussion) {
                        discussion.scrollTop = discussion.scrollHeight;
                    }
                </script>
            </div>
        </div>
    </div>
</div>
