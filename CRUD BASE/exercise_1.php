<?php

require ('vendor/autoload.php');

$faker = Faker\Factory::create();

include "connect_db.php";

$sql = "INSERT INTO user_account (email, last_name, first_name, user_name, password) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

// Generate and insert 100 rows of fake data
for ($i = 0; $i < 100; $i++) {
    $email = $faker->email;
    $last_name = $faker->lastName;
    $first_name = $faker->firstName;
    $user_name = $faker->userName;
    $password = $faker->password;

    $stmt->bind_param("sssss", $email, $last_name, $first_name, $user_name, $password);
    if ($stmt->execute()) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $stmt->error;
    }
}

echo "Data inserted successfully.";

// Close the statement and connection
$stmt->close();
$conn->close();
