<?php require_once('header.php'); ?>
<!-- content @s -->
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-body">
            <div class="kyc-app wide-sm m-auto">
                <div class="nk-block-head nk-block-head-lg wide-xs mx-auto">
                    <div class="nk-block-head-content text-center">
                        <h2 class="nk-block-title fw-normal">Visual Card Application</h2>
                        <div class="nk-block-des">
                            <p>The virtual card is issued instantly when requested on Internet Banking. To request, Fill the form below;</p>
                        </div>
                    </div>
                </div><!-- nk-block-head -->
                <div class="nk-block">
                    <div class="card card-bordered">
                        <div class="nk-kycfm">
                            <div class="nk-kycfm-head">
                                <div class="nk-kycfm-count">01</div>
                                <div class="nk-kycfm-title">
                                    <h5 class="title">Personal Details</h5>
                                </div>
                            </div><!-- .nk-kycfm-head -->
                            <div class="nk-kycfm-content">
                                <div class="nk-kycfm-note">
                                    <em class="icon ni ni-info-fill" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></em>
                                    <p>Please type carefully and fill out the form with your personal details. Your can’t edit these details once you submitted the form.</p>
                                </div>
                                <form action="../scripts/auth?action=ApplyForVisualCard" id="cardForm" method="post">
                                    <div class="row g-4">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Card Holder Name<span class="text-danger">*</span></label>
                                                </div>
                                                <div class="form-control-group">
                                                    <input type="text" id="fullname" name="fullname" required value="<?php echo $fullname ?>" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="form-control-group">
                                                    <input type="tel" name="phone" value="<?php echo $phone ?>" class="form-control form-control-lg" required>
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="form-control-group">
                                                    <input type="email" name="email" required value="<?php echo $email ?>" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Address <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="form-control-group">
                                                    <input type="text" name="address" value="<?php echo "$address, $zipcode $city $state $country"; ?>" class="form-control form-control-lg">
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Security Question <span class="text-danger">*</span>
                                                    </label>
                                                </div>
                                                <div class="form-control-group">
                                                    <select type="text" name="question" class="form-control form-control-lg" required>
                                                        <option value="">Please Select Question*</option>
                                                        <option value="What is your pet name?">What is your pet name?</option>
                                                        <option value="What is your nick name?">What is your nick name?</option>
                                                        <option value="What is the name of your first car?">What is the name of your first car?</option>
                                                        <option value="when did you finish high school?">when did you finish high school?</option>
                                                        <option value="your favorite music?">your favorite music?</option>
                                                        <option value="your favorite movie?">your favorite movie</option>
                                                        <option value="your favorite roll model?">your favorite role model</option>
                                                        <option value="favorite state?">favorite state?</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label">Answer <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="form-control-group">
                                                    <input type="text" name="answer" required class="form-control form-control-lg">
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                    </div><!-- .row -->
                            </div><!-- .nk-kycfm-content -->
                            <div class="nk-kycfm-head">
                                <div class="nk-kycfm-count">02</div>
                                <div class="nk-kycfm-title">
                                    <h5 class="title">Card Preference</h5>
                                </div>
                            </div><!-- .nk-kycfm-head -->
                            <div class="nk-kycfm-content">
                                <div class="nk-kycfm-note">
                                    <em class="icon ni ni-info-fill" data-toggle="tooltip" data-placement="right" title="Tooltip on right"></em>
                                    <p>Kindly select your preferred visual card type.</p>
                                </div>
                                <ul class="nk-kycfm-control-list g-3">
                                    <li class="nk-kycfm-control-item">
                                        <input class="nk-kycfm-control" type="radio" name="card_type" id="visa" data-title="visa" checked value="visa">
                                        <label class="nk-kycfm-label" for="visa">
                                            <span class="nk-kycfm-label-icon">
                                                <div class="label-icon">
                                                    <em class="icon ni ni-visa h3 text-primary"></em>
                                                </div>
                                            </span>
                                            <span class="nk-kycfm-label-text">Visa</span>
                                        </label>
                                    </li><!-- .nk-kycfm-control-item -->
                                    <li class="nk-kycfm-control-item">
                                        <input class="nk-kycfm-control" type="radio" name="card_type" id="mastercard" data-title="MasterCard" value="mastercard">
                                        <label class="nk-kycfm-label" for="mastercard">
                                            <span class="nk-kycfm-label-icon">
                                                <div class="label-icon">
                                                    <em class="icon ni ni-master-card h3 text-danger"></em>
                                                </div>
                                            </span>
                                            <span class="nk-kycfm-label-text">MasterCard</span>
                                        </label>
                                    </li><!-- .nk-kycfm-control-item -->
                                    <li class="nk-kycfm-control-item">
                                        <input class="nk-kycfm-control" type="radio" name="card_type" id="discover" data-title="Discover" value="discover">
                                        <label class="nk-kycfm-label" for="discover">
                                            <span class="nk-kycfm-label-icon">
                                                <div class="label-icon">
                                                    <em class="icon ni ni-cc-discover h3 text-primary"></em>
                                                </div>
                                            </span>
                                            <span class="nk-kycfm-label-text">Discover</span>
                                        </label>
                                    </li><!-- .nk-kycfm-control-item -->
                                </ul><!-- .nk-kycfm-control-list -->
                                <h6 class="title">Features and Benefits of <?php echo $shortname ?> Visual Card:</h6>
                                <ul class="list list-sm list-checked">
                                    <li>It’s Virtual: You don’t need to carry it out around to use it for online transactions as it's virtually available on your Internet Banking.</li>
                                    <li>The card can be loaded from your existing Account via Internet Banking.</li>
                                    <li>It's readily available after approval.</li>
                                    <li>It valid for 3 years.</li>
                                </ul>
                            </div><!-- .nk-kycfm-content -->
                            <div class="nk-kycfm-footer">
                                <div class="form-group">
                                    <div class="custom-control custom-control-xs custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="tc-agree" required>
                                        <label class="custom-control-label" for="tc-agree">I Have Read The <a href="">Terms Of Condition</a> And <a href="privacy">Privacy Policy</a></label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-control-xs custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="info-assure" required>
                                        <label class="custom-control-label" for="info-assure">All The Personal Information I Have Entered Is Correct.</label>
                                    </div>
                                </div>
                                <div id="cardResult"></div>
                                <div class="nk-kycfm-action pt-2">
                                    <button type="submit" class="btn btn-lg btn-primary" id="btn">Apply</button>
                                </div>
                            </div><!-- .nk-kycfm-footer -->
                        </div><!-- .nk-kycfm -->
                    </div><!-- .card -->
                    </form>
                </div><!-- nk-block -->
            </div><!-- kyc-app -->
        </div>
    </div>
</div>
<script src="../js/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#cardForm").on('submit', (function(e) {
            document.getElementById("btn").disabled = true;
            e.preventDefault();
            $.ajax({
                url: "../scripts/auth?action=ApplyForVisualCard",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    document.getElementById("btn").disabled = false;
                    $("#cardResult").html(data);
                },
                error: function() {}
            });
        }));
    });
</script>
<?php require_once('footer.php'); ?>