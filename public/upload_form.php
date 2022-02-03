<?php

// Include CSRF class
require_once ("CSRF.php");

// CSRF Token
try {
    $token = CSRF::createTokenOnly(30);
} catch (Exception $e) {
    echo $e;
}

$showTokenDebug = true; // For demo only

// Messages from server
$successMessage = isset($_GET['successMessage']) ? sanitiseText($_GET['successMessage']) : '';
$errorMessage = isset($_GET['errorMessage']) ? sanitiseText($_GET['errorMessage']) : '';

// Re-Fill params on server validation failure - could have also used $_SESSION
$name = isset($_GET['name']) ? sanitiseText($_GET['name']) : '';
$description = isset($_GET['description']) ? sanitiseText($_GET['description']) : '';

// Trigger error styles on form
$nameErr = isset($_GET['nameErr']) ? filter_var($_GET['nameErr'], FILTER_VALIDATE_BOOLEAN) : false;
$descriptionErr = isset($_GET['descriptionErr']) ? filter_var($_GET['descriptionErr'], FILTER_VALIDATE_BOOLEAN) : false;
$imageErr = isset($_GET['imageErr']) ? filter_var($_GET['imageErr'], FILTER_VALIDATE_BOOLEAN) : false;

function sanitiseText($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    // Only allow letters, numbers & whitespace
    if (!preg_match("/^[a-zA-Z0-9-' ]*$/", $data)) {
        // TODO show error message
        return '';
    }
    return $data;
}
?>

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

<!--Simple Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand">Global Photo Feed</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="./index.php">View Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="upload_form.php">Post a Photo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="mx-auto" style="width: 400px;">
        <div class="card border-primary mb-3 mt-5">
            <div class="card-body text-primary">
                <h5 class="card-title mb-2">Create a post</h5>
                <div class="mt-3">
                    <div class="mt-2 alert alert-info" role="alert">
                        Example Info

                        <!-- Token expiry info for demo only -->
                        <?php if($showTokenDebug){
                            echo '<br><br>Your IP Address: ' . $_SERVER["REMOTE_ADDR"] . '<br><br>';
                            echo 'CSRF TESTING:<br>CurrentTime: ' . time() . '<br>Token Expire: ' . $_SESSION["csrf-token-expire"] . '<br>';
                        }?>
                    </div>
                    <!-- Messages from server-->
                    <?php if($successMessage) {echo "<div class='alert alert-success' role='alert'>$successMessage</div>";}?>
                    <?php if($errorMessage) {echo "<div class='alert alert-danger' role='alert'>$errorMessage</div>";}?>
                </div>
                <form action="../api/post/create.php" method="POST" enctype="multipart/form-data">

                    <!-- CSRF Token -->
                    <input type='hidden' name='csrf-token' value='<?php echo $token ?>' />

                    <div class="mb-3">
                        <label for="formControlInputName" class="form-label">Name</label>
                        <input
                                name="name"
                                value="<?PHP echo $name; ?>"
                                type="text" class="form-control <?PHP echo $nameErr ? 'is-invalid' : ''; ?>"
                                id="formControlInputName"
                                placeholder="Image Name"
                                required
                        >
                    </div>
                    <div class="mb-3">
                        <label for="formControlTextareaDescription" class="form-label">Description</label>
                        <textarea
                                name="description"
                                class="form-control <?PHP echo $descriptionErr ? 'is-invalid' : ''; ?>"
                                id="formControlTextareaDescription"
                                rows="5"
                                placeholder="Image Description"
                                required
                        ><?PHP echo $description; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="formFile" class="form-label">Image file</label>
                        <input name="fileToUpload" class="form-control <?PHP echo $imageErr ? 'is-invalid' : ''; ?>" type="file" id="fileToUpload" required>
                        <small>(Ideal size: 400px wide by 300px high)</small>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Post Photo</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
