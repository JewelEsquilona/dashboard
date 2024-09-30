<?php
session_start();
require '../db/config.php';

// PHP code to handle form submissions for adding, updating, and deleting records
if (isset($_POST['delete_alumni'])) {
    // Code to delete alumni record
    $alumni_id = mysqli_real_escape_string($con, $_POST['delete_alumni']);
    $delete_query = "DELETE FROM `2024-2025` WHERE Alumni_ID_Number='$alumni_id'";

    // Execute the delete query
    if (mysqli_query($con, $delete_query)) {
        $_SESSION['message'] = "Alumni Deleted Successfully";
    } else {
        $_SESSION['message'] = "Alumni Not Deleted: " . mysqli_error($con);
    }

    header("Location: index.php"); // Redirect to avoid resubmission
    exit(0);
}

$query = "
SELECT 
    a.Student_Number, 
    a.Last_Name, 
    a.First_Name, 
    a.Middle_Name,
    a.College,
    a.Department, 
    a.Section, 
    a.Year_Graduated, 
    a.Contact_Number, 
    a.Personal_Email, 
    ws.Working_Status,
    ws.Employment_Status,
    ws.Present_Occupation,
    ws.Name_of_Employer,
    ws.Address_of_Employer,
    ws.Number_of_Years_in_Present_Employer,
    ws.Type_of_Employer,
    ws.Major_Line_of_Business,
    a.Alumni_ID_Number 
FROM 
    `2024-2025` a
LEFT JOIN 
    `2024-2025_ed` ws ON a.Alumni_ID_Number = ws.Alumni_ID_Number
";

$query_run = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <title>Alumni Details</title>
</head>

<body>
    <div class="container mt-4">
        <h4>Alumni Details</h4>

        <!-- Link to Add Alumni Form -->
        <a href="alumni-add.php" class="btn btn-primary mb-3">Add New Alumni</a>

        <!-- Add this div for horizontal scrolling -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Last Name</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>College</th>
                        <th>Department</th>
                        <th>Section</th>
                        <th>Year Graduated</th>
                        <th>Contact Number</th>
                        <th>Personal Email</th>
                        <th>Working Status</th>
                        <th>Employment Status</th>
                        <th>Present Occupation</th>
                        <th>Name of Employer</th>
                        <th>Address of Employer</th>
                        <th>Number of Years in Present Employer</th>
                        <th>Type of Employer</th>
                        <th>Major Line of Business</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($query_run) > 0) {
                        foreach ($query_run as $alumni) {
                    ?>
                            <tr>
                                <td><?= htmlspecialchars($alumni['Student_Number']); ?></td>
                                <td><?= htmlspecialchars($alumni['Last_Name']); ?></td>
                                <td><?= htmlspecialchars($alumni['First_Name']); ?></td>
                                <td><?= htmlspecialchars($alumni['Middle_Name']); ?></td>
                                <td><?= htmlspecialchars($alumni['College']); ?></td>
                                <td><?= htmlspecialchars($alumni['Department']); ?></td>
                                <td><?= htmlspecialchars($alumni['Section']); ?></td>
                                <td><?= htmlspecialchars($alumni['Year_Graduated']); ?></td>
                                <td><?= htmlspecialchars($alumni['Contact_Number']); ?></td>
                                <td><?= htmlspecialchars($alumni['Personal_Email']); ?></td>
                                <td><?= htmlspecialchars($alumni['Working_Status']); ?></td>
                                <td><?= htmlspecialchars($alumni['Employment_Status']); ?></td>
                                <td><?= htmlspecialchars($alumni['Present_Occupation']); ?></td>
                                <td><?= htmlspecialchars($alumni['Name_of_Employer']); ?></td>
                                <td><?= htmlspecialchars($alumni['Address_of_Employer']); ?></td>
                                <td><?= htmlspecialchars($alumni['Number_of_Years_in_Present_Employer']); ?></td>
                                <td><?= htmlspecialchars($alumni['Type_of_Employer']); ?></td>
                                <td><?= htmlspecialchars($alumni['Major_Line_of_Business']); ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <a href="alumni-edit.php?id=<?= htmlspecialchars($alumni['Alumni_ID_Number']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <!-- Delete Button -->
                                    <form action="index.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="delete_alumni" value="<?= htmlspecialchars($alumni['Alumni_ID_Number']); ?>">
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='17'>No Record Found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// PHP code to handle form submissions for adding, updating, and deleting records
if (isset($_POST['delete_alumni'])) {
    // Code to delete alumni record
    $alumni_id = mysqli_real_escape_string($con, $_POST['delete_alumni']);
    $delete_query = "DELETE FROM `2024-2025` WHERE Alumni_ID_Number='$alumni_id'";

    // Execute the delete query
    if (mysqli_query($con, $delete_query)) {
        $_SESSION['message'] = "Alumni Deleted Successfully";
    } else {
        $_SESSION['message'] = "Alumni Not Deleted: " . mysqli_error($con);
    }

    header("Location: index.php"); // Redirect to avoid resubmission
    exit(0);
}
?>