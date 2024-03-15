<?php
require ('vendor/autoload.php');

$faker = Faker\Factory::create();

include "db_connect.php";

$sql = "INSERT INTO office (name, contactnum, email, address, city, country, postal) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

for ($i = 0; $i < 200; $i++) {
    $name = $faker->company;
    $contact_num = $faker->phoneNumber;
    $email = $faker->email;
    $address = $faker->address;
    $city = $faker->city;
    $country = $faker->country;
    $postal = $faker->postcode;

    $stmt->bind_param("ssssssi", $name, $contact_num, $email, $address, $city, $country, $postal);
    $stmt->execute();
}

$officeIds = array();
$sql = "SELECT id FROM office";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $officeIds[] = $row['id'];
    }
}

// Insert data into the office table
$sql = "INSERT INTO employee (lastname, firstname, office_id, address) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

for ($i = 0; $i < 20; $i++) {
    $last_name = $faker->lastName;
    $first_name = $faker->firstName;
    $office_id = $faker->randomElement($officeIds);
    $address = $faker->address;

    $stmt->bind_param("ssis", $last_name, $first_name, $office_id, $address);
    $stmt->execute();
}

$employeeIds = array();
$sql = "SELECT id FROM employee";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $employeeIds[] = $row['id'];
    }
}


$sql = "INSERT INTO transaction (employee_id, office_id, datelog, action, remarks, documentcode) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

for ($i = 0; $i < 200; $i++) {
    $employee_id = $faker->randomElement($employeeIds);
    $office_id = $faker->randomElement($officeIds);
    $datelog = $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s');
    $action = $faker->randomElement(['In', 'Out', 'Complete']);
    $remarks = $faker->randomElement(['Signed', 'Not Signed', 'Approved', 'Rejected', 'Pending']);
    $documentcode = $faker->ean8;

    $stmt->bind_param("iissss", $employee_id, $office_id, $datelog, $action, $remarks, $documentcode);
    $stmt->execute();
}

echo "Data inserted successfully!";

$stmt->close();
$conn->close();
?>