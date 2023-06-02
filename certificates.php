<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form was submitted
    if (isset($_FILES['certificate'])) {
        // Define the target directory to store the certificates
        $targetDir = __DIR__ . '/certificates/';

        // Iterate through each uploaded certificate file
        foreach ($_FILES['certificate']['tmp_name'] as $key => $tmpName) {
            // Get the filename and temporary path of the certificate
            $filename = $_FILES['certificate']['name'][$key];
            $tmpPath = $_FILES['certificate']['tmp_name'][$key];

            // Generate a unique filename for the certificate
            $uniqueFilename = uniqid() . '_' . $filename;
            $targetPath = $targetDir . $uniqueFilename;

            // Move the uploaded file to the target directory
            if (move_uploaded_file($tmpPath, $targetPath)) {
                // File upload success
                // TODO: Save the filename or the target path to the database
                echo "Certificate uploaded successfully!";
            } else {
                // File upload failed
                echo "Failed to upload the certificate.";
            }
        }
    } else {
        echo "No certificate file found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Certificate Upload</title>
</head>
<body>
    <h1>Upload Certificate</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="certificate" class="control-label">Certificate</label>
            <input type="file" name="certificate[]" id="certificate" class="form-control form-control-sm rounded-0" accept=".pdf,.doc,.docx" multiple required>
        </div>
        <button type="submit">Upload</button>
    </form>
</body>
</html>

