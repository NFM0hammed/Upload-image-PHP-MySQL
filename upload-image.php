<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Upload image</title>
        <style>
            * {
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            body {
                background-color: #eee;
            }
            form {
                background-color: #fff;
                margin: auto;
                padding: 20px;
            }
            @media(min-width: 520px) {
                form {
                    width: 500px;
                }
            }
            form input[type="file"] {
                display: none;
            }
            form label {
                position: relative;
                display: block;
                background-color: #f1f6f9;
                width: 200px;
                height: 100px;
                margin: auto;
                border-radius: 5px;
                cursor: pointer;
                transition: .3s;
            }
            form label:hover {
                background-color: #f1f6f99e;
            }
            form label span {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            form .chosen-image {
                display: flex;
                flex-direction: column;
                text-align: center;
                margin: 20px 0;
            }
            form .chosen-image span {
                background-color: #03a9f4;
                color: #fff;
                width: 200px;
                margin: 0 auto 5px;
                padding: 5px;
            }
            form .chosen-image span:last-child {
                display: none;
            }
            form input:last-of-type {
                display: block;
                background-color: #03a9f4;
                color: #fff;
                width: 200px;
                margin: 10px auto 0;
                padding: 10px;
                border: none;
                border-radius: 2px;
                cursor: pointer;
                transition: .3s;
            }
            form input:last-of-type:hover {
                background-color: #03a9f4a3;
            }
            form .show-img img {
                display: block;
                width: 150px;
                height: 150px;
                margin: 50px auto 0;
                padding: 2px;
                border: 1px solid #eee;
                border-radius: 50%;
            }
            form .show-img span {
                display: block;
                color: #03a9f4;
                text-align: center;
                font-weight: bold;
                margin-top: 5px;
            }
        </style>
    </head>
    <body>
        <form action="upload.php" method="POST" enctype= multipart/form-data>
            <input type="file" id="file" name="file" />
            <label for="file">
                <span>Upload image</span>
            </label>
            <div class="chosen-image">
                <span>No chosen image</span>
                <span></span>
            </div>
            <input type="submit" value="Upload" />
            <?php

                // File of database connection
                include "conn.php";

                // Select last img from database
                $stmt = $conn->prepare("SELECT
                                            *
                                        FROM
                                            image
                                        ORDER BY id DESC");

                // Execute the sql statement
                $stmt->execute();

                // Calculate rows to check if there's an img or not
                $count = $stmt->rowCount();

                // Fetch the row
                $info = $stmt->fetch();

                // Means there's an img
                if($count > 0) {

                    // Show img
                    echo "<div class='show-img'>";

                        echo "<img src='uploads\\" . $info["avatar"] . "' />";

                        echo "<span>Avatar</span>";

                    echo "</div>";

                } else {

                    // Default img
                    echo "<div class='show-img'>";

                        echo "<img src='uploads\\defualt_image.png' />";

                        echo "<span>No avatar</span>";

                    echo "</div>";

                }

            ?>
        </form>
    </body>

    <script>
        let fileInput   = document.querySelector("form input[type='file']"),
            nameOfImage = document.querySelector(".chosen-image span:first-of-type"),
            sizeOfImage = document.querySelector(".chosen-image span:last-of-type");
        
        // Add info of img after chosen
        fileInput.addEventListener("change", () => {

            // Change name of image after choose image
            nameOfImage.innerHTML = fileInput.files[0].name;

            // Show size of image
            sizeOfImage.innerHTML = `${fileInput.files[0].size} bytes`;
            sizeOfImage.style.display = "block";

            // console.log(fileInput.files[0].name);
        });
    </script>
</html>