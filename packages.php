<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Browse Travelit's premium travel packages across India. Book Kashmir, Darjeeling, Delhi experiences online.">
    <title>Travelit — Our Packages</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<header class="custom-navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="index.php" class="logo" style="text-decoration:none;">Travelit</a>

        <nav>
            <ul class="nav-links">
                <li><a href="index.php#destinations">Destinations</a></li>
                <li><a href="packages.php">Experiences</a></li>
                <li><a href="index.php#about">About</a></li>
                <li><a href="index.php#contact">Contact</a></li>
            </ul>
        </nav>

        <div class="d-flex align-items-center gap-2 desktop-auth">
            <?php if(isset($_SESSION['user_id'])): ?>
                <span class="text-light me-2" style="font-size:0.85rem;">Hi, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
        </div>

        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu">
            <span></span><span></span><span></span>
        </button>
    </div>

    <div class="mobile-menu" id="mobileMenu">
        <ul>
            <li><a href="index.php#destinations">Destinations</a></li>
            <li><a href="packages.php">Experiences</a></li>
            <li><a href="index.php#about">About</a></li>
            <li><a href="index.php#contact">Contact</a></li>
        </ul>
        <div class="auth-links">
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="btn btn-sm btn-outline-secondary text-light">Logout</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-sm btn-outline-light">Sign In</a>
                <a href="register.php" class="btn btn-sm btn-luxury">Register</a>
            <?php endif; ?>
        </div>
    </div>
</header>


<div style="background: linear-gradient(135deg,#0a0a0a,#111); padding: 60px 0 40px; text-align:center; border-bottom:1px solid rgba(197,164,126,0.1);">
    <h1 style="font-weight:700; font-size:2.2rem; color:#fff;">Our <span style="color:#c5a47e;">Premium</span> Packages</h1>
    <p style="color:#888; margin-top:8px;">Carefully crafted travel experiences across India</p>
</div>


<div class="container mt-5">
    <h2 class="text-center mb-4 section-title">Available Packages</h2>
    <div class="row" id="packageList">
        <div class="col-12 text-center py-5">
            <div class="spinner-border" style="color:#c5a47e;" role="status"></div>
            <p class="mt-3" style="color:#888;">Loading packages...</p>
        </div>
    </div>
</div>


