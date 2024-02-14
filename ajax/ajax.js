$(document).ready(function() {
    // ================Fetch All ticket===============
    fetchAllTicket();

    function fetchAllTicket() {
        $.ajax({
            type: "POST",
            url: "ajax/ajax.php",
            data: { fetchAllTicket: "true" },
            dataType: "json",
            success: function(response) {
                $("#ticket_t_body").html(response['asd']);
                $('#myTable').DataTable();
            }
        });
    }


    // =====================  login  ========================
    $('#login').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('login', true);
        $.ajax({
            url: 'ajax/ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var response = JSON.parse(response);
                if (response['login'] == 'ok') {
                    swal("Login Success!", "Login Now", "success");
                    setInterval(function() {
                        window.location.assign("dashboard.php?open=create_ticket");
                    }, 1000);
                } else if (response['login'] == 'error_1') {
                    swal("Try to log in with signup first !", "", "warning");
                } else {
                    swal("Please Tryagain !", "", "warning");
                }

            }
        });
    });

    // =====================  create ticket  ========================

    $('#create_ticket').submit(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('create_ticket', true);
        $.ajax({
            url: 'ajax/ajax.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                var response = JSON.parse(response);
                if (response['create_ticket'] == '1') {
                    swal({
                            title: "Are you sure?",
                            text: "Get more tickets in your ID - " + response['ref_ticket_count'],
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                formData.append('ref_ticket', true);
                                $.ajax({
                                    url: 'ajax/ajax.php',
                                    type: 'POST',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    success: function(response) {
                                        var response = JSON.parse(response);
                                        if (response['ref_ticket'] == 'ok') {
                                            $(".demo").qrcode({
                                                text: response['qr']
                                            });
                                            swal("Ref Ticket Created!", "", "success");
                                            $("#myIndex").text(response['index']);

                                            // =====================  ⁡⁢⁣⁡⁢⁣⁢download canvas⁡⁡  ========================
                                            var element = $("#capture"); // global variable
                                            var getCanvas; // global variable
                                            html2canvas(element, { onrendered: function(canvas) { getCanvas = canvas; } });
                                            $("#convertToImage").on('click', function() {
                                                var imgageData = getCanvas.toDataURL("image/png");
                                                var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                                                // $("#convertToImage").attr("download", response['index'] + ".png").attr("href", newData);

                                                // =====================  send mail  ========================
                                                formData.append('sent__mail', true);
                                                formData.append('sender__mail', response['index']);
                                                formData.append('base64__data', newData);
                                                formData.append('qr__code', response['qr']);
                                                $.ajax({
                                                    url: 'ajax/ajax.php',
                                                    type: 'POST',
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    success: function(response) {
                                                        var response = JSON.parse(response);
                                                        // console.log(response['qr__code']);
                                                        if (response['sent__mail'] == 'ok') {}
                                                    }
                                                });
                                                // setInterval(function() { location.reload(); }, 700);
                                            });
                                            // =====================  ⁡⁢⁣⁢download canvas⁡  ========================
                                        }
                                    }
                                });
                            } else {
                                swal("Cancelled", "", "error");
                                setInterval(function() { location.reload(); }, 1000);
                            }
                        });
                } else if (response['create_ticket'] == '2') {
                    swal("New Ticket Created !", "", "success");
                    $("#myIndex").text(response['index']);
                    $(".demo").qrcode({
                        text: response['qr']
                    });
                    // =====================  ⁡⁢⁣⁢download canvas⁡  ========================
                    var element = $("#capture"); // global variable
                    var getCanvas; // global variable
                    html2canvas(element, { onrendered: function(canvas) { getCanvas = canvas; } });
                    $("#convertToImage").on('click', function() {
                        var imgageData = getCanvas.toDataURL("image/png");
                        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                        $("#convertToImage").attr("download", response['index'] + ".png").attr("href", newData);
                        setInterval(function() { location.reload(); }, 700);
                    });
                    // =====================  ⁡⁢⁣⁢download canvas⁡  ========================
                } else {
                    swal("Please Tryagain !", "", "error");
                    setInterval(function() { location.reload(); }, 1000);
                }
            }
        });
    });

    // =====================  Scan ticket  ========================
    const scanner = new Html5QrcodeScanner('reader', {
        qrbox: {
            width: 450,
            height: 450,
        },
        fps: 20,
    });
    scanner.render(success, error);

    function success(result) {
        $.post("ajax/ajax.php", { 'scan': true, 'qrdata': result },
            function(response, textStatus) {
                var response = JSON.parse(response);
                if (response['scan'] == '1') {
                    swal({
                            title: "Are you sure?",
                            text: "Will you enter?",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#DD6B55",
                            confirmButtonText: "Yes",
                            cancelButtonText: "No",
                            closeOnConfirm: false,
                            closeOnCancel: false
                        },
                        function(isConfirm) {
                            if (isConfirm) {
                                $.post("ajax/ajax.php", { 'scan': true, 'entered': true, 'qrdata': result },
                                    function(response, textStatus) {
                                        var response = JSON.parse(response);
                                        if (response['scan'] == '2') {
                                            swal("Enjoying Holly", "", "success");
                                        }
                                    }
                                );
                            } else {
                                swal("Cancelled", "", "error");
                            }
                        });
                } else if (response['scan'] == '3') {
                    swal("A previously used ticket !", "", "warning");
                } else {
                    swal("Unvalid Ticket !", "", "error");
                }
            }
        );
        // scanner.clear();
        // document.getElementById('reader').remove();
    }

    function error(err) {
        // console.error(err);
    }
});