<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bug Report</title>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="signin">
                    <div class="content">
                        <h3>Bug Report</h3>
                        <br>
                        <div class="from">
                            <!-- form for the bugs that are detected by the users -->
                            <form action="website_php/contact_code.php" method="post">
                                <label>Username</label><br>
                                <input type="text" name="reporter" required value="<?php $user = cookieAuth();
                                                                                    if ($user) {
                                                                                        echo cookieAuth();
                                                                                    } ?>"><br>
                                <label>Name of the bug</label><br>
                                <input type="text" name="report" required><br>
                                <label>Description of the bug</label><br>
                                <textarea name="description" required rows="3" cols="35"></textarea><br>
                                <label>What did you do before it went wrong</label><br>
                                <textarea name="whatTheUserDid" required rows="3" cols="35"></textarea><br>
                                <input type="submit" name="bug" value="Submit" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>