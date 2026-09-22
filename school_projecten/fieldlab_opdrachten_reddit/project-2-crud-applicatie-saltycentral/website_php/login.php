<!-- the sign-in page -->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="signin">
                <div class="content">
                    <h1 class="text-center">Sign in</h1>
                    <form action="website_php/loginhandler.php" method="post">
                        <div class="form">
                            <!-- Form inputs -->
                            <div class="inputbox">
                                <label for="username">Username</label>
                                <input type="text" id="username" name="username" class="form-control">
                            </div>
                            <div class="inputbox">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="inputbox justify-content-center p-2">
                                <input type="submit" name="Login" value="Login" class="btn btn-primary">
                                <input type="submit" name="Register" value="Register" class="btn btn-primary">
                            </div>
                        </div>

                    </form>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>