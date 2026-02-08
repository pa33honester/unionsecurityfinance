<?php

  require_once(__DIR__ . '/../scripts/functions.php');
  require_once(__DIR__ . '/../scripts/userdata.php');
?>

<!doctype html>
<!--
  paypal_transfer_mock.php
  Mock PayPal transfer page (no backend) — HTML + PHP (just file extension), Bootstrap 5, jQuery
  Focus: Icons, simple UI design. Client-side validation and fake transfer flow.
-->

<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PayPal Transfer</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <!-- Bootstrap JS bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body { background: linear-gradient(180deg, #f7f9fc 0%, #ffffff 60%); }
    .paypal-card { max-width: 720px; margin: 48px auto; border-radius: 14px; box-shadow: 0 8px 30px rgba(37, 63, 97, 0.08); }
    .paypal-header { background: linear-gradient(90deg,#009cde 0%,#003087 100%); color: white; border-radius: 14px 14px 0 0; padding: 18px; }
    .paypal-logo { font-weight: 700; letter-spacing: 0.6px; }
    .muted-small { font-size: .88rem; color: #6c757d; }
    .big-amount { font-size: 1.6rem; font-weight: 700; }
    .icon-circle { width: 44px; height: 44px; display:inline-flex; align-items:center; justify-content:center; border-radius:50%; background: rgba(255,255,255,0.12); }
    .form-control:focus { box-shadow: none; border-color: #0d6efd; }
  </style>
</head>
<body>

<div class="card paypal-card">
  <div class="paypal-header d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <div class="icon-circle">
        <!-- PayPal-ish icon (simple P) -->
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M7 6h6.5a3 3 0 0 1 2.9 2.2L18.6 11" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M9 18h6.5a3 3 0 0 0 2.9-2.2L20.6 13" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M5 12h3" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div>
        <div class="paypal-logo" style="height:32px; font-size:x-large">PayPal</div>
        <div class="muted-small">Instant Transfer</div>
      </div>
    </div>
    <div class="text-end">
      <div class="muted-small">Balance</div>
      <div class="big-amount"><?= $usercurrency .' '. $accountbalance ?></div>
    </div>
  </div>

  <div class="card-body p-4">
    <form id="transferForm" novalidate>

      <div class="row g-3">
        <div class="col-12 col-md-6">
          <label class="form-label">From</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
            <input type="text" class="form-control" id="fromName" value="<?= $firstname . ' ' .$lastname ?>" readonly>
          </div>
          <div class="form-text">Primary account</div>
        </div>

        <div class="col-12 col-md-6">
          <label for="toEmail" class="form-label">Send to (email)</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
            <input type="email" class="form-control" id="toEmail" placeholder="recipient@example.com" required>
          </div>
          <div class="invalid-feedback">Please enter a valid email address.</div>
        </div>

        <div class="col-6 col-md-4">
          <label for="amount" class="form-label">Amount</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input type="number" class="form-control" id="amount" placeholder="0.00" min="0.01" step="0.001" required>
          </div>
          <div class="invalid-feedback">Enter an amount greater than $0.00.</div>
        </div>

        <div class="col-6 col-md-4">
          <label for="currency" class="form-label">Currency</label>
          <select id="currency" class="form-select" aria-label="Currency selection">
            <option value="USD" selected>USD</option>
            <option value="EUR">EUR</option>
            <option value="GBP">GBP</option>
          </select>
        </div>

        <div class="col-12 col-md-4">
          <label for="fee" class="form-label">Estimated fee</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-gear-fill"></i></span>
            <input type="text" class="form-control" id="fee" value="$0.00" readonly>
          </div>
        </div>

        <div class="col-12">
          <label for="note" class="form-label">Note (optional)</label>
          <textarea id="note" class="form-control" rows="2" placeholder="Please write your simple note here"></textarea>
        </div>

        <div class="col-12 d-flex justify-content-between align-items-center">
          <div class="muted-small">The transfer will be accomplished after the request appoved.</div>
          <div>
            <button type="button" id="previewBtn" class="btn btn-outline-primary me-2"><i class="bi bi-eye"></i> Preview</button>
            <button type="submit" class="btn btn-primary"><i class="bi bi-currency-dollar"></i> Send</button>
          </div>
        </div>
      </div>

    </form>

    <!-- Preview Card -->
    <div id="previewArea" class="mt-4" style="display:none;">
      <div class="alert alert-info d-flex align-items-center" role="alert">
        <i class="bi bi-info-circle-fill me-2"></i>
        <div>
          <strong>Preview:</strong> Ready to send <span id="previewAmount"></span> to <span id="previewTo"></span>.
        </div>
      </div>
    </div>

    <!-- Success area (hidden) -->
    <div id="successArea" class="mt-4" style="display:none;">
      <div class="card border-success">
        <div class="card-body d-flex gap-3 align-items-center">
          <div class="fs-3 text-success"><i class="bi bi-check-circle-fill"></i></div>
          <div>
            <h6 class="mb-1">Proceed to Transfer</h6>
            <div class="muted-small">Transaction ID: <code id="txid">-</code></div>
            <div class="mt-2">
              <button class="btn btn-sm btn-outline-secondary" id="copyTx">Copy TXID</button>
              <button class="btn btn-sm btn-success" id="newTransfer">New transfer</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Confirm modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmModalLabel"><i class="bi bi-card-checklist me-2"></i>Confirm transfer</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="mb-1"><strong>To:</strong> <span id="mTo"></span></p>
        <p class="mb-1"><strong>Amount:</strong> <span id="mAmount"></span></p>
        <p class="mb-1"><strong>Currency:</strong> <span id="mCurrency"></span></p>
        <p class="mb-1"><strong>Note:</strong> <span id="mNote"></span></p>
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" value="" id="ackCheck">
          <label class="form-check-label" for="ackCheck">I agree.</label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" id="confirmSend" class="btn btn-primary" disabled>Confirm Send</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function(){
    function formatUSD(n){ return new Intl.NumberFormat('en-US',{style:'currency',currency:$('#currency').val()}).format(n); }

    // Update fee when amount changes
    $('#amount, #currency').on('input change', function(){
      const amt = parseFloat($('#amount').val()) || 0;
      // simple mock fee: 2.9% + $0.30 (typical card fee) — shown as mock only
      const fee = +(amt * 0.029 + 0.30).toFixed(2);
      $('#fee').val(formatUSD(fee));
    });

    // Preview button
    $('#previewBtn').click(function(){
      const to = $('#toEmail').val();
      const amt = parseFloat($('#amount').val()) || 0;
      if(!to || !amt || amt <= 0){
        // show validation
        $('#toEmail').toggleClass('is-invalid', !to);
        $('#amount').toggleClass('is-invalid', !(amt>0));
        return;
      }
      $('#previewTo').text(to);
      $('#previewAmount').text(formatUSD(amt));
      $('#previewArea').slideDown();
      $('html, body').animate({scrollTop: $('#previewArea').offset().top - 80}, 300);
    });

    // Form submit: show confirm modal
    $('#transferForm').on('submit', function(e){
      e.preventDefault();
      // simple client-side validation
      const to = $('#toEmail').val();
      const amt = parseFloat($('#amount').val()) || 0;
      if(!to || !amt || amt <= 0){
        $('#toEmail').toggleClass('is-invalid', !to);
        $('#amount').toggleClass('is-invalid', !(amt>0));
        return;
      }
      $('#mTo').text(to);
      $('#mAmount').text(formatUSD(amt));
      $('#mCurrency').text($('#currency').val());
      $('#mNote').text($('#note').val() || '-');
      $('#ackCheck').prop('checked', false);
      $('#confirmSend').prop('disabled', true);
      const confModal = new bootstrap.Modal(document.getElementById('confirmModal'));
      confModal.show();
    });

    // enable confirm when checkbox checked
    $('#ackCheck').on('change', function(){
      $('#confirmSend').prop('disabled', !this.checked);
    });

    // Confirm send -> simulate transfer
    $('#confirmSend').click(function(){
      const button = $(this);
      button.prop('disabled', true).text('Sending...');
      // simulate network delay
      const tx = 'TX' + Math.random().toString(36).substring(2,10).toUpperCase();

      $.ajax({
          url: "../scripts/auth.php?action=transfer_paypal",
          type: "POST",
          data: {
              userid: "<?= $userid ?>",
              amount: parseFloat($('#amount').val()) || 0,
              currency: $('#currency').val(),
              toEmail: $('#toEmail').val(),
              note: $('#note').val(),
              fee: $('#fee').val(),
              txid: tx,
          },
          success: function(res) {
              console.log(res);
              const data = JSON.parse(res);
              if(data['success']) {
                  // generate fake tx id
                  $('#txid').text(tx);
                  $('#successArea').slideDown();
                  // hide modal
                  const modalEl = document.getElementById('confirmModal');
                  const modal = bootstrap.Modal.getInstance(modalEl);
                  modal.hide();
                  button.prop('disabled', false).text('Confirm Send');
                  toastr.success('Transfer Successful. Pending Confirmation.', 'Success', {"progressBar": true});
              }
              else {
                  toastr.error(data.msg, 'Error', {"progressBar": true});
              }
          },
          error: function(err) {
            toastr.error('Error Occurred : ' + err, 'Error');
            console.log(err);
          }
      });
    });

    // Copy txid
    $('#copyTx').click(function(){
      const tx = $('#txid').text();
      navigator.clipboard?.writeText(tx).then(()=>{
        const b = $(this);
        b.text('Copied!');
        setTimeout(()=>b.text('Copy TXID'),1200);
      });
    });

    // New transfer
    $('#newTransfer').click(function(){
      $('#toEmail').val('');
      $('#amount').val('');
      $('#note').val('');
      $('#fee').val('$0.00');
      $('#previewArea, #successArea').slideUp();
      $('html, body').animate({scrollTop: 0}, 300);
    });

    // small UX: clear invalid state on input
    $('#toEmail, #amount').on('input', function(){ $(this).removeClass('is-invalid'); });

  });
</script>

</body>
</html>
