<?php
require 'db/config.php';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../style/style.css">

    <title>Alumni Lists</title>
</head>
<body>

<div class="container mt-5">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Alumni View Details 
                        <a href="index.php" class="btn btn-danger float-end">BACK</a>
                    </h4>
                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['id'])) {
                        $alumni_id = mysqli_real_escape_string($con, $_GET['id']);
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
                            ws.Number_of_Years_in_Present,
                            ws.Type_of_Employer,
                            ws.Major_Line_of_Business
                        FROM 
                            `2024-2025` a
                        LEFT JOIN 
                            `2024-2025_ed` ws ON a.Alumni_ID_Number = ws.Alumni_ID_Number
                        WHERE 
                            a.Student_Number = '$alumni_id'
                        ";
                        $query_run = mysqli_query($con, $query);

                        if (mysqli_num_rows($query_run) > 0) {
                            $alumni = mysqli_fetch_array($query_run);
                            ?>

                            <div class="mb-3">
                                <label>Student Number</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Student_Number']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Last Name</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Last_Name']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>First Name</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['First_Name']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Middle Name</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Middle_Name']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>College</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['College']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Department</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Department']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Section</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Section']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Year Graduated</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Year_Graduated']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Contact Number</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Contact_Number']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Personal Email</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Personal_Email']); ?>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label>Working Status</label>
                                <p class="form-control">
                                    <?= htmlspecialchars($alumni['Working_Status']) ?: 'N/A'; ?>
                                </p>
                            </div>

                            <?php
                        } else {
                            echo "<h4>No Such ID Found</h4>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
