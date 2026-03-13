<!DOCTYPE html>
<html>
<head>
    <title>Travelit - Packages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
</head>
<body>

<?php include("navbar.php"); ?>

<div class="bg-dark text-white text-center py-5">
    <h1>Our Premium Packages</h1>
    <p>Carefully crafted travel experiences</p>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-4">Available Packages</h2>
    <div class="row" id="packageList"></div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function(){

    // Read destination_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const destination_id = urlParams.get("destination_id");

    // Load packages
    $.ajax({
        url: "api/get_packages.php",
        method: "GET",
        data: destination_id ? { destination_id: destination_id } : {},
        dataType: "json",   // IMPORTANT

        success: function(packages){

            let html = "";

            if(packages.length === 0){
                html = "<p class='text-center'>No packages available.</p>";
            } else {

            packages.forEach(pkg => {

                let img = "";

                if(pkg.destination === "Delhi"){
                    img = "https://blog.lemontreehotels.com/wp-content/uploads/2025/02/Places-to-Visit-in-Delhi.jpg";
                }
                else if(pkg.destination === "Kashmir"){
                    img = "https://media.thekashmirmonitor.net/wp-content/uploads/2023/11/gulmarg-4-_wide-e4eb7356bf7195fbaf7b00ec03326f7f09c47862-scaled.jpg";
                }
                else if(pkg.destination === "Darjeeling"){
                    img = "https://static2.tripoto.com/media/filter/tst/img/2012133/Image/1662184373_tourism_darjeeling_india_1280x800.jpg.webp";
                }
                else{
                    img = "assets/images/hero.jpg";
                }

                html += `
                <div class="col-md-6 col-lg-4">

                    <div class="card shadow-lg mb-4 text-center">

                        <img src="${img}" class="package-img">

                        <div class="p-3">

                            <h4>${pkg.destination}</h4>

                            <h3 class="text-warning">₹${pkg.price}</h3>
                            <hr>

                            <p><strong>Duration:</strong> ${pkg.days}</p>
                            <p><strong>Transport:</strong> ${pkg.transport}</p>

                            <button 
                                class="btn btn-primary w-100 bookBtn"
                                data-id="${pkg.id}"
                                data-destination="${pkg.destination}"
                                data-days="${pkg.days}"
                                data-transport="${pkg.transport}"
                                data-price="${pkg.price}">
                                Book Package
                            </button>

                        </div>

                    </div>

                </div>`;
            });

            }

            $("#packageList").html(html);
        },

        error:function(){
            $("#packageList").html("<p class='text-danger text-center'>Server error loading packages</p>");
        }
    });

    // Open booking modal
    $(document).on("click", ".bookBtn", function(){

        const btn = $(this);

        $("#modalPackageId").val(btn.data("id"));
        $("#modalDestination").val(btn.data("destination"));
        $("#modalDays").val(btn.data("days"));
        $("#modalTransport").val(btn.data("transport"));
        $("#modalPrice").val(btn.data("price"));

        // Show info to user
        $("#selectedPackageInfo").html(
            `<b>${btn.data("destination")}</b> | ${btn.data("days")} | ${btn.data("transport")} | ₹${btn.data("price")}`
        );

        new bootstrap.Modal(document.getElementById("bookingModal")).show();

    });


    // Submit booking
    $("#popupBookingForm").submit(function(e){

        e.preventDefault();

        $.ajax({
            url: "api/send_booking_email.php",
            method: "POST",
            data: $(this).serialize(),

            success: function(res){

                $("#bookingResponse").html(
                    "<span class='text-success'>Booking request sent! Admin will contact you soon.</span>"
                );

                $("#popupBookingForm")[0].reset();

            },

            error:function(){

                $("#bookingResponse").html(
                    "<span class='text-danger'>Failed to send booking request.</span>"
                );

            }

        });

    });

});
</script>

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content text-dark">
      <div class="modal-header">
        <h5 class="modal-title">Book Package</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="selectedPackageInfo" class="mb-3 text-center fw-bold"></div>
        <form id="popupBookingForm">
          <input type="hidden" name="package_id" id="modalPackageId">
          <input type="hidden" name="destination" id="modalDestination">
          <input type="hidden" name="days" id="modalDays">
          <input type="hidden" name="transport" id="modalTransport">
          <input type="hidden" name="price" id="modalPrice">

          <div class="mb-2">
            <label>Your Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Travel Date</label>
            <input type="date" name="travel_date" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Number of People</label>
            <input type="number" name="num_people" class="form-control" min="1" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Send Booking Request</button>
        </form>
        <div id="bookingResponse" class="mt-2 text-center fw-bold"></div>
      </div>
    </div>
  </div>
</div>

</body>
</html>