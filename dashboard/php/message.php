<?php
// Start the session only if it hasn't been started yet
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Make sure the session is started
}

if (isset($_SESSION['message'])) :
    // Determine the alert type
    $alertType = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'warning'; // Default to warning if type is not set
?>

    <div class="alert alert-<?= $alertType; ?> alert-dismissible fade show" role="alert">
        <strong>Hey!</strong> <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

<?php unset($_SESSION['message']); // Clear the message after displaying
    unset($_SESSION['message_type']); // Clear the message type after displaying
endif;
?>