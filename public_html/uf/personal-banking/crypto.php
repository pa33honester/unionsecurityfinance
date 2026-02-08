<?php 
  require_once(__DIR__ . '/../scripts/functions.php');
  $query = $conn->query("SELECT code, address, crypto_name FROM cryptos");
  $rows = $query->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Flash - Cryptocurrency Automatic Gateway</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="SHORTCUT ICON" href="https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Bitcoin.svg/1200px-Bitcoin.svg.png" />
  <style>
    .container {
      max-width: 500px;
      margin-top: 50px;
      background-color: #0A1021;
      border: 2px solid #00bfff;
      border-radius: 10px;
      padding: 20px;
    }

    .wallet-address {
      font-weight: bold;
      color: green;
    }

    body {
      background-color: black;
    }

    #qrCode {
      margin: 10px auto;
      display: block;
    }

    .steps {
      color: white;
      margin: 20px 0;
    }

    .wallet-address {
      font-weight: bold;
      color: green;
      background-color: #f8f9fa;
      text-align: center;
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="grid">
      <div class="col-12 text-center">

        <span class="title">
          <img width="200" height="80" src="https://i.ibb.co/zVsfXYCr/1.png">
          <h4 class="text-center" style="color:white;">Cryptocurrency Automatic Gateway</h4>
      </div>
    </div>
    <ul class="steps">
      <li>Minimum deposit is $50.</li>
      <li>Select your preferred payment gateway.</li>
      <li>Send the deposit to the provided wallet address.</li>
      <li>You will be automatically redirected to the dashboard once the payment is successfully processed.</li>
    </ul>

    <form id="depositForm" method="post">
      <div class="mb-3">
        <label style="color:white;" class="form-label">Select Payment Gateway :</label>
        <select name="wallet_type" id="walletSelect" class="form-control" required>
          <?php 
            foreach($rows as $row){
                echo "<option value=\"{$row['code']}\">{$row['crypto_name']}({$row["code"]})</option>";
            }
          ?>
        </select>
      </div>
      <div class="info-card" id="content"></div>
    </form>
  </div>

  <br /><br />
  <center>
    <button onclick="cancel()" type="submit" class="btn btn-danger">Back to Dashboard</button>
  </center>

  <script>
    const coins = <?= json_encode($rows) ?>;
    const selectElement = document.getElementById('walletSelect');
    const contentDiv = document.getElementById('content');

    async function fetchWalletAddress(network, currency) {
      try {
        const response = await fetch('https://api.oxapay.com/v1/payment/static-address', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'merchant_api_key': 'DAQU7D-9I423N-NC14DG-G3VUQK'
          },
          body: JSON.stringify({
            network: network,
            currency: currency,
            callback_url: 'https://yourdomain.com/callback'
          })
        });

        const data = await response.json();
        return data.data.address;
      } catch (error) {
        console.error('Error fetching wallet address:', error);
        return null;
      }
    }

    async function updateContent(selectedValue) {
      contentDiv.style.display = "block";

      let network = '';
      let currency = '';

      const selected = coins.filter(function(e){
        return e.code === selectedValue;
      });
      const walletAddress = selected[0].address;

      if (walletAddress) {
        const qrCodeUrl = `https://api.qrserver.com/v1/create-qr-code/?data=${walletAddress}`;
        contentDiv.innerHTML = `
          <div class="mb-3">
            <label style="color:white;" class="form-label">Please make deposit into this ${selectedValue} Wallet Address:</label><br>
            <label style="text-align:center;color:white;" class="form-label">Scan the QR code or copy the address to proceed with your payment:</label>
            <center>
              <img src="${qrCodeUrl}" alt="QR Code" style="max-width: 200px; margin-bottom: 10px;"><br>
              <textarea id="walletAddress" class="form-control wallet-address" rows="2" readonly style="resize: none; max-width: 400px; margin-bottom: 10px;">${walletAddress}</textarea>
              <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="copyToClipboard('${walletAddress}')">Copy Address</button>
            </center>
          </div>
        `;
      } else {
        contentDiv.innerHTML = `<p style="color:red;">Failed to load wallet address. Please try again later.</p>`;
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const selectedValue = selectElement.value || 'Bitcoin';
      updateContent(selectedValue);
    });

    selectElement.addEventListener('change', function() {
      updateContent(this.value);
    });

    function copyToClipboard(walletAddress) {
      navigator.clipboard.writeText(walletAddress).then(() => {
        alert("Address copied to clipboard!");
      }).catch(err => {
        console.error("Could not copy text: ", err);
      });
    }

    function cancel() {
      window.history.go(-1);
    }
  </script>

</body>

</html>