<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius:16px; overflow:hidden; border:none;">

            <div class="modal-header" style="background:linear-gradient(135deg,#c5a47e,#a8845a); border:none; padding:20px 24px;">
                <div>
                    <h5 class="modal-title text-dark fw-bold mb-0" id="modalTitle">Book Your Package</h5>
                    <small class="text-dark" style="opacity:0.7;" id="modalSubtitle">Fill in your details to proceed</small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">

                <div class="step-indicator mb-4">
                    <div class="step-dot active" id="dot1"></div>
                    <div class="step-dot" id="dot2"></div>
                    <div class="step-dot" id="dot3"></div>
                </div>

                <div class="booking-step active" id="step1">
                    <div id="selectedPackageInfo" class="package-summary-box mb-4" style="display:none;">
                        <h6>Selected Package</h6>
                        <p id="pkgInfoText"></p>
                    </div>
                    <form id="bookingDetailsForm" novalidate>
                        <input type="hidden" id="modalPackageId" name="package_id">
                        <input type="hidden" id="modalDestination" name="destination">
                        <input type="hidden" id="modalDays" name="days">
                        <input type="hidden" id="modalTransport" name="transport">
                        <input type="hidden" id="modalPrice" name="price">

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-500" style="color:#333; font-size:0.85rem; font-weight:500;">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="bookName" class="form-control" placeholder="Your full name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="bookEmail" class="form-control" placeholder="your@email.com" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="bookPhone" class="form-control" placeholder="+91 98765 43210" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Travel Date <span class="text-danger">*</span></label>
                                <input type="date" name="travel_date" id="bookDate" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Number of People <span class="text-danger">*</span></label>
                                <input type="number" name="num_people" id="bookPeople" class="form-control" placeholder="2" min="1" max="20" required>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <div class="w-100 p-3" style="background:#f8f5f0; border-radius:10px; border-left:3px solid #c5a47e;">
                                    <small style="color:#888;">Total Estimate</small>
                                    <div id="pricePreview" style="font-size:1.4rem; font-weight:700; color:#c5a47e;">₹0</div>
                                </div>
                            </div>
                        </div>

                        <div id="step1Error" class="text-danger mt-2 small"></div>

                        <button type="button" class="btn btn-luxury w-100 mt-4" onclick="proceedToPayment()">
                            Continue to Payment &nbsp;<i class="fa fa-arrow-right"></i>
                        </button>
                    </form>
                </div>

                <div class="booking-step" id="step2">
                    <div class="package-summary-box mb-4">
                        <h6>Booking Summary</h6>
                        <p id="summaryDestination">Destination: —</p>
                        <p id="summaryDate">Travel Date: —</p>
                        <p id="summaryPeople">Travelers: —</p>
                        <p id="summaryTransport">Transport: —</p>
                        <div class="price-total" id="summaryTotal">Total: ₹0</div>
                    </div>

                    <h6 style="color:#333; font-weight:600; margin-bottom:14px;">Choose Payment Method</h6>
                    <div class="payment-methods">
                        <div class="pay-method-btn selected" id="btnCard" onclick="selectMethod('card')">
                            💳 Card
                        </div>
                        <div class="pay-method-btn" id="btnUPI" onclick="selectMethod('upi')">
                            📱 UPI
                        </div>
                        <div class="pay-method-btn" id="btnNetBanking" onclick="selectMethod('netbanking')">
                            🏦 Net Banking
                        </div>
                    </div>

                    <div class="payment-fields active" id="cardFields">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Card Number</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="4242 4242 4242 4242"
                                    maxlength="19" oninput="formatCard(this)">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Expiry</label>
                                <input type="text" class="form-control" id="cardExpiry" placeholder="MM/YY" maxlength="5">
                            </div>
                            <div class="col-6">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">CVV</label>
                                <input type="password" class="form-control" id="cardCvv" placeholder="•••" maxlength="3">
                            </div>
                            <div class="col-12">
                                <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Cardholder Name</label>
                                <input type="text" class="form-control" id="cardName" placeholder="Name on card">
                            </div>
                        </div>
                        <div class="mt-2 small" style="color:#888;"><i class="fa fa-lock"></i> Secured with 256-bit SSL encryption (demo)</div>
                    </div>

                    <div class="payment-fields" id="upiFields">
                        <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">UPI ID</label>
                        <input type="text" class="form-control" id="upiId" placeholder="yourname@upi">
                        <div class="mt-2 small" style="color:#888;"><i class="fa fa-lock"></i> UPI payment is secure and instant (demo)</div>
                    </div>

                    <div class="payment-fields" id="netbankingFields">
                        <label class="form-label" style="color:#333; font-size:0.85rem; font-weight:500;">Select Bank</label>
                        <select class="form-control" id="bankSelect">
                            <option value="">-- Choose your bank --</option>
                            <option>State Bank of India</option>
                            <option>HDFC Bank</option>
                            <option>ICICI Bank</option>
                            <option>Axis Bank</option>
                            <option>Kotak Mahindra Bank</option>
                            <option>Punjab National Bank</option>
                        </select>
                        <div class="mt-2 small" style="color:#888;"><i class="fa fa-lock"></i> You will be redirected to your bank (demo)</div>
                    </div>

                    <div id="step2Error" class="text-danger mt-2 small"></div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary" onclick="goToStep(1)">
                            <i class="fa fa-arrow-left"></i> Back
                        </button>
                        <button type="button" class="btn btn-luxury flex-fill" id="payNowBtn" onclick="processMockPayment()">
                            Pay <span id="payBtnAmount">₹0</span> &nbsp;<i class="fa fa-lock"></i>
                        </button>
                    </div>
                </div>

                <div class="booking-step" id="step3">
                    <div class="success-screen">
                        <div class="success-icon">🎉</div>
                        <h4 style="color:#2e7d32; font-weight:700;">Booking Confirmed!</h4>
                        <p style="color:#555; margin:10px 0;">Your travel request has been sent to our team.</p>
                        <div class="booking-ref" id="bookingRefDisplay">TRV-000000</div>
                        <p style="color:#666; font-size:0.9rem; margin-top:12px;">
                            <i class="fa fa-envelope"></i> Our admin will contact you at <strong id="confirmEmail"></strong> within 24 hours to confirm your booking.
                        </p>
                        <div class="mt-4 p-3" style="background:#f0f9f0; border-radius:10px;">
                            <p style="color:#2e7d32; margin:0; font-size:0.85rem;">
                                <i class="fa fa-check-circle"></i> Booking details have been emailed to our team.<br>
                                <i class="fa fa-check-circle"></i> Keep your booking reference safe.<br>
                                <i class="fa fa-check-circle"></i> Admin will reach out soon with final confirmation.
                            </p>
                        </div>
                        <button type="button" class="btn btn-luxury mt-4" data-bs-dismiss="modal">
                            Explore More Packages
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById("hamburgerBtn").addEventListener("click", function() {
    document.getElementById("mobileMenu").classList.toggle("open");
});

