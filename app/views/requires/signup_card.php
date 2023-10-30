<div class="auth-card shadow">
    <div class="text-center auth-header">
        <img class="mb-2" src="<?=ROOT_URL?>/assets/Icons/user-interface-8.svg" alt="">
        <h1 class="h3 mb-2 fw-bold">
            <a href="<?=home()?>" id="auth-signup">Pro<span class="text-white">Invest</span></a>
        </h1>
        <small class="text-white">Register</small>
    </div>
    <form action="" method="post" enctype="multipart/form-data">    
        <div class="text-end mb-4">
            <button  class="btn text-white btn-translate">
                ENG <span class="ms-1"><i class="bi bi-caret-down-fill"></i></span>
            </button>
        </div>
        <?php if (!empty($user->errors["sendemailErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("sendemailErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-person-badge"></i></span>
            <div class="float-input">
                <input type="text" name="firstname" value="<?=old_value("firstname")?>" class="input" id="floatingInput" placeholder="Firstname">
            </div>
        </div>
        <?php if (!empty($user->errors["firstnameErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("firstnameErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-person-badge"></i></span>
            <div class="float-input">
                <input type="text" name="othername" value="<?=old_value("othername")?>" class="input" id="floatingInput" placeholder="Othernames">
            </div>
        </div>
        <?php if (!empty($user->errors["othernameErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("othernameErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-person-circle"></i></span>
            <div class="float-input">
                <input type="text" name="username" value="<?=old_value("username")?>" class="input" id="floatingInput" placeholder="Username">
            </div>
        </div>
        <?php if (!empty($user->errors["usernameErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("usernameErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-envelope"></i></span>
            <div class="float-input">
                <input type="email" name="email" value="<?=old_value("email")?>" class="input" id="floatingInput" placeholder="Email">
            </div>
        </div>
        <?php if (!empty($user->errors["emailErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("emailErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-unlock-fill"></i></span>
            <div class="float-input">
                <input type="password" name="password" value="<?=old_value("password")?>" class="input" id="floatingInput" placeholder="Password">
            </div>
        </div>
        <?php if (!empty($user->errors["passwordErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("passwordErr") ?>
            </div>
        <?php } ?>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-unlock-fill"></i></span>
            <div class="float-input">
                <input type="password" name="rptpassword" value="<?=old_value("rptpassword")?>" class="input" id="floatingInput" placeholder="Confirm Password">
            </div>
        </div>
        <?php if (!empty($user->errors["rptpasswordErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("rptpasswordErr") ?>
            </div>
        <?php } ?>
        <div class="checkbox mb-3">
            <label class="text-white text">
                <input type="checkbox" name="term" value="Accept Terms and Conditions" 
                <?=old_checked("term", "Accept Terms and Conditions")?>
                > Agree to our terms and conditions 
            </label>
        </div>
        <?php if (!empty($user->errors["termErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("termErr") ?>
            </div>
        <?php } ?>
        <button class="mt-3 w-100 btn btn-lg bg-orange text-white" name="submit" type="submit">Sign Up</button>
        <div class="text-center mb-3 mt-2">
            <p class="mb-1">
                <span class="text-muted">Already have an account?</span>
                <a href="<?=login()?>" id="auth-signup" class="text-orange">Log In</a>
            </p>
            <p class="mb-1 text">
                <span class="text-muted">By clicking Sign Up, you read and agreed to our </span>
                <a href="#" id="auth-signup" class="text-orange">Terms and Conditions</a>
            </p>
            <p><a href="<?=home()?>" class="text text-orange" style="text-decoration: none;"><i class="bi bi-chevron-left"></i>Home</a></p>
        </div>
    </form>
</div>