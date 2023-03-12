<style>
    p {
        text-align: center;
    }
    .error,
    .success {
        color: #fff;
        width: 50%;
        margin-left: auto;
        margin-right: auto;
        padding: 10px;
    }
    .error {
        background-color: red;
    }
    .success {
        background-color: #00d800;
    }
</style>
<?php

    $basicPage = "<p>Redirect to basic page after 2 seconds...</p>";

    $redirectPage = header("Refresh: 2; upload-image.php");

    if($_SERVER["REQUEST_METHOD"] === "POST") {

        // Get info of img
        $nameOfImg = $_FILES["file"]["name"];

        $tempOfImg = $_FILES["file"]["tmp_name"];

        $sizeOfImg = $_FILES["file"]["size"];

        // Array to push all errors
        $errors = array();

        // Allowed extensions
        $allowesExtensions = array("jpg", "jpeg", "png");

        // Max size of image [ bytes ]
        $sizeAvailable = 700000;

        // Get the extension of img
        $extensionOfImg = strtolower(end(explode('.', $nameOfImg)));

        // Means there's an img
        if($nameOfImg != "") {

            // If the extension not allowed
            if(!in_array($extensionOfImg, $allowesExtensions)) {
    
                // Error for extension
                $errors[] = "<p class='error'>The extension of image isn't available !</p>";
    
            }

        } else {

            $errors[] = "<p class='error'>You didn't upload image !</p>";

        }

        // If size of image greater than 700,000 bytes
        if($sizeOfImg > $sizeAvailable) {

            $errors[] = "<p class='error'>The size of image is larger than $sizeAvailable bytes!</p>";

        }

        // If there're no errors, the img is correct
        if(empty($errors)) {

            echo "<p class='success'>Success</p>";

            // For no repeating the name of img
            $rand = rand(0, 1000000000);

            // Name of img after random number
            $imgName = $rand . "_" . $nameOfImg;

            // Add img to the uploads folder
            move_uploaded_file($tempOfImg, "uploads\\" . $imgName);

            // File of database connection
            include "conn.php";

            // Insert name of img into database
            $sql = $conn->prepare("INSERT INTO
                                        image (avatar)
                                  VALUES
                                        (:avatar)");
            
            // Bind and execute the sql statement
            $sql->execute(array(
                ":avatar" => $imgName
            ));

            // Redirect to basic page after 2 seconds
            echo $basicPage;
            
            $redirectPage;

        } else {

            // Print all errors
            foreach($errors as $error) {

                echo $error;

            }

            // Redirect to basic page after 2 seconds
            echo $basicPage;
            
            $redirectPage;

        }

    } else {

        echo "<p class='error'>"; 

            echo "You can't open this page directly !";

            echo $basicPage;
            
            $redirectPage;

        echo "</p>";

    }