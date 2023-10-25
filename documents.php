<?php
// Your database connection code here
include 'DBConnection.php';

// Get the document ID from the URL
$documentId = isset($_GET['document_id']) ? $_GET['document_id'] : null;

if ($documentId) {
    
    $query = "SELECT upload_path FROM documents WHERE id = $documentId";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $uploadPath = $row['upload_path'];

        // Construct the full file path
        $basePath = 'uploads/document_'; // Adjust to the actual path to your uploads folder
        $fullFilePath = $basePath . $uploadPath;

        // Check if the file exists
        if (file_exists($fullFilePath)) {
            // Set the appropriate content type (e.g., for PDF)
            header('Content-Type: application/*');
            readfile($fullFilePath);
        } else {
            // File not found
            echo 'Document not found.';
        }
    } else {
        echo 'Document record not found.';
    }
} else {
    echo 'Invalid document ID.';
}

// Close the database connection if needed
$conn->close();
?>
