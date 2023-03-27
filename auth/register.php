<?php
    require("../base/authheader.php");
    $errors = [
        "email" => "",
        "phone_number" => "",
        "full_name" => "",
        "lastName" => "",
        "password" => ""
    ];

    $saved_user = [
        "email" => "",
        "phone_number" => "",
        "full_name" => "",
        "lastName" => "",
        "password" => ""
    ];

    if(isset($_POST["submit"])){
        $saved_user = [
            "email" => htmlspecialchars($_POST["email"]),
            "phone_number" => htmlspecialchars($_POST["phone_number"]),
            "full_name" => strtoupper(htmlspecialchars($_POST["full_name"])),
            "password" => htmlspecialchars($_POST["password"])
        ];
        $emailRegisteredQuery = $db_connect->query("SELECT email FROM user WHERE email='{$saved_user['email']}'");
        $emailRegistered = $emailRegisteredQuery->fetch(PDO::FETCH_ASSOC);
        if(!empty($emailRegistered)){
            $errors["email"] = "This email is already registered";
        }else{
            $phoneRegisteredQuery = $db_connect->query("SELECT email FROM user WHERE phone_number='{$saved_user["phone_number"]}'");
            $phoneRegistered = $phoneRegisteredQuery->fetch(PDO::FETCH_ASSOC);
            if(!empty($emailRegistered)){
                $errors["phone_number"] = "This phone number is already registered";
            }else{
                try{
                    $user_uuid = generate_uuid($table="user",$uuid_field="user_id");
                    $passwordHash = password_hash($_POST["password"],PASSWORD_DEFAULT);
                    $insertUser = $db_connect->exec("INSERT INTO user(user_id,email,phone_number,full_name,password) VALUES('{$user_uuid}','{$saved_user['email']}','{$saved_user["phone_number"]}','{$saved_user["full_name"]}','{$passwordHash}')");
                    session_unset();
                    echo("
                        <script>window.location.replace('/auth/login.php');</script>
                    ");
                }catch(PDOException $e){
                    $_SESSION["general_error"] = "An error occured please try again";
                }
            }
        }
    }
?>
    <div class="container-fluid">
        <div class="col-md-4 mx-auto bg-white shadow p-3 mt-5">
            <form action="<?php echo(htmlspecialchars($_SERVER["PHP_SELF"])); ?>" method="post">
                <div>
                    <h4>Create Account</h4>
                    Create an account to access our services
                </div>
                <hr />
                <div class="my-3 text-danger">
                    <?php 
                    if(isset($_SESSION["general_error"])){
                        echo($_SESSION["general_error"]);
                    }?>
                </div>
                <div class="mt-2 form-floating">
                    <input class="form-control" type="email" value="<?php echo($saved_user["email"]);?>" name="email" id="email" placeholder="" required/>
                    <label class="form-label" for="email">Email</label>
                    <div class="mt-1 text-danger">
                        <?php echo($errors["email"]); ?>
                    </div>
                </div>
                <div class="mt-2 form-floating">
                    <input class="form-control" type="text" name="phone_number" value="<?php echo($saved_user["phone_number"]);?>" id="phone_number" placeholder="" required/>
                    <label class="form-label" for="phone_number">Phone Number</label>
                    <div class="mt-1 text-danger">
                        <?php echo($errors["phone_number"]); ?>
                    </div>
                </div>
                <div class="mt-2 form-floating">
                    <input class="form-control" type="text" name="full_name" value="<?php echo($saved_user["full_name"]);?>" id="full_name" placeholder="" required/>
                    <label class="form-label" for="full_name">Full Name</label>
                    <div class="mt-1 text-danger">
                        <?php echo($errors["full_name"]); ?>
                    </div>
                </div>
                <div class="mt-4 form-floating">
                    <input type="password" name="password" value="<?php echo($saved_user["password"]);?>" id="password" placeholder="" class="form-control" required />
                    <label for="password">Password</label>
                    <div class="mt-1 text-danger">
                        <?php echo($errors["password"]); ?>
                    </div>
                </div>
                <div class="mt-4 form-check form-switch">
                    <input type="checkbox" id="showpass" class="form-check-input me-3" onclick={funshowpass()} />
                    <label for="showpass">show password</label>
                    <script>
                        function funshowpass(){
                            var password = document.getElementById("password");
                            alert(password);
                            if(password.type == "password"){
                                password.type = "text";
                            }else{
                                password.type = "password";
                            }
                        }
                    </script>
                </div>
                <div class="mt-2">
                    <button type="submit" name="submit" class="btn btn-primary form-control py-2">Create Account</button>
                </div>
                <div class="mt-2">
                    <p>Already have an account ? <a href="/auth/login.php">Login</a> </p>
                </div>
            </form>
        </div>
    </div>
<?php 
    if(is_authenticated()){
        echo("<script>window.location.replace('/');</script>");
    }
    require("../base/footer.php");
?>