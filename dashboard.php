<?php
// error_reporting(0);
session_start();
include 'include/conn.php';
include 'include/controller.php';

$open = $_REQUEST['open'];
$__email = $_SESSION['email'];

loginidentfy($__email);
?>
<!DOCTYPE html>
<html lang="en">
<?= include("include/head-link.php") ?>


<body class="sb-nav-fixed">
    <?= include("include/top-nav-bar.php") ?>

    <div id="layoutSidenav">
        <?= include("include/side-nav-bar.php") ?>
        <!-- end nav bar -->
        <div id="layoutSidenav_content">
            <main>
                <?php if ($open == "create_ticket") { ?>
                    <div class="container-fluid px-4">
                        <!-- <h1 class="mt-4">Dashboard</h1> -->
                        <!-- <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol> -->
                        <!-- cards -->
                        <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Primary Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Warning Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Success Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Danger Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end cards -->

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Create Ticket
                                    </div>
                                    <div class="card-body">
                                        <form id="create_ticket">
                                            <div class="form-group" require>
                                                <label for="exampleInputEmail1">Email or ID</label>
                                                <input type="text" name="index" class="form-control" id="exampleInputEmail1" placeholder="email or ID" require>
                                            </div>
                                            <button type="submit" class="btn btn-primary createTicketBTN">Submit</button>
                                            <a id="convertToImage" class="btn btn-secondary" href="#">SEND</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="" style="padding: 10px !important;width: fit-content !important;margin: 0 auto;">
                                <div class="card">
                                    <div class="card-header">
                                        <i class="fas fa-chart-bar me-1"></i>
                                        Your Ticket
                                    </div>
                                    <div class="">
                                        <?= file_get_contents("include/ticket-template.php"); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($open == "Scan_Ticket") { ?>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>
                                        Create Ticket
                                    </div>
                                    <div class="card-body">
                                        <center>
                                            <div id="reader"></div>
                                        </center>
                                        <div id="result"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($open == "Tickets") { ?>
                    <div class="container-fluid px-4">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <i class="fas fa-chart-area me-1"></i>Ticket Status
                                    </div>
                                    <div class="card-body">
                                        <table id="myTable" class="display">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>INDEX</th>
                                                    <th>Ticket STATUS</th>
                                                </tr>
                                            </thead>
                                            <tbody id="ticket_t_body">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </main>
        </div>
    </div>

    <?= include("include/bottom-link.php") ?>
</body>

</html>