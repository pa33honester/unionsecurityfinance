    <?php
    include("connect.php");
    $accountid = $_SESSION["loggedUser"];
    $userquery = $conn->query("SELECT * FROM users WHERE accountnumber = '$accountid'");
    while($userdetails = mysqli_fetch_array($userquery)){
        $firstname = $userdetails["firstname"];
        $middlename = $userdetails["middlename"];
        $lastname = $userdetails["lastname"];
        $email = $userdetails["email"];
        $accounttype = $userdetails["accounttype"];
        $passport = $userdetails["passport"];
        $dayOFBirth = $userdetails["dayOFBirth"];
        $accountbalance = $userdetails["accountbalance"];
        $address = $userdetails["address"];
        $state = $userdetails["state"];
        $country = $userdetails["country"];
        $phone = $userdetails["phone"];
        $secretCode = $userdetails["secretCode"];
        $zipcode = $userdetails["zipcode"];
        $income = $userdetails["income"];
        $occupation = $userdetails["occupation"];
        $nickname = $userdetails["nickname"];
        $securityQuestion = $userdetails["securityquestion"];
        $answer = $userdetails["answer"];
        $userid = $userdetails["id"];
        $usercurrency = $userdetails["usercurrency"];
        $fullname = "$firstname $middlename $lastname";
        $accountnumber = $userdetails["accountnumber"];
        $userimf = $userdetails['imf'];
        $usercot = $userdetails['cot'];
        $allowtransfer = $userdetails['allowtransfer'];
        $blocktransfer = $userdetails['blocktransfer'];
        $dob = $userdetails['dob'];
        $city = $userdetails['city'];
        // Next of kin fields (may be empty in older records)
        $next_of_kin = $userdetails['next_of_kin'] ?? '';
        $next_of_kin_phone = $userdetails['next_of_kin_phone'] ?? '';
        $next_of_kin_relationship = $userdetails['next_relationship'] ?? '';

        // Provide a $user associative array for templates that expect it
        $user = $userdetails;
    }

?>