<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Travelit</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!--Flatpicker for date-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">Travelit</div>

        <nav>
            <ul class="nav-links">
                <li><a href="#">Destinations</a></li>
                <li><a href="#">Experiences</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>

        <div>
            <?php if(isset($_SESSION['user_id'])): ?>

                <span class="text-light me-3">
                    Welcome, <?php echo $_SESSION['user_name']; ?>
                </span>

                <a href="logout.php" class="btn btn-danger me-2">Logout</a>

            <?php else: ?>

                <a href="login.php" class="btn btn-outline-light me-2">Sign In</a>
                <a href="register.php" class="btn btn-light me-2">Register</a>

            <?php endif; ?>

            <a href="#searchSection" class="btn btn-luxury">Book Now</a>
        </div>

    </div>
</header>


<!-- ===== HERO SECTION ===== -->
<div class="hero">
    <div class="text-center">
        <h1 class="display-4">Experience India With Travelit</h1>
        <p>Discover curated destinations across India</p>
    </div>
</div>

<!-- SEARCH BAR -->
<div class="search-section" id="searchSection">
    <div class="container">
        <form action="packages.php" method="GET" class="search-box row g-3 align-items-end">

            <div class="col-md-3">
                <label>Destination</label>
                <select class="form-control">
                    <option>Select Destination</option>
                    <option>Delhi</option>
                    <option>Kashmir</option>
                    <option>Darjeeling</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Travel Dates</label>
                <input type="text" id="dateRange" class="form-control" placeholder="Select your travel dates">
            </div>

            <div class="col-md-2">
                <label>Guests</label>
                <input type="number" class="form-control" placeholder="2">
            </div>

            <div class="col-md-3">
                <button type="submit" class="btn btn-luxury w-100">Search</button>
            </div>

        </div>
    </div>
</div>

<!-- FEATURED PACKAGES -->
<div class="container my-5">
    <h2 class="text-center mb-4 section-title">Featured Packages</h2>

    <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">

            <!-- DELHI -->
            <div class="carousel-item active">
                <div class="featured-card text-center">
                    <img src="assets/images/delhi.jpg" class="img-fluid">
                    <div class="featured-info">
                        <h3>Delhi Heritage Experience</h3>
                        <p>3 Nights • Guided City Tours • Luxury Stay</p>
                        <a href="packages.php?destination_id=1" class="btn btn-luxury">View Package</a>
                    </div>
                </div>
            </div>

            <!-- KASHMIR -->
            <div class="carousel-item">
                <div class="featured-card text-center">
                    <img src="assets/images/kashmir.jpg" class="img-fluid">
                    <div class="featured-info">
                        <h3>Kashmir Scenic Retreat</h3>
                        <p>4 Nights • Houseboat Stay • Mountain Views</p>
                        <a href="packages.php?destination_id=2" class="btn btn-luxury">View Package</a>
                    </div>
                </div>
            </div>

            <!-- DARJEELING -->
            <div class="carousel-item">
                <div class="featured-card text-center">
                    <img src="assets/images/darjeeling.jpg" class="img-fluid">
                    <div class="featured-info">
                        <h3>Darjeeling Tea Hills Escape</h3>
                        <p>3 Nights • Hill View Resort • Nature Tours</p>
                        <a href="packages.php?destination_id=3" class="btn btn-luxury">View Package</a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>
</div>

<!-- ===== DESTINATIONS ===== -->
<div class="container my-5">
    <h2 class="text-center mb-5 section-title">Explore Destinations</h2>
    <div class="row" id="destinationList"></div>
</div>


<!-- ===== AJAX ===== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function(){
    $.ajax({
        url: "api/get_destinations.php",
        method: "GET",
        success: function(data){
            let destinations = JSON.parse(data);
            let html = "";

            destinations.forEach(function(dest){
                html += `
                    <div class="col-md-4 mb-4">
                        <div class="destination-card">
                            <img src="assets/images/${dest.image}" class="img-fluid">
                            <div class="overlay">
                                <h3>${dest.name}</h3>
                                <p>${dest.description}</p>
                                <a href="packages.php?destination_id=${dest.id}" class="btn btn-luxury mt-2">Explore</a>
                            </div>
                        </div>
                    </div>
                `;
            });

            $("#destinationList").html(html);
        }
    });
});
</script>


<!-- ===== FOOTER ===== -->
<footer class="footer">
    <div class="container">
        <div class="row text-start">

            <div class="col-md-4 mb-4">
                <h4 class="footer-title">Travelit</h4>
                <p>Curated travel experiences across India.</p>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="footer-title">Company</h6>
                <p>About</p>
                <p>Careers</p>
                <p>Press</p>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="footer-title">Support</h6>
                <p>Contact</p>
                <p>FAQs</p>
                <p>Privacy</p>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="footer-title">Newsletter</h6>
                <input type="email" class="form-control mb-2" placeholder="Your email">
                <button class="btn btn-luxury w-100">Subscribe</button>
            </div>

        </div>

        <hr style="border-color: #333;">
        <p class="text-center small">© 2026 Travelit. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
flatpickr("#dateRange", {
    mode: "range",
    minDate: "today",
    dateFormat: "Y-m-d"
});
</script>

<!-- BOOKING MODAL -->
<div class="modal fade" id="bookingModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">

      <div class="modal-header">
        <h5 class="modal-title text-dark">Book Travel Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <form id="popupBookingForm">

          <input type="hidden" name="package_id" id="modalPackageId">

          <div class="mb-3">
            <label class="form-label text-dark">Full Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark">Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark">Travel Date</label>
            <input type="date" name="travel_date" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label text-dark">Number of People</label>
            <input type="number" name="num_people" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-success w-100">
            Submit Booking
          </button>

        </form>

        <div id="bookingResponse" class="mt-3"></div>

      </div>

    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    // check if popup already shown
    if (!localStorage.getItem("travelitPopupShown")) {

        setTimeout(function () {

            var modal = new bootstrap.Modal(document.getElementById("bookingModal"));
            modal.show();

            // remember popup was shown
            localStorage.setItem("travelitPopupShown", "true");

        }, 1500); // delay 1.5 seconds
    }

});
</script>

</body>
</html>

</body>
</html>
