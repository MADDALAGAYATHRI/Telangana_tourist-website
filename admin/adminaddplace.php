<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle file upload
    $target_dir = "C:/xampp/htdocs/project/img/"; // Directory where images will be uploaded
    $target_file = $target_dir . basename($_FILES["place_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["place_image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    // Check file size (increased to 5MB)
    if ($_FILES["place_image"]["size"] > 5000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    // Allow only JPG and PNG files
    if($imageFileType != "jpg" && $imageFileType != "png") {
        echo "Sorry, only JPG and PNG files are allowed.";
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["place_image"]["tmp_name"], $target_file)) {
            // Retrieve other form data
            $place_name = $_POST['place_name'];
            $place_description = $_POST['place_description'];
            
            // Append place details to adventure.html
            $new_place_content = '
            <div class="container text-center post">
                <div class="row">
                    <div class="col">
                        <h5>' . $place_name . '</h5>
                        <p>' . $place_description . '</p>
                    </div>
                    <div class="col">
                        <img src="img/' . basename($_FILES["place_image"]["name"]) . '" alt="' . $place_name . '" class="location-image">
                    </div>
                </div>
            </div>';

            $file = 'C:/xampp/htdocs/project/adventure.html';
            $result = file_put_contents($file, $new_place_content, FILE_APPEND | LOCK_EX);
            if ($result !== false) {
                echo "Place details added to adventure.html successfully.";
            } else {
                echo "Failed to write place details to adventure.html.";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
