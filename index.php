<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Travelit — Discover curated travel packages across India. Book Kashmir, Darjeeling, Delhi and more.">
    <title>Travelit — Experience India</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="logo">Travelit</div>

        <nav>
            <ul class="nav-links">
                <li><a href="#destinations">Destinations</a></li>
                <li><a href="packages.php">Experiences</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>

        <div class="d-flex align-items-center gap-2 desktop-auth">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="text-light me-2" style="font-size:0.85rem;">
                    Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                </span>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === "admin"): ?>
                    <a href="admin/dashboard.php" class="btn btn-sm" style="background:#c5a47e;color:#000;font-weight:600;">Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
            <a href="#searchSection" class="btn btn-luxury btn-sm ms-1">Book Now</a>
        </div>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle navigation">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="#destinations">Destinations</a></li>
            <li><a href="packages.php">Experiences</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
        <div class="auth-links">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
                <?php if(isset($_SESSION['user_role']) && $_SESSION['user_role'] === "admin"): ?>
                    <a href="admin/dashboard.php" class="btn btn-sm btn-luxury">Admin</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>


<div class="hero">
    <div class="hero-content">
        <h1>Experience India<br>With Travelit</h1>
        <p>Curated destinations. Unforgettable journeys.</p>
        <a href="#searchSection" class="btn btn-luxury">Explore Packages &nbsp;<i class="fa fa-arrow-down"></i></a>
    </div>
</div>


<div class="search-section" id="searchSection">
    <div class="container">
        <form action="packages.php" method="GET" class="search-box row g-3 align-items-end">
            <div class="col-md-3 col-6">
                <label>Destination</label>
                <select name="destination_id" class="form-control">
                    <option value="">All Destinations</option>
                    <option value="1">Kashmir</option>
                    <option value="2">Darjeeling</option>
                    <option value="3">Delhi</option>
                </select>
            </div>

            <div class="col-md-4 col-6">
                <label>Travel Date</label>
                <input type="text" id="dateRange" name="travel_date" class="form-control" placeholder="Pick a date">
            </div>

            <div class="col-md-2 col-6">
                <label>Guests</label>
                <input type="number" name="guests" class="form-control" placeholder="2" min="1">
            </div>

            <div class="col-md-3 col-6">
                <button type="submit" class="btn btn-luxury w-100">Search</button>
            </div>
        </form>
    </div>
</div>


<div class="container my-5" id="featured">
    <h2 class="text-center mb-4 section-title">Featured Packages</h2>

    <div id="featuredCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner" id="featuredPackages"></div>

        <button class="carousel-control-prev" type="button" data-bs-target="#featuredCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#featuredCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</div>


<div class="container my-5" id="about">
    <div class="about-section">
        <h2 class="section-title mb-3">About Travelit</h2>
        <p>
            Travelit is a premium travel platform built to help explorers discover the most beautiful destinations
            across India. We curate handpicked experiences, luxury travel packages, and seamless booking for
            journeys you'll remember for a lifetime.
        </p>
        <div class="stats-row">
            <div class="stat-item">
                <div class="number">500+</div>
                <div class="label">Happy Travelers</div>
            </div>
            <div class="stat-item">
                <div class="number">12+</div>
                <div class="label">Destinations</div>
            </div>
            <div class="stat-item">
                <div class="number">98%</div>
                <div class="label">Satisfaction Rate</div>
            </div>
            <div class="stat-item">
                <div class="number">5★</div>
                <div class="label">Avg. Rating</div>
            </div>
        </div>
    </div>
</div>


<div class="container my-5" id="destinations">
    <h2 class="text-center mb-5 section-title">Explore Destinations</h2>
    <div class="row" id="destinationList"></div>
</div>


