<?php
session_start();
require '../db/config.php';

$alumni_id = $con->insert_id; // This gets the last inserted ID

// Delete Alumni
if (isset($_POST['delete_alumni'])) {
    $alumni_id = $_POST['delete_alumni'];

    $stmt = $con->prepare("DELETE FROM `2024-2025` WHERE Alumni_ID_Number = ?");
    $stmt->bind_param("s", $alumni_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Alumni Deleted Successfully";
        $_SESSION['message_type'] = "success"; // Set message type to success
    } else {
        $_SESSION['message'] = "Alumni Not Deleted: " . $stmt->error;
        $_SESSION['message_type'] = "danger"; // Set message type to danger
    }
    header("Location: index.php");
    exit(0);
}

// Update Alumni
if (isset($_POST['update_alumni'])) {
    // Retrieve and sanitize input
    $alumni_id = mysqli_real_escape_string($con, $_POST['alumni_id']);
    $student_number = mysqli_real_escape_string($con, $_POST['student_number']);
    $last_name = mysqli_real_escape_string($con, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($con, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($con, $_POST['middle_name']);
    $college = mysqli_real_escape_string($con, $_POST['college']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $section = mysqli_real_escape_string($con, $_POST['section']);
    $year_graduated = mysqli_real_escape_string($con, $_POST['year_graduated']);
    $contact_number = mysqli_real_escape_string($con, $_POST['contact_number']);
    $personal_email = mysqli_real_escape_string($con, $_POST['personal_email']);
    $working_status = mysqli_real_escape_string($con, $_POST['working_status']);

    // Employment fields
    $present_occupation = mysqli_real_escape_string($con, $_POST['present_occupation']);
    $name_of_employer = isset($_POST['name_of_employer']) ? mysqli_real_escape_string($con, $_POST['name_of_employer']) : ''; 
    $address_of_employer = isset($_POST['address_of_employer']) ? mysqli_real_escape_string($con, $_POST['address_of_employer']) : ''; 
    $number_of_years_in_present_employer = isset($_POST['number_of_years_in_present_employer']) ? mysqli_real_escape_string($con, $_POST['number_of_years_in_present_employer']) : ''; 
    $type_of_employer = isset($_POST['type_of_employer']) ? mysqli_real_escape_string($con, $_POST['type_of_employer']) : ''; 
    $major_line_of_business = mysqli_real_escape_string($con, $_POST['major_line_of_business']);

    $stmt = $con->prepare("UPDATE `2024-2025` SET 
        Student_Number=?, 
        Last_Name=?, 
        First_Name=?, 
        Middle_Name=?, 
        College=?, 
        Department=?, 
        Section=?, 
        Year_Graduated=?, 
        Contact_Number=?, 
        Personal_Email=? 
        WHERE Alumni_ID_Number=?");

    $stmt->bind_param(
        "sssssssssss",
        $student_number,
        $last_name,
        $first_name,
        $middle_name,
        $college,
        $department,
        $section,
        $year_graduated,
        $contact_number,
        $personal_email,
        $alumni_id
    );

    if ($stmt->execute()) {
        // Update the 2024-2025_ed table
        $stmt_ws = $con->prepare("UPDATE `2024-2025_ed` SET 
            Working_Status=?, 
            Present_Occupation=?, 
            Name_of_Employer=?, 
            Address_of_Employer=?, 
            Number_of_Years_in_Present_Employer=?, 
            Type_of_Employer=?, 
            Major_Line_of_Business=? 
            WHERE Alumni_ID_Number=?");

        $stmt_ws->bind_param(
            "ssssssss",
            $working_status,
            $present_occupation,
            $name_of_employer,
            $address_of_employer,
            $number_of_years_in_present_employer,
            $type_of_employer,
            $major_line_of_business,
            $alumni_id
        );

        if ($stmt_ws->execute()) {
            $_SESSION['message'] = "Alumni Updated Successfully";
            $_SESSION['message_type'] = "success"; // Set message type to success
        } else {
            $_SESSION['message'] = "Alumni Working Status Not Updated: " . $stmt_ws->error;
            $_SESSION['message_type'] = "danger"; // Set message type to danger
        }
    } else {
        $_SESSION['message'] = "Alumni Not Updated: " . $stmt->error;
        $_SESSION['message_type'] = "danger"; // Set message type to danger
    }
    header("Location: index.php");
    exit(0);
}

// Save Alumni
if (isset($_POST['save_alumni'])) {
    // Retrieve and sanitize input
    $student_number = $_POST['student_number'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $college = $_POST['college'];
    $department = $_POST['department'];
    $section = $_POST['section'];
    $year_graduated = $_POST['year_graduated'];
    $contact_number = $_POST['contact_number'];
    $personal_email = $_POST['personal_email'];
    
    // Working Status and other fields for 2024-2025_ed
    $working_status = $_POST['working_status'];
    $present_occupation = $_POST['present_occupation'];
    $name_of_employer = $_POST['name_of_employer'];
    $address_of_employer = $_POST['address_of_employer'];
    $number_of_years_in_present_employer = $_POST['number_of_years_in_present_employer'];
    $type_of_employer = $_POST['type_of_employer'];
    $major_line_of_business = $_POST['major_line_of_business'];

    // Start transaction
    $con->begin_transaction();

    try {
        // Insert into 2024-2025 table
        $stmt = $con->prepare("INSERT INTO `2024-2025` 
            (Student_Number, Last_Name, First_Name, Middle_Name, College, Department, Section, Year_Graduated, Contact_Number, Personal_Email) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->bind_param(
            "ssssssssss",
            $student_number,
            $last_name,
            $first_name,
            $middle_name,
            $college,
            $department,
            $section,
            $year_graduated,
            $contact_number,
            $personal_email
        );

        if ($stmt->execute()) {
            // Get the last inserted ID
            $alumni_id = $con->insert_id;

            // Debug: Check the last inserted ID
            echo "Alumni ID created: " . $alumni_id; 

            // Now also add to the 2024-2025_ed table
            $stmt_ws = $con->prepare("INSERT INTO `2024-2025_ed` 
                (Alumni_ID_Number, Working_Status, Present_Occupation, Name_of_Employer, Address_of_Employer, Number_of_Years_in_Present_Employer, Type_of_Employer, Major_Line_of_Business) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

            // Debugging output for the ID being inserted
            echo "Attempting to insert into 2024-2025_ed with Alumni_ID_Number: " . $alumni_id;

            $stmt_ws->bind_param("ssssssss", $alumni_id, $working_status, $present_occupation, $name_of_employer, $address_of_employer, $number_of_years_in_present_employer, $type_of_employer, $major_line_of_business);

            if ($stmt_ws->execute()) {
                // Commit transaction
                $con->commit();
                $_SESSION['message'] = "Alumni Created Successfully";
                $_SESSION['message_type'] = "success"; 
                header("Location: alumni-add.php");
                exit(0);
            } else {
                // Rollback transaction if there is an error
                $con->rollback();
                $_SESSION['message'] = "Alumni Working Status Not Created: " . $stmt_ws->error;
                $_SESSION['message_type'] = "danger"; 
            }
        } else {
            // Rollback transaction if there is an error
            $con->rollback();
            $_SESSION['message'] = "Alumni Not Created: " . $stmt->error;
            $_SESSION['message_type'] = "danger"; 
        }
    } catch (Exception $e) {
        // Rollback transaction on exception
        $con->rollback();
        $_SESSION['message'] = "Error occurred: " . $e->getMessage();
        $_SESSION['message_type'] = "danger"; 
    }

    // Redirect after processing
    header("Location: alumni-add.php");
    exit(0);
}
?>