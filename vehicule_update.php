<?php
include_once('model.php'); // Ensure model.php contains the dbConnect function

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the form
    $data['id'] = $_POST['id'] ?? null;
    $data['nom'] = $_POST['nom'] ?? null;

    // Validate the input
    if (!$data['id'] || !$data['nom']) {
        echo "All fields are required.";
        exit;
    }

    try {
        // Update the vehicle in the database
        updateVehicule($data);

        // Redirect after successful update
        header("Location: vehicule.php?update=success");
        exit;
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>