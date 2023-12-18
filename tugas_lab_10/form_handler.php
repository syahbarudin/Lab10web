<?php

class FormHandler {
    private $database;

    public function __construct(Database $db) {
        $this->database = $db;
    }

    public function getAllDataFromTable($tableName) {
        $conn = $this->database->getConnection();
        $sql = "SELECT * FROM $tableName";
        $result = $conn->query($sql);
        $data = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        $this->database->closeConnection();

        return $data;
    }

    public function processFormData($tableName, $formData, $id = null) {
        $conn = $this->database->getConnection();

        // Jika $id tidak null, itu adalah operasi mengubah
        if ($id !== null) {
            // Construct the SQL query for updating data
            $updates = [];
            foreach ($formData as $key => $value) {
                $updates[] = "$key = '$value'";
            }
            $updatesString = implode(", ", $updates);

            $sql = "UPDATE $tableName SET $updatesString WHERE id = $id";
        } else {
            // Construct the SQL query for inserting data
            $columns = implode(", ", array_keys($formData));
            $values = "'" . implode("', '", $formData) . "'";
            $sql = "INSERT INTO $tableName ($columns) VALUES ($values)";
        }

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Data processed successfully";
        } else {
            echo "Error processing data: " . $conn->error;
        }

        $this->database->closeConnection();
    }

    public function getDataById($tableName, $id) {
        $conn = $this->database->getConnection();
        $sql = "SELECT * FROM $tableName WHERE id = $id";
        $result = $conn->query($sql);

        
    }

    // Metode untuk mengunggah file gambar
    public function uploadImage($inputName, $targetDirectory) {
        $targetFile = $targetDirectory . basename($_FILES[$inputName]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            $check = getimagesize($_FILES[$inputName]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($targetFile)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES[$inputName]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if (
            $imageFileType != "jpg" && $imageFileType != "png" &&
            $imageFileType != "jpeg" && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES[$inputName]["tmp_name"], $targetFile)) {
                return $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }
    

    public function deleteDataById($tableName, $id) {
        $conn = $this->database->getConnection();

        // Construct the SQL query for deleting data
        $sql = "DELETE FROM $tableName WHERE id = $id";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Data deleted successfully";
        } else {
            echo "Error deleting data: " . $conn->error;
        }

        $this->database->closeConnection();
    }
}

?>
