<?php

require ('vendor/autoload.php');

$faker = Faker\Factory::create();

include "connect_db.php";

$sql = "INSERT INTO card_detail (creditCard_Type, creditCard_Number, creditCard_ExpirationDate, user_Id_Number) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);


for ($i = 0; $i < 20; $i++) {
    $creditCard_Type = $faker->creditCardType;
    $creditCard_Number = $faker->creditCardNumber;
    $creditCard_ExpirationDate = $faker->creditCardExpirationDateString;
    $user_Id_Number = $faker->numberBetween(1, 100);

    $stmt->bind_param("sssi", $creditCard_Type, $creditCard_Number, $creditCard_ExpirationDate, $user_Id_Number);
    $stmt->execute();
}

echo "Data inserted successfully.";

// Close the statement and connection
$stmt->close();
$conn->close();
?>