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
            <small class="text-white">Change Password</small>
        </div>
        <form action="" method="post" enctype="multipart/form-data">    
            <div class="text-end mb-4">
                <button  class="btn text-white btn-translate">
                    ENG <span class="ms-1"><i class="bi bi-caret-down-fill"></i></span>
                </button>
            </div>
            <div class="text-center mb-3 mt-2">
                <p class="mb-1 text">
                    <span class="text-muted">Create New Password</span>
                </p>
            </div>
            <?php if (!empty($passwordsErr)) { ?>
                <div class="my-1 mb-1 px-1 text-red">
                    <?php echo "*".$passwordsErr["passwordsErr"] ?>
                </div>
            <?php } ?>
            <div class="join-group d-flex align-items-center">
                <span class="bg-white input-text"><i class="bi bi-lock"></i></span>
                <div class="float-input">
                    <input type="password" name="password" value="<?=old_value("password")?>" class="input" id="floatingInput" placeholder="New Password">
                </div>
            </div>
            <?php if (!empty($passwordErr)) { ?>
                <div class="my-1 mb-1 px-1 text-red">
                    <?php echo "*".$passwordErr["passwordErr"] ?>
                </div>
            <?php } ?>
            <div class="join-group d-flex align-items-center">
                <span class="bg-white input-text"><i class="bi bi-lock"></i></span>
                <div class="float-input">
                    <input type="password" name="rptpassword" value="<?=old_value("rptpassword")?>" class="input" id="floatingInput" placeholder="Confirm New Password">
                </div>
            </div>
            <?php if (!empty($rptpasswordErr)) { ?>
                <div class="my-1 mb-1 px-1 text-red">
                    <?php echo "*".$rptpasswordErr["rptpasswordErr"] ?>
                </div>
            <?php } ?>
            <button class="mt-3 w-100 btn btn-lg bg-orange text-white" name="submit" type="submit">Create New Password</button>
        </form>
    </div>


    <!-- Page Footer link -->
    <?php require_once "requires/authpagefooter_links.php" ?>
</body>
</html>