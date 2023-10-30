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
                    <span class="text-muted">An OTP Verification code has been sent to your email,</span>
                </p>
            </div>
            <div class="join-group d-flex align-items-center">
                <span class="bg-white input-text"><i class="bi bi-lock"></i></span>
                <div class="float-input">
                    <input type="text" name="otp" value="<?=old_value("otp")?>" class="input" id="floatingInput" placeholder="Verify Your Email, Input OTP Here">
                </div>
            </div>
            <?php if (!empty($otpErr)) { ?>
                <div class="my-1 mb-1 px-1 text-red">
                    <?php echo "*".$otpErr["otpErr"] ?>
                </div>
            <?php } ?>
            <button class="mt-3 w-100 btn btn-lg bg-orange text-white" name="submit" type="submit">Verify</button>
            <div class="text-center mb-3 mt-2">
                <p class="mb-1 text">
                    <span class="text-muted">if you haven't seen the otp code tap</span>
                    <a href="<?=verify_OTP()."/verify/resend"?>" id="auth-signup" class="text-orange">Resend OTP</a>
                </p>
            </div>
        </form>
    </div>


    <!-- Page Footer link -->
    <?php require_once "requires/authpagefooter_links.php" ?>
</body>
</html>