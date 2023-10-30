<!DOCTYPE html>
<html lang="en">
<head>
    
    <!-- Page Head Content -->
    <?php require_once "requires/pagehead_content.php" ?>
    
    <!-- Page Head Links -->
    <?php require_once "requires/authpagehead_links.php" ?>
    
</head>
<body>
    
    <!-- SVG Images -->
    <?php require_once "requires/svg_images.php" ?>

    <!-- <img src="Image/explain1.png" class="bg-image" alt="" > -->
    <div class="auth-card shadow">
        <div class="text-center auth-header">
            <img class="mb-2" src="<?=ROOT_URL?>/assets/Icons/user-interface-8.svg" alt="">
            <br>
            <small class="text-white">Verify Your Email</small>
        </div>
        <form action="" method="post" enctype="multipart/form-data">    
            <div class="text-end mb-4">
                <button  class="btn text-white btn-translate">
                    ENG <span class="ms-1"><i class="bi bi-caret-down-fill"></i></span>
                </button>
            </div>
            <div class="text-center mb-3 mt-2">
                <p class="mb-1 text">
                    <span class="text-muted">Please Input your Email Here</span>
                </p>
            </div>
            <div class="join-group d-flex align-items-center">
                <span class="bg-white input-text"><i class="bi bi-envelope"></i></span>
                <div class="float-input">
                    <input type="email" name="email" value="<?=old_value("email")?>" class="input" id="floatingInput" placeholder="Email Address">
                </div>
            </div>
            <?php if (!empty($emailErr)) { ?>
                <div class="my-1 mb-1 px-1 text-red">
                    <?php echo "*".$emailErr["emailErr"] ?>
                </div>
            <?php } ?>
            <button class="mt-3 w-100 btn btn-lg bg-orange text-white" name="submit" type="submit">Submit</button>
            <div class="text-center mb-3 mt-2">
                <p class="mb-1 text">
                    <a href="<?=signup()."/auth"?>" id="auth-signup" class="text-orange">Sign Up</a>
                    <br>
                    <a href="<?=login()."/auth"?>" id="auth-signup" class="text-orange">Login</a>
                </p>
            </div>
        </form>
    </div>


    <!-- Page Footer link -->
    <?php require_once "requires/authpagefooter_links.php" ?>
</body>
</html>