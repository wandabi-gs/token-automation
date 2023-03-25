<?php
    require("../base/header.php");

    $errors = [
        "email" => "",
        "password" => ""
    ];

    $saved_data = [
        "email" => "",
        "password" => ""
    ];

    if(isset($_POST["submit"])){
        $saved_data = [
            "email" => $_POST["email"],
            "password" => $_POST["password"]
        ];

        $userexistsQuery = $db_connect->query("SELECT * FROM user WHERE email='{$_POST["email"]}'");
        $userexists = $userexistsQuery->fetch(PDO::FETCH_ASSOC);
        if(empty($userexists)){
            $errors["email"] = "User not found"; 
        }else{
            if(password_verify($_POST["password"],$userexists["password"])){
                session_unset();
                unset($userexists["userId"],$userexists["password"]);
                $_SESSION["user_authenticated"] = true;
                $_SESSION["user"] = $userexists;
            }else{
                $errors["password"] = "wrong password";
            }
        }
    }
?>
    <div class="container-fluid p-3 d-flex flex-row justify-content-center">
        <form class="col-md-4 m-3 p-4 shadow bg-white" action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"])); ?>" method="post">
            <div>
                <h4>Login</h4>
                Please login to your account to proceed
            </div>
            <hr>
            <div class="mt-4 form-floating">
                <input type="text" value="<?php echo($saved_data["email"]);?>" name="email" id="email" placeholder="" class="form-control" required />
                <label for="email">Email</label>
                <div class="mt-1 text-danger">
                    <?php echo($errors["email"]); ?>
                </div>
            </div>
            <div class="mt-4 form-floating">
                <input type="password" value="<?php echo($saved_data["password"]);?>" name="password" id="password" placeholder="" class="form-control" required />
                <label for="password">Password</label>
                <div class="mt-1 text-danger">
                    <?php echo($errors["password"]); ?>
                </div>
            </div>
            <div class="mt-4 form-check form-switch">
                <input type="checkbox" id="showpass" class="form-check-input me-3" onclick={funshowpass()}>
                <label for="showpass">show password</label>
                <script>
                    function funshowpass(){
                        var password = document.getElementById("password");
                        if(password.type == "password"){
                            password.type = "text";
                        }else{
                            password.type = "password";
                        }
                    }
                </script>
            </div>
            <div class="mt-4">
                <button name="submit" type="submit" class="btn btn-primary form-control py-2">Login</button>
            </div>
            <div class="mt-4">
                <p>Don't have an account? <a href="/auth/register.php">create one!</a></p>
            </div>
        </form>
    </div>
<?php
    if(is_authenticated()){
        echo("<script>window.location.replace('/');</script>");
    }
    require("../base/footer.php");
?>