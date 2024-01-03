<?php
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();

// Redirect ke halaman lain setelah logout (opsional)
header("Location: index.php");
?>
