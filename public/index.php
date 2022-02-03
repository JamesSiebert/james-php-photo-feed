<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Global Photo Feed</title>
</head>
<body>
<?php $_ENV['DB_USER'] ?>

<!--Simple Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Global Photo Feed</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">View Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload_form.php">Post a Photo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="mx-auto" style="width: 400px;">
        <div class="card border-primary mb-3 mt-5">
            <div class="card-body text-primary">
                <h5 class="card-title mb-2">Public Photo Feed</h5>
                <div class="mt-3 alert alert-info" role="alert">
                    Share your favourite photos with people all over the world!
                </div>
                <div>
                    <div id="post-list"></div>


                    <script>

                        <!-- TODO fix URL -->
                        fetch('/api/post/read.php')
                            .then(function (response) {
                                return response.json();
                            })
                            .then(function (data) {
                                appendData(data);
                            })
                            .catch(function (err) {
                                console.log('error: ' + err);
                            });

                        function appendData(data) {

                            // dump to console
                            console.log(data.data);

                            // Get list image list element
                            const postContainer = document.getElementById("post-list");

                            const postArray = data.data

                            postArray.forEach((item) => {
                                const div = document.createElement('div');

                                div.innerHTML = `
                                <div class='mb-3 card'>
                                    <img src='images/${item.filename}' class='card-img-top' alt='User Image'>
                                    <div class='card-body'>
                                        <p class='card-text text-secondary'>
                                            <b>Name:</b> ${item.name}<br>
                                            <b>Description:</b> ${item.description}<br>
                                            <b>Filename:</b> ${item.filename}<br>
                                            <b>IP Address:</b> ${item.ip_address}<br>
                                        </p>
                                    </div>
                                </div>
                                `;

                                postContainer.appendChild(div);
                            })
                        }
                    </script>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
