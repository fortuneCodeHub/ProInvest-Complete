<div class="auth-card shadow">
    <div class="text-center auth-header">
        <img class="mb-2" src="<?=ROOT_URL?>/assets/Icons/user-interface-8.svg" alt="">
        <h1 class="h3 mb-2 fw-bold">
            <a href="<?=home()?>" id="auth-signup">Pro<span class="text-white">Invest</span></a>
        </h1>
        <small class="text-white">Please log in here</small>
    </div>
    <form action="" method="post" enctype="multipart/form-data">    
        <div class="text-end mb-4">
            <button  class="btn text-white btn-translate">
                ENG <span class="ms-1"><i class="bi bi-caret-down-fill"></i></span>
            </button>
        </div>
        <div class="join-group d-flex align-items-center">
            <span class="bg-white input-text"><i class="bi bi-person-circle"></i></span>
            <div class="float-input">
                <input type="text" name="email" class="input" value="<?=old_value("email")?>" id="floatingInput" placeholder="Email">
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
                <input type="password" name="password" class="input" id="floatingInput" placeholder="Password">
            </div>
        </div>
        <?php if (!empty($user->errors["passwordErr"])) { ?>
            <div class="my-1 mb-1 px-1 text-red">
                <?php echo "*".$user->getError("passwordErr") ?>
            </div>
        <?php } ?>
        <button class="mt-3 w-100 btn btn-lg bg-orange text-white" name="submit" type="submit">Log In</button>
        <div class="text-center mb-3 mt-2">
            <p class="mb-1 text-orange"><a href="<?=forgot_PWD()."/auth"?>" class="text-orange" style="text-decoration: none;">Forgot Password?</a></p>
            <p class="mb-1">
                <span class="text-muted">New to ProInvest?</span>
                <a href="<?=signup()?>" id="auth-signup" class="text-orange">Create an account</a>
            </p>
            <p>
                <a href="<?=home()?>" class="text text-orange" style="text-decoration: none;"><i class="bi bi-chevron-left"></i>Home</a>
            </p>
        </div>
    </form>
</div>