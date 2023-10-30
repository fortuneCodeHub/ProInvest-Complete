<nav class="navbar navbar-expand-lg">
    <div class="container">
        <div class="navbar-brand">
            <a href="<?=home()?>">Pro<span>Invest</span></a>
        </div>
        <div class="ms-3 order-lg-last">
            <button  class="btn btn-translate shadow">
                ENG <span class="ms-1"><i class="bi bi-caret-down-fill"></i></span>
            </button>
        </div>
        <button class="navbar-toggler navbar-btn shadow" type="button" aria-label="Toggle navigation" id="offCanvasBtn">
            <i class="bi bi-list" ></i>
        </button>
        <div class="navbar-collapse offcanvas-collapse" id="navmenu">
            <!-- <div class="offcanvas-bases"> -->
                <div class="offcanvas-bar d-lg-none py-5 px-1 text-end">
                    <button id="offCanvasBtn" class="btn btn-closer shadow" type="button">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
                <ul class="navbar-nav ms-auto">
                    <?php if (!empty($data["sessions"])) { ?>
                        <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                            <?php
                            $value["id"] = $data["sessions"]["id"];
                            // $data["email"] = $data["sessions"]["email"];
                            $users = new \app\model\User();
                            $users = $users->where($value);
                            foreach ($users as $user) {
                                $user = $user;
                            }
                            ?>
                            Welcome <?=$user["firstname"]?>
                        </li>
                    <?php }?>
                    <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                        <a href="<?=home()?>" class="nav-link active px-sm-1 px-2" id="nav-link">
                            Home
                        </a>
                    </li>
                    <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                        <a href="#aboutus" class="nav-link px-sm-1 px-2" id="nav-link">
                            About Us
                        </a>
                    </li>
                    <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                        <a href="#investmentplans" class="nav-link px-sm-1 px-2" id="nav-link">
                            Investment Plans
                        </a>
                    </li>
                    <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                        <a href="#ourservices" class="nav-link px-sm-1 px-2" id="nav-link">
                            Our Services
                        </a>
                    </li>
                    <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                        <a href="#contactus" class="nav-link px-sm-1 px-2" id="nav-link">
                            Contact Us
                        </a>
                    </li>
                    <?php if (!empty($data["sessions"])) { ?>
                        <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                            <a href="<?=logout()?>" class="nav-link px-sm-1 px-2" id="nav-link">
                                Logout
                            </a>
                        </li>
                    <?php } else { ?>
                        <?php //show_array($_SESSION["USER"]) ?>
                        <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                            <a href="<?=login()."/auth"?>" class="nav-link px-sm-1 px-2" id="nav-link">
                                Login
                            </a>
                        </li>
                        <li class="nav-item my-sm-0 my-1 mx-sm-1 mx-0">
                            <a href="<?=signup()."/auth"?>" class="nav-link px-sm-1 px-2" id="nav-link">
                                Registration
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <!-- </div> -->
        </div>
    </div>
</nav>
