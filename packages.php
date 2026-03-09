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

<script>
$(document).ready(function(){

    // Get destination_id from URL
    const urlParams = new URLSearchParams(window.location.search);
    const destination_id = urlParams.get('destination_id');

    $.ajax({
        url: "api/get_packages.php",
        method: "GET",
        data: destination_id ? { destination_id: destination_id } : {},
        success: function(data){
            let packages = JSON.parse(data);
            let html = "";

            if(packages.length === 0){
                html = "<p class='text-center'>No packages available.</p>";
            } else {
                packages.forEach(function(pkg){
                    html += `
                        <div class="col-md-6 col-lg-4">
                            <div class="card shadow-lg mb-4 p-3">
                                <div class="card-body text-center">
                                    <h3 class="text-warning">₹${pkg.price}</h3>
                                    <hr>
                                    <p><strong>Duration:</strong> ${pkg.days}</p>
                                    <p><strong>Transport:</strong> ${pkg.transport}</p>

                                    <button 
                                        class="btn btn-primary w-100 bookBtn"
                                        data-id="${pkg.id}">
                                        Book Package
                                    </button>

                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            $("#packageList").html(html);
        }
    });

        // Open popup when Book Package clicked
    $(document).on("click", ".bookBtn", function(){

        let packageId = $(this).data("id");

        $("#modalPackageId").val(packageId);

        let modal = new bootstrap.Modal(document.getElementById("bookingModal"));
        modal.show();
    });

    $("#popupBookingForm").submit(function(e){

    e.preventDefault();

        $.ajax({
            url: "api/book_package.php",
            method: "POST",
            data: $(this).serialize(),
            success: function(res){
                $("#bookingResponse").html(
                    "<span class='text-success'>Booking request sent!</span>"
                );
            }
        });

    });

    // Booking form submission
    $(document).on("submit", ".bookingForm", function(e){
        e.preventDefault();

        let form = $(this);
        let messageBox = form.next(".bookingMessage");

        $.ajax({
            url: "api/book_package.php",
            method: "POST",
            data: form.serialize(),
            dataType: "json",
            success: function(response){

                if(response.status === "success"){
                    messageBox.html("<span class='text-success'>" + response.message + "</span>");
                } else {
                    messageBox.html("<span class='text-danger'>" + response.message + "</span>");

                    if(response.message === "Please login first."){
                        setTimeout(function(){
                            window.location.href = "login.php";
                        }, 1500);
                    }
                }
            },
            error: function(){
                messageBox.html("<span class='text-danger'>Booking failed.</span>");
            }
        });
    });

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

<footer class="bg-black text-center text-light py-4 mt-5">
    <div class="container">
        <h5 class="fw-bold">Travelit</h5>
        <p>Premium travel experiences across India.</p>
        <div>
            <a href="#" class="text-light me-3">About</a>
            <a href="#" class="text-light me-3">Contact</a>
            <a href="#" class="text-light">Privacy Policy</a>
        </div>
        <hr class="bg-secondary">
        <p class="mb-0">© 2026 Travelit. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
