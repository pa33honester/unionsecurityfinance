<?php include("header.php"); ?>
<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="nk-block-head">
                <div class="nk-block-head-sub">
                </div>
                <div class="nk-block-between-md g-4 card-bordered">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title fw-normal"><?php echo greetings(); echo "$fullname"; ?></h4>
                        <div class="nk-block-des">
                            <p>At a glance summary of your account!</p>
                        </div>
                    </div><!-- .nk-block-head-content -->
                    <div class="nk-block-head-content">
                        <ul class="nk-block-tools gx-3">
                            <li><a href="check-deposit" class="btn btn-primary"><span>Deposit</span> <em class="icon ni ni-arrow-long-right"></em></a></li>
                            <li><a href="transfer" class="btn btn-secondary btn-light text-light"><span>Transfer Fund</span> <em class="icon ni ni-arrow-long-right d-none d-sm-inline-block"></em></a></li>
                        </ul>
                    </div><!-- .nk-block-head-content -->
                </div><!-- .nk-block-between -->
            </div><!-- .nk-block-head -->
            <div class="nk-block">
                <div class="row gy-gs">
                    <div class="col-lg-6 col-xl-6">
                        <div class="nk-block">
                            <div class="nk-block-head-xs">
                                <div class="nk-block-head-content">
                                    <h5 class="nk-block-title title">Overview</h5>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="nk-block">
                                <div class="card card-bordered text-light is-dark h-100">
                                    <div class="card-inner">
                                        <div class="nk-wg7">
                                            <div class="nk-wg7-stats-group">
                                                <div class="nk-wg7-stats w-50" style="background-image: url(../auth/passport/<?php $passport ?>); border-color: white; border-width: 5px; border-radius: 50%;">
                                                    <?php if ($passport != "") {
                                                    ?>
                                                        <img class="img img-rounded" src="../auth/passport/<?php echo "$passport"; ?>" width="85" style="border-color: white; border-width: 5px; border-radius:50px;" height="85">
                                                    <?php } else { ?>
                                                        <div class="user-avatar bg-light text-primary" style="width: 70px; height: 70px;">
                                                            <span class="number-lg amount"><?php echo strtoupper(substr($fullname, 0, 2)) ?></span>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                                <div class="nk-wg7-stats w-50">
                                                    <div class="nk-wg7-title">Available balance</div>
                                                    <div class="number-lg amount"><?php echo "$money " . number_format($accountbalance) . ""; ?></div>
                                                    <?php echo $fullname ?>
                                                </div>
                                            </div>
                                            <div class="nk-wg7-stats-group">
                                                <div class="nk-wg7-stats w-50">
                                                    <div class="nk-wg7-title">Linked Cards</div>
                                                    <div class="number-lg"><?php
                                                                            if ($accountbalance >= 20000) {

                                                                                echo "3";
                                                                            } elseif ($accountbalance >= 1000) {
                                                                                echo  "1";
                                                                            } else {
                                                                                echo "0";;
                                                                            }

                                                                            ?></div>
                                                </div>
                                                <div class="nk-wg7-stats w-50">
                                                    <div class="nk-wg7-title">Your IP address</div>
                                                    <div class="number"><?php getFlag(); ?> <? echo $_SERVER['REMOTE_ADDR']; ?></div>
                                                </div>
                                            </div>
                                        </div><!-- .nk-wg7 -->
                                    </div><!-- .card-inner -->
                                </div><!-- .card -->
                            </div><!-- .nk-block -->
                        </div><!-- .nk-block -->
                    </div><!-- .col -->
                    <div class="col-lg-6 col-xl-6">
                        <div class="nk-block">
                            <div class="nk-block-head-xs">
                                <div class="nk-block-between-md g-2">
                                    <div class="nk-block-head-content">
                                        <h5 class="nk-block-title title"><?php echo "$accounttype"; ?></h5>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="transfer" class="link link-primary">Transfer Fund</a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="row g-2">
                                <div class="col-sm-12">
                                    <div class="card bg-light">
                                        <div class="nk-wgw sm">
                                            <a class="nk-wgw-inner" href="#">
                                                <div class="nk-wgw-name">
                                                    <div class="nk-wgw-icon">
                                                        <em class="icon ni ni-sign-cc-alt"></em>
                                                    </div>
                                                    <h5 class="nk-wgw-title title">*****<?php echo substr($_SESSION['loggedUser'], 5, 9) ?></h5>
                                                </div>
                                                <div class="nk-wgw-balance">
                                                    <div class="amount"><?php echo number_format(currencyConverter($accountbalance)); ?><span class="currency currency-nio"><?php echo $usercurrency ?></span></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div><!-- .nk-block -->
                        <div class="nk-block nk-block-md">
                            <div class="nk-block-head-xs">
                                <div class="nk-block-between-md g-2">
                                    <div class="nk-block-head-content">
                                        <h6 class="nk-block-title title">Loans and lines of credit</h6>
                                    </div>
                                    <div class="nk-block-head-content">
                                        <a href="pay-bills" class="link link-primary">Pay bills</a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head -->
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="card bg-light">
                                        <div class="nk-wgw sm">
                                            <a class="nk-wgw-inner" href="#">
                                                <div class="nk-wgw-name">
                                                    <div class="nk-wgw-icon">
                                                        <em class="icon ni ni-check-circle"></em>
                                                    </div>
                                                    <h5 class="nk-wgw-title title">Business Support Loan</h5>
                                                </div>
                                                <div class="nk-wgw-balance">
                                                    <div class="amount"><?php
                                                                        if ($accountbalance >= 20000) {

                                                                            echo "+4,000";
                                                                        } elseif ($accountbalance >= 1000) {
                                                                            echo  "+300";
                                                                        } else {
                                                                            echo "0";
                                                                        }
                                                                        ?><span class="currency currency-nio"><?php echo $money; ?></span></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .col -->

                                <div class="col-sm-6">
                                    <div class="card bg-light">
                                        <div class="nk-wgw sm">
                                            <a class="nk-wgw-inner" href="#">
                                                <div class="nk-wgw-name">
                                                    <div class="nk-wgw-icon">
                                                        <em class="icon ni ni-sign-cc-alt2"></em>
                                                    </div>
                                                    <h5 class="nk-wgw-title title"> FICO Credit Score</h5>
                                                </div>
                                                <div class="nk-wgw-balance">
                                                    <div class="amount text-dark"><?php
                                                                                    if ($accountbalance >= 20000) {
                                                                                        $color = "success";
                                                                                        echo 750;
                                                                                    } elseif ($accountbalance >= 1000) {
                                                                                        echo 460;
                                                                                        $color = "warning";
                                                                                    } else {
                                                                                        echo 300;
                                                                                        $color = "danger";
                                                                                    }


                                                                                    ?> &nbsp;<span class="badge-pill bg-<?php echo $color ?>"> </span></div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- .col -->
                            </div><!-- .row -->
                        </div> <!-- .nk-block -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .nk-block -->
            <div class="nk-block nk-block-lg">
                <div class="row gy-gs">
                    <div class="col-md-6">
                        <div class="card-head">
                            <div class="card-title  mb-0">
                                <h5 class="title">Recent Transaction Activities</h5>
                            </div>
                            <div class="card-tools">
                                <ul class="card-tools-nav">
                                    <li class="active"><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div><!-- .card-head -->
                        <div class="tranx-list card card-bordered">
                            <?php
                            include("../scripts/connect.php");
                            $query = $conn->query("SELECT * FROM transactions WHERE userid = '$userid' ORDER BY id DESC LIMIT 5");
                            while ($rows = mysqli_fetch_assoc($query)) {
                                $amount = $rows['amount'];
                                $refNumber = $rows['refNumber'];
                                $accountholder = $rows['accountholder'];
                                $bankname = $rows['bankname'];
                                $dated = $rows['dated'];
                                $avalbal = $rows['accountbalance'];
                                $description = $rows['description'];
                                $type = $rows['type'];
                                $id = $rows['id'];
                                if ($type == "Debit") {
                                    $ico = "wallet-out";
                                    $color = "text-danger";
                                    $sign = "-";
                                } else {
                                    $ico = "wallet-in";
                                    $color = "text-success";
                                    $sign = "+";
                                }

                                if ($rows['status'] == 0) {
                                    $stat = "<strong class='text-danger'>Pending</strong>";
                                } else {
                                    $stat = "<strong class='text-success'>Completed</strong>";
                                }

                                if ($accountholder != "") {
                                    $holder = '<li class="buysell-overview-item">
                                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Beneficiary Account holder:</span></span>
                                                <span class="pm-title">' . $accountholder . '</span>
                                               </li>';
                                } else {
                                    $holder = "";
                                }

                                if ($bankname != "") {
                                    $bank = '<li class="buysell-overview-item">
                                                <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Bank name:</span></span>
                                                <span class="pm-title">' . $bankname . '</span>
                                               </li>';
                                } else {
                                    $bank = "";
                                }

                            ?>
                                <div class="tranx-item">
                                    <div class="tranx-col">
                                        <div class="tranx-info">
                                            <div class="tranx-data">
                                                <div class="tranx-label"><?php echo "$refNumber"; ?><em class="tranx-icon sm icon ni ni-<?php echo "$ico"; ?>"></em></div>
                                                <div class="tranx-date"><?php echo $dated ?></div>
                                                <div class="text-primary"><?php echo $description ?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tranx-col">
                                        <div class="tranx-amount">
                                            <div class="tranx-date">Amount</div>
                                            <div class="<?php echo $color ?> fs-16px"><?php echo "$sign $amount" ?>
                                                <span class="currency currency-usd"><span class="currency currency-btc"><?php echo $money ?></span>
                                            </div>
                                            <div class="number-sm"><?php echo $stat ?></div>
                                        </div>
                                    </div>
                                    <div class="tranx-col">
                                        <div class="tranx-amount">
                                            <div class="number"><?php echo $type ?><span class="currency currency-btc"></span></div>
                                            <span class="badge badge-dim badge-pill badge-outline-primary" data-toggle="modal" data-target="#modalDefault<?php echo $id ?>">View Details</span>
                                        </div>
                                    </div>
                                </div><!-- .tranx-item -->
                                <div class="modal fade" tabindex="-1" id="modalDefault<?php echo $id ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-light">
                                                <h5 class="modal-title text-light">Transaction Details</h5>
                                                <a href="#" class="close text-light" data-dismiss="modal" aria-label="Close">
                                                    <em class="icon ni ni-cross"></em>
                                                </a>
                                            </div>
                                            <div class="modal-body">
                                                <ul class="buysell-overview-list">
                                                    <li class="buysell-overview-item">
                                                        <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Amount Debited</span></span>
                                                        <span class="pm-title"><?php echo "$money $amount"; ?></span>
                                                    </li>
                                                    <li class="buysell-overview-item">
                                                        <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Transaction refrence:</span></span>
                                                        <span class="pm-title"><?php echo "$refNumber"; ?></span>
                                                    </li>
                                                    <?php echo "$holder"; ?>
                                                    <?php echo "$bank"; ?>
                                                    <li class="buysell-overview-item">
                                                        <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Date:</span></span>
                                                        <span class="pm-title"><?php echo "$dated"; ?></span>
                                                    </li>

                                                    <li class="buysell-overview-item">
                                                        <span class="pm-currency"><em class="icon ni ni-check-circle-fill"></em> <span>Available Balance:</span></span>
                                                        <span class="pm-title"><?php echo "$money " . number_format($avalbal) . ""; ?></span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="modal-footer bg-light">
                                                <span class="sub-text text-primary">Proccessed by <?php echo $sitename ?> Digital banking services.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <input type="hidden" id="debit1" value="<?php echo round(getIncomeValue($userid, 'debit'), 2); ?>">
                            <input type="hidden" id="credit1" value="<?php echo round(getIncomeValue($userid, 'credit'), 2); ?>">
                        </div><!-- .tranx-list -->
                    </div><!-- .col -->
                    <div class="col-md-6">
                        <div class="card-head">
                            <div class="card-title mb-0">
                                <h5 class="title">Balance Flow</h5>
                            </div>
                            <div class="card-tools">
                                <ul class="card-tools-nav">
                                    <li class="active"><a href="#">All time</a></li>
                                </ul>
                            </div>
                        </div><!-- .card-title -->
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <div class="nk-wg4">
                                    <div class="nk-wg4-group justify-center gy-3 gx-4">
                                        <div class="nk-wg4-item">
                                            <div class="sub-text">
                                                <div class="dot dot-lg sq" data-bg="#1ee0ac"></div> <span>Credit</span>
                                            </div>
                                        </div>
                                        <div class="nk-wg4-item">
                                            <div class="sub-text">
                                                <div class="dot dot-lg sq" data-bg="#f4aaa4"></div> <span>Debit</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="nk-ck3">
                                    <canvas class="pie-chart" id="pieChartData"></canvas>
                                </div>
                            </div><!-- .card-inner -->
                        </div><!-- .card -->
                        <p></p>
                        <div class="tradingview-widget-container" style="width: 100%;">
                            <div class="tradingview-widget-container__widget"></div>
                            <div class="tradingview-widget-copyright"><a href="https://www.tradingview.com/symbols/EURUSD/?exchange=FX" rel="noopener" target="_blank"><span class="blue-text">EURUSD Rates</span></a></div>
                            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async></script>
                        </div>
                        <!-- TradingView Widget END -->
                    </div><!-- .col -->
                </div><!-- .row -->
            </div><!-- .nk-block -->
            <div class="nk-block">
                <div class="card card-bordered">
                    <div class="card-inner card-inner-lg">
                        <div class="align-center flex-wrap flex-md-nowrap g-4">
                            <div class="nk-block-image w-120px flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 118">
                                    <path d="M8.916,94.745C-.318,79.153-2.164,58.569,2.382,40.578,7.155,21.69,19.045,9.451,35.162,4.32,46.609.676,58.716.331,70.456,1.845,84.683,3.68,99.57,8.694,108.892,21.408c10.03,13.679,12.071,34.71,10.747,52.054-1.173,15.359-7.441,27.489-19.231,34.494-10.689,6.351-22.92,8.733-34.715,10.331-16.181,2.192-34.195-.336-47.6-12.281A47.243,47.243,0,0,1,8.916,94.745Z" transform="translate(0 -1)" fill="#f6faff" />
                                    <rect x="18" y="32" width="84" height="50" rx="4" ry="4" fill="#fff" />
                                    <rect x="26" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                    <rect x="50" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                    <rect x="74" y="44" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                    <rect x="38" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                    <rect x="62" y="60" width="20" height="12" rx="1" ry="1" fill="#e5effe" />
                                    <path d="M98,32H22a5.006,5.006,0,0,0-5,5V79a5.006,5.006,0,0,0,5,5H52v8H45a2,2,0,0,0-2,2v4a2,2,0,0,0,2,2H73a2,2,0,0,0,2-2V94a2,2,0,0,0-2-2H66V84H98a5.006,5.006,0,0,0,5-5V37A5.006,5.006,0,0,0,98,32ZM73,94v4H45V94Zm-9-2H54V84H64Zm37-13a3,3,0,0,1-3,3H22a3,3,0,0,1-3-3V37a3,3,0,0,1,3-3H98a3,3,0,0,1,3,3Z" transform="translate(0 -1)" fill="#798bff" />
                                    <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="#6576ff" />
                                    <path d="M61.444,41H40.111L33,48.143V19.7A3.632,3.632,0,0,1,36.556,16H61.444A3.632,3.632,0,0,1,65,19.7V37.3A3.632,3.632,0,0,1,61.444,41Z" transform="translate(0 -1)" fill="none" stroke="#6576ff" stroke-miterlimit="10" stroke-width="2" />
                                    <line x1="40" y1="22" x2="57" y2="22" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <line x1="40" y1="27" x2="57" y2="27" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <line x1="40" y1="32" x2="50" y2="32" fill="none" stroke="#fffffe" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" />
                                    <line x1="30.5" y1="87.5" x2="30.5" y2="91.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="28.5" y1="89.5" x2="32.5" y2="89.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="79.5" y1="22.5" x2="79.5" y2="26.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                    <line x1="77.5" y1="24.5" x2="81.5" y2="24.5" fill="none" stroke="#9cabff" stroke-linecap="round" stroke-linejoin="round" />
                                    <circle cx="90.5" cy="97.5" r="3" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                                    <circle cx="24" cy="23" r="2.5" fill="none" stroke="#9cabff" stroke-miterlimit="10" />
                                </svg>
                            </div>
                            <div class="nk-block-content">
                                <div class="nk-block-content-head px-lg-4">
                                    <h5>We’re here to help you!</h5>
                                    <p class="text-soft">Ask a question or file a support ticket, manage request, report an issues. Our team support team will get back to you by email.</p>
                                </div>
                            </div>
                            <div class="nk-block-content flex-shrink-0">
                                <a href="contact" class="btn btn-lg btn-outline-primary">Get Support Now</a>
                            </div>
                        </div>
                    </div><!-- .card-inner -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
<!-- content @e -->
<!-- footer @s -->

<?php include("footer.php"); ?>