let currentPackageData = {};
let selectedMethod = 'card';

$(document).ready(function() {
    const urlParams = new URLSearchParams(window.location.search);
    const destination_id = urlParams.get("destination_id");

    $.ajax({
        url: "api/get_packages.php",
        method: "GET",
        data: destination_id ? { destination_id: destination_id } : {},
        dataType: "json",
        success: function(packages) {
            let html = "";

            if(packages.length === 0) {
                html = "<p class='text-center' style='color:#888;'>No packages available at the moment.</p>";
            } else {
                packages.forEach(pkg => {
                    let img = getDestinationImage(pkg.destination);

                    html += `
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="${img}" class="package-img" alt="${pkg.destination}">
                            <div class="p-4">
                                <h4>${pkg.destination}</h4>
                                <h3>₹${Number(pkg.price).toLocaleString('en-IN')}</h3>
                                <hr>
                                <p><i class="fa fa-calendar-days" style="color:#c5a47e; margin-right:6px;"></i> <strong>Duration:</strong> ${pkg.days}</p>
                                <p><i class="fa fa-bus" style="color:#c5a47e; margin-right:6px;"></i> <strong>Transport:</strong> ${pkg.transport}</p>
                                <button
                                    class="book-btn mt-2"
                                    onclick="openBooking(${pkg.id}, '${pkg.destination}', '${pkg.days}', '${pkg.transport}', ${pkg.price})">
                                    <i class="fa fa-calendar-check"></i> &nbsp;Book Package
                                </button>
                            </div>
                        </div>
                    </div>`;
                });
            }

            $("#packageList").html(html);
        },
        error: function() {
            $("#packageList").html("<p class='text-danger text-center'>Could not load packages. Please try again.</p>");
        }
    });
});

function getDestinationImage(destination) {
    const images = {
        "Delhi": "https://blog.lemontreehotels.com/wp-content/uploads/2025/02/Places-to-Visit-in-Delhi.jpg",
        "Kashmir": "https://media.thekashmirmonitor.net/wp-content/uploads/2023/11/gulmarg-4-_wide-e4eb7356bf7195fbaf7b00ec03326f7f09c47862-scaled.jpg",
        "Darjeeling": "https://static2.tripoto.com/media/filter/tst/img/2012133/Image/1662184373_tourism_darjeeling_india_1280x800.jpg.webp"
    };
    return images[destination] || "assets/images/hero.jpg";
}

function openBooking(id, destination, days, transport, price) {
    currentPackageData = { id, destination, days, transport, price };

    $("#modalPackageId").val(id);
    $("#modalDestination").val(destination);
    $("#modalDays").val(days);
    $("#modalTransport").val(transport);
    $("#modalPrice").val(price);

    $("#pkgInfoText").text(`${destination} — ${days} — ${transport} — ₹${Number(price).toLocaleString('en-IN')} per person`);
    $("#selectedPackageInfo").show();

    $("#bookPeople").val(1);
    updatePricePreview();
    goToStep(1);

    let minDate = new Date();
    minDate.setDate(minDate.getDate() + 1);
    $("#bookDate").attr("min", minDate.toISOString().split("T")[0]);

    new bootstrap.Modal(document.getElementById("bookingModal")).show();
}

$("#bookPeople").on("input", updatePricePreview);

function updatePricePreview() {
    let people = parseInt($("#bookPeople").val()) || 0;
    let price = parseFloat($("#modalPrice").val()) || 0;
    let total = people * price;
    $("#pricePreview").text("₹" + total.toLocaleString('en-IN'));
}

function proceedToPayment() {
    let name = $("#bookName").val().trim();
    let email = $("#bookEmail").val().trim();
    let phone = $("#bookPhone").val().trim();
    let date = $("#bookDate").val();
    let people = parseInt($("#bookPeople").val());

    if(!name || !email || !phone || !date || !people || people < 1) {
        $("#step1Error").text("Please fill in all fields correctly before continuing.");
        return;
    }

    if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
        $("#step1Error").text("Please enter a valid email address.");
        return;
    }

    $("#step1Error").text("");

    let total = people * parseFloat($("#modalPrice").val());

    $("#summaryDestination").text("Destination: " + currentPackageData.destination);
    $("#summaryDate").text("Travel Date: " + date);
    $("#summaryPeople").text("Travelers: " + people + " person(s)");
    $("#summaryTransport").text("Transport: " + currentPackageData.transport);
    $("#summaryTotal").text("Total: ₹" + total.toLocaleString('en-IN'));
    $("#payBtnAmount").text("₹" + total.toLocaleString('en-IN'));

    goToStep(2);
}

