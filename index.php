<?php 
    require_once('header.php');
?>

                <main role="main" class="col-md-9 ml-sm-auto col-lg-10 pt-3 px-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                        <h2 class="h3">Tableau de bord</h2>
                        <div class="btn-toolbar mb-2 mb-md-0">
                            <div class="btn-group mr-2">
                            </div>
                        </div>
                    </div>
                    <!-- Vente Analyse -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <h3>Vente</h3>
                            <div class="col-sm col-xl">
                                <div class="bg-success rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Total Général</h6>
                                        <p class="mb-2"><span id="t_total"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid pt-4 px-4 mb-3">
                        <div class="row g-4">
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-primary rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Aujourd'hui</h6>
                                        <p class="mb-2"><span id="t_today"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-warning rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Cette semaine</h6>
                                        <p class="mb-2"><span id="t_week"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-danger rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Ce mois</h6>
                                        <p class="mb-2"><span id="t_month"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3">
                                        <h6 class="mb-0">Cette année</h6>
                                        <p class="mb-2"><span id="t_year"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <!-- Vente Analyse -->
                    <div class="container-fluid pt-4 px-4">
                        <div class="row g-4">
                            <h3>Prestation</h3>
                            <div class="col-sm col-xl">
                                <div class="bg-success rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Total Général</h6>
                                        <p class="mb-2"><span id="p_total"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid pt-4 px-4 mb-3">
                        <div class="row g-4">
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-primary rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Aujourd'hui</h6>
                                        <p class="mb-2"><span id="p_today"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-warning rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Cette semaine</h6>
                                        <p class="mb-2"><span id="p_week"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-danger rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3 text-white">
                                        <h6 class="mb-0">Ce mois</h6>
                                        <p class="mb-2"><span id="p_month"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xl-3">
                                <div class="bg-light rounded shadow-lg d-flex align-items-center justify-content-between p-5">
                                    <div class="ms-3">
                                        <h6 class="mb-0">Cette année</h6>
                                        <p class="mb-2"><span id="p_year"></span> F CFA</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        
        <!-- JavaScript -->
        <script src="assets/js/jquery-3.6.0.min.js"></script>
        <script src="assets/js/script.js"></script>
        <script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/font-awesome/js/all.min.js"></script>
    </body>
</html>