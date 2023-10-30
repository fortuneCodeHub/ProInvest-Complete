<section class="carousel-section">
    <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <input type="radio" data-bs-target="#myCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1" name="carousel" style="width: 15px; height: 15px;">
            <input type="radio" data-bs-target="#myCarousel" data-bs-slide-to="1" aria-current="true" aria-label="Slide 2" name="carousel" style="width: 15px; height: 15px;">
            <input type="radio" data-bs-target="#myCarousel" data-bs-slide-to="2" aria-current="true" aria-label="Slide 3" name="carousel" style="width: 15px; height: 15px;">
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active" style="background-image: url(<?=ROOT_URL?>/assets/Image/image\ \(1\).JPG);" data-bs-interval="10000">
            <div class="container">
              <div class="carousel-caption text-start">
                <h1 class="header">
                    Welcome To Pro<span style="color: black;">Invest</span><br>
                    <span></span>
                </h1>
                <p class="text">Register Now , invest with us and stand a chance to win great profit cash out.</p>
                <p class="link">
                    <a href="<?=signup()."/auth"?>" class="btn btn-lg btn-cover uppercase shadow" data-tooltip="register now to learn more">Register Now</a>
                    <a href="#aboutus" class="btn btn-lg btn-outline uppercase shadow" data-tooltip="learn more about us">About Us</a>
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url(<?=ROOT_URL?>/assets/Image/image\ \(2\).JPG);" data-bs-interval="10000">
            <div class="container">
              <div class="carousel-caption text-start">
                <h1 class="header">
                    Generate Real Profit <br>
                    <span>With Us !</span>
                </h1>
                <p class="text">We offer the best crypto investment services with 7 years of experience in the crypto market, so we assure you of winning great profit once you invest with us.</p>
                <p class="link">
                    <a href="<?=signup()."/auth"?>" class="btn btn-lg btn-cover uppercase shadow" data-tooltip="register now to learn more">Register Now</a>
                    <a href="<?=login()."/auth"?>" class="btn btn-lg btn-outline uppercase shadow" data-tooltip="login now if already a member">Login</a>
                </p>
              </div>
            </div>
          </div>
          <div class="carousel-item" style="background-image: url(<?=ROOT_URL?>/assets/Image/image\ \(3\).JPG);" data-bs-interval="10000">
            <div class="container">
              <div class="carousel-caption text-start">
                <h1 class="header">
                    Become a True Partner <br>
                    <span>On Investment Market</span>
                </h1>
                <p class="text">
                    We will offer you great wins in the crypto market, just be sure to register and invest with us today
                </p>
                <p class="link">
                    <a href="<?=signup()."/auth"?>" class="btn btn-lg btn-cover uppercase shadow" data-tooltip="register now to learn more">Register Now</a>
                    <a href="#aboutus" class="btn btn-lg btn-outline uppercase shadow" data-tooltip="learn more about us">About Us</a>
                </p>
              </div>
            </div>
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#myCarousel" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#myCarousel" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>