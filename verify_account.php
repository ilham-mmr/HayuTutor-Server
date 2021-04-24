<?php
include_once("dbconnect.php");
$email = $_GET['email'];
$otp = $_GET['key'];

$sql = "SELECT * FROM users WHERE email = '$email' AND otp='$otp'";
$result = $conn->query($sql);
$isValid = '';
if ($result->num_rows > 0) {
    $sqlupdate = "UPDATE users SET otp = '0' WHERE email = '$email' AND otp = '$otp'";
    if ($conn->query($sqlupdate) === TRUE) {
        $isValid = 'success';
    } else {
        $isValid = 'failed';
    }
} else {
    $isValid = 'failed';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Email Verification</title>
</head>

<body class="d-flex flex-column vh-100">

    <div class="row">
        <div class="col-md-6 offset-md-3 col-xl-4 offset-xl-4">
            <div class="card">
                <div class="card-body">
                    <?php if ($isValid === "success") : ?>
                        Congratulation, your email has successfully been verified. You now can log in to your app.
                    <?php else : ?>
                        Bad news, your email has failed to be verified.
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>