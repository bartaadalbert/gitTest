<!-- Page Heading -->
<h1 class="h3 mb-1 text-gray-800">Hard Drive</h1>
<p class="mb-4">File manager web</p>

<!-- Content Row -->
<div class="row">


    <div class="col-lg-12">

        <!-- Custom Text Color Utilities -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-lg-9">
                        <h6 class="m-0 font-weight-bold text-primary">Source</h6>
                    </div>
                    <div class="col-lg-3">
                        <h6 class="m-0 font-weight-bold text-primary">Navigator</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-9">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb py-1 small mb-1" id="breadmenu">
                                <li class="breadcrumb-item">
                                    <a href="#" id="back">
                                        <i class="fas fa-arrow-circle-left"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="#" id="home">Home</a>
                                </li>
                            </ol>
                        </nav>
<!--                        Active Directory-->
                        <div id="activeDir" class="row">

                        </div>


                    </div>
                    <div id="navigatorBar" class="col-lg-3">

<!--                        one group container-->
                        <div class="container p-0 m-0">
                            <div class="col-lg-8 font-weight-bold text-black-50 mb-1 pl-0">Recently</div>

                            <ul class="list-group">

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Photo
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Documents
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Music
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-folder"></i>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                            <div class="col text-right">
                                <a class="more-btn small text-primary">more</a>
                            </div>

                    </div>
<!--                        end one group container-->

                        <!--                        one group container-->
                        <div class="container p-0 m-0">
                            <div class="col-lg-8 font-weight-bold text-black-50 mb-1 pl-0">Bookmarks</div>

                            <ul class="list-group">

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Dapibus ac facilisis in
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Dapibus ac facilisis in
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-star"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="list-group-item py-1 btn-outline-dark">
                                    <div class="row">
                                        <div class="filename col-sm-9 small text-nowrap p-0">
                                            Dapibus ac facilisis in
                                        </div>
                                        <div class="filename col-sm-3 small text-right p-0">
                                            <i class="fas fa-file-"></i>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                            <div class="col text-right">
                                <a class="more-btn small text-primary">more</a>
                            </div>

                        </div>
                        <!--                        end one group container-->


                        <!--                        one group container-->
                        <div class="container p-0 m-0">
                            <div class="col-lg-8 font-weight-bold text-black-50 mb-1 pl-0">Mount</div>

                            <div class="card">
                                <div class="card-header py-1">
                                    <div class="row">
                                        <div class="col-lg-8 small">
                                            Hard Drive
                                        </div>
                                        <div class="col-lg-4 text-secondary small text-right text-nowrap p-0">
                                            320 Gb
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-1">
                                    <div class="row small">
                                        <div class="border border-secondary used-space rounded-left py-2 bg-warning" id="usedSpace" style="width: 40%">

                                        </div>
                                        <div class="border border-secondary free-space rounded-right py-2 free-space bg-white shadow" id="freeSpace" style="width: 60%">

                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--                        end one group container-->

                    </div>
                </div>
            </div>
        </div>

    </div>

</div>