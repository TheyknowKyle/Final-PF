<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "loan";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $targetDir = "pictures/"; 
    $fileName = basename($_FILES["sign"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    $allowTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (isset($_POST['paymentMethod']) && ($_POST['paymentMethod'] === 'cash' || $_POST['paymentMethod'] === 'card')) {
        if (move_uploaded_file($_FILES["sign"]["tmp_name"], $targetFilePath)) {
            $name = $_POST['name'];
            $studentId = $_POST['studentid'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $amount = $_POST['amount'];
            $paymentMethod = $_POST['paymentMethod'];
            $purpose = $_POST['purpose'];

            $sql = "INSERT INTO loantable (name, student_id, email, phone, address, amount, payment_method, purpose, signature) 
                    VALUES ('$name', '$studentId', '$email', '$phone', '$address', '$amount', '$paymentMethod', '$purpose', '$fileName')";
            if ($conn->query($sql) === TRUE) {
                
                $fileContent = "Name: $name\nStudent ID: $studentId\nEmail: $email\nPhone: $phone\nAddress: $address\nAmount: $amount\nPayment Method: $paymentMethod\nPurpose: $purpose";
                $file = fopen("submitted_info.txt", "w");
                fwrite($file, $fileContent);
                fclose($file);
                

                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="submitted_info.txt"');
                readfile("submitted_info.txt");
                
                
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo '<div id="successMessage" style="color: red;">Sorry, there was an error uploading your file.</div>';
        }
    } else {
        echo '<div id="successMessage" style="color: red;">Sorry, payment method not provided or invalid.</div>';
    }

    $conn->close();
}
?>






<!DOCTYPE html>
<html>
<head>
    <title>Registration Form</title>
    <style>

body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

.title-div {
    text-align: center;
    margin-top: 20px;
    background:lightgreen;
    padding: 10px;
    border: solid black 3px;
}

.title-div h1 {
    margin-bottom: 5px;
}

.recevied {
    color: red;
    font-size: 14px;
}

h3 {
    margin-top: 30px;
    font-size: 18px;
}

.name-div,
.id-div,
.gmail-div,
.mobile-div,
.address-div,
.amount-div,
.method-div,
.purpose-div,
.received-div,
.date-div,
.time-div,
.cashloan-div,
.transaction-div {
    margin-top: 15px;
}

.name-div .name,
.id-div .name,
.gmail-div .name,
.mobile-div .name,
.address-div .name,
.amount-div .name,
.method-div .name,
.purpose-div .name,
.received-div .name,
.date-div .name,
.time-div .name,
.cashloan-div .name,
.amount-div .name,
.transaction-div .name {
    font-size: 16px;
    font-weight: bold;
}

.input-div input[type="input"],input[type = "number"],input[type = "email"] {
    width: calc(100% - 5px);
    padding: 8px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.method-div {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.method-div label {
    margin-right: 10px;
    font-size: 14px;
}

input[type="file"] {
    display: none;
}

input[type="file"] + label {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

.btn {
    margin-top: 20px;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
}

.last-div {
    margin-top: 20px;
    font-size: 12px;
    text-align: center;
    color: #777;
}

.last-div p {
    margin-bottom: 5px;
}

.never {
    font-weight: bold;
}

.term {
    font-size: 10px;
    margin-bottom: 10px;
}

.last-div p:nth-child(3) {
    font-size: 10px;
    font-style: italic;
}

    </style>
</head>
<body>
    <div>
        <div class="title-div">
            <h1>Pampanga State Agricultural University</h1>
            <h1>Loan Money Form</h1>

        </div>
        
        <div>
            <h3>STUDENT INFORMATION</h3>
        </div>
        <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="name-div">
            <div class="name">Full Name<span class="recevied">*</span></div>
            <div class="input-div"><input type="input" name="name" placeholder="Enter your Whole Name" required></div>
        </div>

        <div class="id-div">
            <div class="name">Student Id<span class="recevied">*</span></div>
            <div class="input-div"><input type="input" name="studentid" placeholder="Enter your Student Id" required></div>
       </div>

       <div class="gmail-div">
            <div class="name">Email<span class="recevied">*</span></div>
            <div class="input-div"><input type="email" name="email" placeholder="Enter you Email" required></div>
        </div>

        <div class="mobile-div">
            <div class="name">Phone Number<span class="recevied">*</span></div>
            <div class="input-div"><input type="number" name="phone" placeholder="Your Phone Number" required></div>
       </div>

       <div class="address-div">
            <div class="name">Address<span class="recevied">*</span></div>
            <div class="input-div"><input type="input" name="address" placeholder="Enter you Address" required></div>
        </div>
       
    <div>
        <h3>CASH LOAN DETAILS</h3>
    </div>

        <div class="amount-div">
            <div class="name">Amount to Loan<span class="recevied">*</span></div>
            <div class="input-div"><input type="number" name="amount" placeholder="Enter Amount"></div>
        </div>

        <div class="method-div">
    <div class="name">Method:<span class="recevied">*</span></div>
    <input type="radio" id="cash" name="paymentMethod" value="cash" required>
    <label for="cash">Cash</label>
    <input type="radio" id="card" name="paymentMethod" value="card" required>
    <label for="card">Credit/Debit card</label>
</div>

        

        <div class="purpose-div">
            <div class="name">Purpose of Cash Loan<span class="recevied">*</span></div>
            <div class="input-div"><input type="input" name="purpose" placeholder="Purpose of your cash loan"></div>
        </div>

    <div>
        <h3>APPROVAL:</h3>
        <p>I hereby authorize the Cash Loan
        for the above-mentioned student.</p>
        <input type="file" id="file" name = "sign" />
        <label for="file">Upload Signature</label>
    </div>


    

        <div>
            <input class="btn" type="submit" name="Submit" onclick="submitForm()">
        </div>
</form>

        <div id="successMessage" style="display: none; color: green;">
            <p>Submit Successful!</p>
        </div>

        <div class="last-div">
            <p class="never">Never submit passwords through Google Forms.</p>
            <p class="term">This content is neither created nor endorsed by Google, Report Abuse - Private Policy</p>
            <p>Google Forms</p>
        </div>
        
    </div>

</body>
</html>
