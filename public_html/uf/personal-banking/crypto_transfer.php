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
  <title>Transfer - Cryptocurrency Automatic Transfer</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link href="../css/toastr.css" rel="stylesheet"/>
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
      <li>Minimum transfer amount is $50.</li>
      <li>Select your preferred payment gateway.</li>
      <li>Input your preferred destination wallet address.</li>
      <li>Specify the amount to transfer.</li>
    </ul>

    <form action="../scripts/auth.php?action=transfer_crypto" id="transferForm" method="post">
      <div class="mb-3">
        <label style="color:white;" class="form-label">Select Payment Gateway :</label>
        <select name="coin" id="coin" class="form-control" required>
          <?php 
            foreach($rows as $row){
                echo "<option value=\"{$row['code']}\">{$row['crypto_name']}({$row["code"]})</option>";
            }
          ?>
        </select>
      </div>
      <div class="form-group mb-3">
        <label style="color:white">Target Wallet Address:</label>
        <input type="text" id="destination" name="destination"
          class="form-control" placeholder="Enter wallet address" required>
        <small id="addr_hint" class="text-muted"></small>
      </div>

      <div class="form-group mb-3">
        <label style="color:white">Amount:</label>
        <input type="number" name="amount" min="0" step="0.0001" class="form-control"
          placeholder="Enter amount" required>
      </div>
      <div class="info-card" id="content"></div>
      <div class="mb-3 text-center">
        <button type="submit" class="btn btn-primary">Proceed to Transfer</button>
        <button onclick="cancel()" type="submit" class="btn btn-danger">Back to Dashboard</button>
    </form>
  </div>

  <script src="../js/jquery.min.js"></script>
  <script src="../js/toastr.js"></script>
  <script>
    const coins = <?= json_encode($rows); ?>;
    let network = '';
    let currency = '';
    const selectElement = document.getElementById('coin');
    const contentDiv = document.getElementById('content');
    const addressInput = document.getElementById("destination");
    const addrHint = document.getElementById("addr_hint");

    function validateAddress(addr, net) {
      const patterns = {
        "TRON": /^T[a-zA-Z0-9]{33}$/,
        "ETH": /^0x[a-fA-F0-9]{40}$/,
        "BTC": /^(bc1|[13])[a-zA-HJ-NP-Z0-9]{25,39}$/
      };
      return patterns[net]?.test(addr);
    }

    function showHint(valid) {
      addrHint.textContent = valid ? "✅ Address looks valid" : "⚠️ Invalid address format";
      addrHint.className = valid ? "text-success" : "text-danger";
    }

    addressInput.addEventListener("input", () => {
      // const valid = validateAddress(addressInput.value.trim(), network);
      // showHint(valid);
    });

    async function fetchWalletAddress(network, currency) {
      try {
        const response = await fetch('https://api.oxapay.com/v1/payment/static-address', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'merchant_api_key': 'NVDSIK-XGF23G-OQH1MZ-WILD4Q'
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

      network = '';
      currency = '';

      switch (selectedValue) {
        case 'Bitcoin':
          network = 'Bitcoin';
          currency = 'BTC';
          break;
        case 'Ethereum':
          network = 'Ethereum';
          currency = 'ETH';
          break;
        case 'Solana':
          network = 'Solana';
          currency = 'SOL';
          break;
        case 'Ton':
          network = 'Ton';
          currency = 'TON';
          break;
        case 'TRX':
          network = 'Tron';
          currency = 'TRX';
          break;
        case 'BNB':
          network = 'Binance';
          currency = 'BNB';
          break;
        case 'DOGE':
          network = 'Doge';
          currency = 'DOGE';
          break;
        case 'LTC':
          network = 'Litecoin';
          currency = 'LTC';
          break;
        case 'POLYGON':
          network = 'POLYGON';
          currency = 'POLYGON';
          break;
        case 'USDC':
          network = 'Ethereum';
          currency = 'USDC';
          break;
        case 'USDT_ERC20':
          network = 'Ethereum';
          currency = 'USDT';
          break;
        case 'USDT_BEP20':
          network = 'Binance';
          currency = 'USDT';
          break;
        case 'USDT_TRC20':
          network = 'Tron';
          currency = 'USDT';
          break;
        default:
          contentDiv.style.display = "none";
          return;
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const selectedValue = selectElement.value || 'Bitcoin';
      updateContent(selectedValue);
    });

    selectElement.addEventListener('change', async function() {
      await updateContent(this.value);
    });

    function cancel() {
      window.history.go(-1);
    }

    $(document).ready(function(e) {
        $("#transferForm").on('submit', (function(e) {
            e.preventDefault();
            $.ajax({
                url: "../scripts/auth.php?action=transfer_crypto",
                type: "POST",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(res) {
                    console.log(res);
                    const data = JSON.parse(res);
                    if(data['success']) {
                        toastr.success('Transfer Successful. Pending Confirmation.', 'Success', {"progressBar": true});
                        setTimeout(function(){
                          // window.location.href = "../personal-banking/";
                        }, 3000);
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
        }));
    });
</script>

</body>

</html>