<footer class="footer" id="contact">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="footer-title">Travelit</h4>
                <p>Curated travel experiences across India. Luxury, comfort, and adventure await.</p>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="footer-title">Company</h6>
                <p><a href="#about">About Us</a></p>
                <p><a href="#">Careers</a></p>
                <p><a href="#">Press</a></p>
            </div>

            <div class="col-md-2 mb-4">
                <h6 class="footer-title">Support</h6>
                <p><a href="#contact">Contact</a></p>
                <p><a href="#">FAQs</a></p>
                <p><a href="#">Privacy Policy</a></p>
            </div>

            <div class="col-md-4 mb-4">
                <h6 class="footer-title">Quick Feedback</h6>
                <textarea id="footerFeedback" class="form-control mb-2" rows="2"
                    placeholder="Share your experience..." style="background:#111;border:1px solid #222;color:#fff;border-radius:8px;"></textarea>
                <select id="footerFeedbackRating" class="form-control mb-2"
                    style="background:#111;border:1px solid #222;color:#fff;border-radius:8px;">
                    <option value="">Rate us (optional)</option>
                    <option value="1">1 — Poor</option>
                    <option value="2">2 — Fair</option>
                    <option value="3">3 — Good</option>
                    <option value="4">4 — Very Good</option>
                    <option value="5">5 — Excellent</option>
                </select>
                <button id="submitFeedback" class="btn btn-luxury w-100">Submit Feedback</button>
                <div id="footerFeedbackMsg" class="mt-2 small"></div>
            </div>
        </div>

        <hr style="border-color:#1a1a1a;">
        <p class="text-center small" style="color:#555;">© 2026 Travelit. All Rights Reserved.</p>
    </div>
</footer>

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

<!-- JAVASCRIPT SECTION -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- BOOKING -->
<script>
$("#popupBookingForm").submit(function(e){

    e.preventDefault();

    $.ajax({
        url: "api/send_popup_email.php",
        type: "POST",
        data: $(this).serialize(),
        success: function(response){

            if(response === "success"){

                $("#bookingResponse").html(
                    "<span class='text-success'>Request sent successfully!</span>"
                );

                setTimeout(function(){

                    let modal = bootstrap.Modal.getInstance(
                        document.getElementById("bookingModal")
                    );

                    modal.hide();

                },1500);

            }
        }
    });

});
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    setTimeout(function () {

        var modal = new bootstrap.Modal(
            document.getElementById("bookingModal")
        );

        modal.show();

    }, 1500); // popup after 1.5 seconds

});
</script>

<script>
flatpickr("#dateRange", {
    minDate: "today",
    dateFormat: "Y-m-d"
});

document.getElementById("hamburgerBtn").addEventListener("click", function() {
    document.getElementById("mobileMenu").classList.toggle("open");
});

$(document).ready(function() {
    $.ajax({
        url: "api/get_destinations.php",
        method: "GET",
        success: function(data) {
            let destinations = JSON.parse(data);
            let html = "";
            destinations.forEach(function(dest) {
                html += `
                    <div class="col-md-4 mb-4">
                        <div class="destination-card">
                            <img src="assets/images/${dest.image}" class="img-fluid" alt="${dest.name}">
                            <div class="overlay">
                                <h3>${dest.name}</h3>
                                <p>${dest.description}</p>
                                <a href="packages.php?destination_id=${dest.id}" class="btn btn-luxury mt-1">Explore</a>
                            </div>
                        </div>
                    </div>
                `;
            });
            $("#destinationList").html(html);
        }
    });

    $.ajax({
        url: "api/get_featured_packages.php",
        method: "GET",
        dataType: "json",
        success: function(packages) {
            let html = "";
            packages.forEach(function(pkg, index) {
                html += `
                    <div class="carousel-item ${index === 0 ? "active" : ""}">
                        <div class="featured-card text-center">
                            <img src="assets/images/${pkg.destination.toLowerCase()}.jpg"
                                 class="img-fluid" alt="${pkg.destination}">
                            <div class="featured-info">
                                <h3>${pkg.destination} Package</h3>
                                <p>${pkg.days} &bull; ${pkg.transport}</p>
                                <a href="packages.php?destination_id=${pkg.destination_id}" class="btn btn-luxury">
                                    View Package
                                </a>
                            </div>
                        </div>
                    </div>
                `;
            });
            $("#featuredPackages").html(html);
        }
    });

    $("#submitFeedback").click(function() {
        let feedback = $("#footerFeedback").val().trim();
        let rating = $("#footerFeedbackRating").val();

        if(feedback === "") {
            $("#footerFeedbackMsg").html("<span class='text-danger'>Please enter your feedback first.</span>");
            return;
        }

        $.ajax({
            url: "api/submit_feedback.php",
            method: "POST",
            data: { message: feedback, rating: rating },
            success: function() {
                $("#footerFeedbackMsg").html("<span class='text-success'>Thank you for your feedback! 🙌</span>");
                $("#footerFeedback").val("");
                $("#footerFeedbackRating").val("");
            },
            error: function() {
                $("#footerFeedbackMsg").html("<span class='text-danger'>Oops! Something went wrong.</span>");
            }
        });
    });

});
</script>
<script src="//code.tidio.co/tmz4e9ca2y27zyvyjzpdncaikitn4vkh.js" async></script>
</body>
</html>