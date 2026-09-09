/**
 * profileinfo.js - consolidated logic for the profile/settings page.
 * Replaces 5 inline <script> blocks; removes dead code and debug noise.
 * Requires: window.C4PageConfig = { base_url: "...", bankCount: N };
 * Run after jQuery, Bootstrap, Morris.js, SweetAlert2 (loaded in <head>).
 */
(function () {
    "use strict";

    var CFG = window.C4PageConfig || {};
    var base_url = CFG.base_url || "/C4/";
    var IMG_RE = /\.(jpg|jpeg|png|gif)$/i;

    $(document).ready(function () {

        /* ===== Image uploads (profile picture + company logo) ===== */
        $(".editLink").on("click", function (e) { e.preventDefault(); $("#fileInput").trigger("click"); });
        $(".editLink2").on("click", function (e) { e.preventDefault(); $("#fileInput2").trigger("click"); });

        function uploadImage(inputId, fieldName, previewSel) {
            var $input = $(inputId);
            var file = $input[0].files[0];
            if (!file) { return; }
            if (!IMG_RE.exec(file.name)) {
                alert("Please upload only .jpg/.jpeg/.png/.gif file.");
                $input.val("");
                return false;
            }
            var fd = new FormData();
            fd.append(fieldName, file);
            fd.append("product_id", 1);
            $.ajax({
                url: base_url + (inputId === "#fileInput" ? "/profile/uploadProductImage" : "/profile/uploadProductImage2"),
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (response) {
                    if (response.success) {
                        var imgUrl = base_url + "/public/dist/img/uploads/" + response.filename;
                        $(previewSel).attr("src", imgUrl);
                    } else {
                        alert("Error uploading image: " + response.message);
                    }
                },
                error: function () { alert("Error uploading image"); }
            });
        }

        $("#fileInput").on("change", function () {
            uploadImage("#fileInput", "picture",
                "#imagePreview, #imagePreview2, #imagePreview3, #imagePreview4, #imagePreview5");
        });
        $("#fileInput2").on("change", function () {
            uploadImage("#fileInput2", "picturelogo", "#imagePreviews");
        });

        /* ===== Bank details (add more bank rows) ===== */
        var maxBanks = 2;
        var currentBanks = parseInt(CFG.bankCount, 10) || 0;
        $("#addBank").on("click", function () {
            if (currentBanks >= maxBanks) { return; }
            var bankRow =
                '<div class="bank-details">' +
                    '<div class="form-group"><label class="col-sm-2 control-label">Bank Name</label>' +
                        '<div class="col-sm-8"><input type="text" class="form-control" name="bname[]" placeholder="Bank Name"></div>' +
                    '</div>' +
                    '<div class="form-group"><label class="col-sm-2 control-label">A/c Number</label>' +
                        '<div class="col-sm-8"><input type="text" class="form-control" name="ac[]" placeholder="Account number"></div>' +
                    '</div>' +
                    '<div class="form-group"><label class="col-sm-2 control-label">IFSC Code</label>' +
                        '<div class="col-sm-8"><input type="text" class="form-control" name="ifsc[]" placeholder="IFSC Code" style="text-transform: uppercase;"></div>' +
                    '</div>' +
                    '<div class="form-group"><label class="col-sm-2 control-label">Branch</label>' +
                        '<div class="col-sm-8"><input type="text" class="form-control" name="branch[]" placeholder="Branch Name"></div>' +
                    '</div>' +
                '</div>';
            $("#bank-details-container").append(bankRow);
            currentBanks++;
            if (currentBanks >= maxBanks) { $("#addBank").hide(); }
        });
/* ===== Database backup / restore ===== */
        $("#one-click-backup").click(function () {
            $.ajax({
                url: base_url + "/profile/dbbackup",
                type: "POST",
                dataType: "json",
                beforeSend: function () { $("#one-click-backup").text("Backing Up...").prop("disabled", true); },
                success: function (response) {
                    if (response.status === "success") {
                        $("#backup-message").html("&#9989; Backup Successful! Check C4/writeable/backups/");
                    } else {
                        $("#backup-message").html("&#10060; Error: " + response.message);
                    }
                    $("#one-click-backup").text("One Click Backup").prop("disabled", false);
                },
                error: function () {
                    alert("An error occurred. Check the logs.");
                    $("#one-click-backup").text("One Click Backup").prop("disabled", false);
                }
            });
        });

        $("#restore-backup").click(function () {
            var fileInput = $("#backup-file-input")[0].files;
            if (!fileInput || fileInput.length === 0) { alert("Please select a backup file first."); return; }
            var formData = new FormData();
            formData.append("backup_file", fileInput[0]);
            $.ajax({
                url: base_url + "/profile/restoreDB",
                type: "POST",
                data: formData,
                dataType: "json",
                processData: false,
                contentType: false,
                beforeSend: function () { $("#restore-backup").text("Restoring...").prop("disabled", true); },
                success: function (response) {
                    var ok = (response.type === "success");
                    $("#backup-message").html((ok ? "&#9989; " : "&#10060; ") + response.message);
                    $("#restore-backup").text("Restore Backup").prop("disabled", false);
                },
                error: function () {
                    alert("An error occurred. Check the logs.");
                    $("#restore-backup").text("Restore Backup").prop("disabled", false);
                }
            });
        });

        /* ===== Form submissions (AJAX) + SweetAlert ===== */
        $("#codetails").on("submit", function (e) { // Company details
            e.preventDefault();
            var fd = new FormData();
            fd.append("cname", $("#cname").val().trim());
            fd.append("cadd", $("#cadd").val());
            fd.append("cmob", $("#cmob").val());
            fd.append("cemail", $("#cemail").val());
            fd.append("cgst", $("#cgst").val().trim());
            fd.append("cpan", $("#cpan").val().trim());
            $.ajax({
                url: base_url + "/profile/updateData",
                type: "POST",
                data: fd, contentType: false, processData: false, dataType: "json",
                success: function (response) {
                    Swal.fire({ title: "Success!", text: response.message, icon: "success" });
                },
                error: function (xhr) { console.error("AJAX Error:", xhr.responseText); }
            });
        });

        $("#form1").on("submit", function (e) { // Personal profile details
            e.preventDefault();
            var fd = new FormData();
            fd.append("name", $("#inputname").val().trim());
            fd.append("email", $("#inputemail").val());
            fd.append("profession", $("#profession").val());
            fd.append("qualification", $("#qualification").val());
            fd.append("location", $("#location").val());
            $.ajax({
                url: base_url + "/profile/updateData2",
                type: "POST",
                data: fd, contentType: false, processData: false, dataType: "json",
                success: function (response) {
                    Swal.fire({ title: "Success!", text: response.message, icon: "success" });
                },
                error: function (xhr) { console.error("AJAX Error:", xhr.responseText); }
            });
        });
$("#pass").on("submit", function (e) { // Username / password
            e.preventDefault();
            var username = $("#username").val();
            var password = $("#password").val();
            var cpassword = $("#cpassword").val();
            if (!password || password !== cpassword) {
                Swal.fire("Password mismatch", "Enter the same non-empty password in both fields.", "error");
                return;
            }
            var fd = new FormData();
            fd.append("username", username);
            fd.append("password", password);
            $.ajax({
                url: base_url + "/profile/updateData3",
                type: "POST",
                data: fd, contentType: false, processData: false, dataType: "json",
                success: function (response) {
                    Swal.fire({ title: "Success!", text: response.message, icon: "success" });
                },
                error: function (xhr) { console.error("AJAX Error:", xhr.responseText); }
            });
        });

        $("#bankinfo").on("submit", function (e) { // Bank details
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                url: base_url + "/profile/updateBankDetails",
                type: "POST",
                data: fd, contentType: false, processData: false, dataType: "json",
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ title: "Success!", text: response.message, icon: "success" });
                    } else {
                        Swal.fire({ title: "Error!", text: response.message, icon: "error" });
                    }
                },
                error: function (xhr) {
                    console.error("AJAX Error:", xhr.responseText);
                    Swal.fire("Oops...", "Something went wrong with the AJAX request!", "error");
                }
            });
        });

        /* ===== Static Morris.js line chart ===== */
        if (typeof Morris !== "undefined") {
            Morris.Line({
                element: "line_chart",
                resize: true,
                data: [
                    { y: "Apr", Sales: 620, Purchases: 350 },
                    { y: "May", Sales: 780, Purchases: 420 },
                    { y: "Jun", Sales: 540, Purchases: 380 },
                    { y: "Jul", Sales: 910, Purchases: 500 },
                    { y: "Aug", Sales: 1240, Purchases: 670 },
                    { y: "Sep", Sales: 980, Purchases: 540 },
                    { y: "Oct", Sales: 1580, Purchases: 820 }
                ],
                xkey: "y",
                ykeys: ["Sales", "Purchases"],
                labels: ["Sales", "Purchases"],
                lineColors: ["#3c8dbc", "#00a65a"],
                lineWidth: 2,
                pointSize: 4,
                hideHover: "auto",
                gridTextColor: "#555",
                parseTime: false
            });
        }
    });
})();