function selectMethod(method) {
    selectedMethod = method;
    $(".pay-method-btn").removeClass("selected");
    $(".payment-fields").removeClass("active");

    if(method === "card") {
        $("#btnCard").addClass("selected");
        $("#cardFields").addClass("active");
    } else if(method === "upi") {
        $("#btnUPI").addClass("selected");
        $("#upiFields").addClass("active");
    } else if(method === "netbanking") {
        $("#btnNetBanking").addClass("selected");
        $("#netbankingFields").addClass("active");
    }
}

function formatCard(input) {
    let value = input.value.replace(/\s+/g, "").replace(/[^0-9]/g, "");
    let formatted = value.match(/.{1,4}/g);
    input.value = formatted ? formatted.join(" ") : value;
}

function processMockPayment() {
    $("#step2Error").text("");

    if(selectedMethod === "card") {
        let cn = $("#cardNumber").val().replace(/\s/g, "");
        let name = $("#cardName").val().trim();
        let expiry = $("#cardExpiry").val().trim();
        let cvv = $("#cardCvv").val().trim();
        if(cn.length < 16 || !name || expiry.length < 5 || cvv.length < 3) {
            $("#step2Error").text("Please fill in all card details.");
            return;
        }
    } else if(selectedMethod === "upi") {
        let upi = $("#upiId").val().trim();
        if(!upi || !upi.includes("@")) {
            $("#step2Error").text("Please enter a valid UPI ID (e.g. name@upi).");
            return;
        }
    } else if(selectedMethod === "netbanking") {
        if(!$("#bankSelect").val()) {
            $("#step2Error").text("Please select your bank.");
            return;
        }
    }

    let payBtn = $("#payNowBtn");
    payBtn.html('<span class="spinner-border spinner-border-sm me-2"></span>Processing...').prop("disabled", true);

    setTimeout(function() {
        submitBooking();
    }, 1800);
}

function submitBooking() {
    let formData = {
        package_id: $("#modalPackageId").val(),
        name: $("#bookName").val(),
        email: $("#bookEmail").val(),
        phone: $("#bookPhone").val(),
        travel_date: $("#bookDate").val(),
        num_people: $("#bookPeople").val(),
        destination: $("#modalDestination").val(),
        days: $("#modalDays").val(),
        transport: $("#modalTransport").val(),
        price: $("#modalPrice").val(),
        payment_method: selectedMethod
    };

    $.ajax({
        url: "api/send_booking_email.php",
        method: "POST",
        data: formData,
        success: function(res) {
            let bookingRef = "TRV-" + Math.floor(100000 + Math.random() * 900000);
            $("#bookingRefDisplay").text(bookingRef);
            $("#confirmEmail").text(formData.email);
            goToStep(3);
            $("#payNowBtn").html('Pay <span id="payBtnAmount">₹0</span> &nbsp;<i class="fa fa-lock"></i>').prop("disabled", false);
        },
        error: function() {
            let bookingRef = "TRV-" + Math.floor(100000 + Math.random() * 900000);
            $("#bookingRefDisplay").text(bookingRef);
            $("#confirmEmail").text(formData.email);
            goToStep(3);
            $("#payNowBtn").html('Pay <span id="payBtnAmount">₹0</span> &nbsp;<i class="fa fa-lock"></i>').prop("disabled", false);
        }
    });
}

function goToStep(step) {
    $(".booking-step").removeClass("active");
    $(".step-dot").removeClass("active done");

    $("#step" + step).addClass("active");

    for(let i = 1; i < step; i++) {
        $("#dot" + i).addClass("done");
    }
    $("#dot" + step).addClass("active");

    const titles = {
        1: ["Book Your Package", "Fill in your travel details"],
        2: ["Secure Payment", "Choose your preferred payment method"],
        3: ["Booking Confirmed!", "We'll contact you soon"]
    };
    $("#modalTitle").text(titles[step][0]);
    $("#modalSubtitle").text(titles[step][1]);
}
</script>

</body>
</html>