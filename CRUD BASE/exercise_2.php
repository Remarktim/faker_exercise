<?php

require ('vendor/autoload.php');

$faker = Faker\Factory::create();

include "connect_db.php";

$userIds = array();
$sql = "SELECT id FROM user_account";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $userIds[] = $row['id'];
    }
}

$sql = "INSERT INTO card_detail (creditCard_Type, creditCard_Number, creditCard_ExpirationDate, user_Id_Number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

for ($i = 0; $i < 20; $i++) {
    $creditCard_Type = $faker->creditCardType;
    $creditCard_Number = $faker->creditCardNumber;
    $creditCard_ExpirationDate = $faker->creditCardExpirationDateString;
    $user_Id_Number = $faker->randomElement($userIds);

    $stmt->bind_param("sssi", $creditCard_Type, $creditCard_Number, $creditCard_ExpirationDate, $user_Id_Number);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

echo "Data inserted successfully.";


$stmt->close();
$conn->close();
?>