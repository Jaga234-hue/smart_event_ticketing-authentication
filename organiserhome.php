<?php
require_once 'db_connect.php';

// Check database connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM notifications WHERE status = 'pending'";
$result = mysqli_query($conn, $sql);

// Check for SQL query error
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}

// Check if there are pending notifications
if (mysqli_num_rows($result) == 0) {
    echo "<p>No pending notifications.</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        /* General Styling */
        body {
            display: flex;
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: white;
            margin: 0;
            padding: 20px;
            flex-direction: column;
            align-items: center;
        }

        /* Styling for the Event Details Form */
        .details-of-event {
            max-width: 350px;
            background: linear-gradient(135deg, #1f1f1f, #292929);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.2);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        label {
            text-align: left;
            font-weight: bold;
            font-size: 1.2rem;
            color: #f8f8f8;
        }

        .input-box {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #1e1e1e;
            color: white;
            outline: none;
            transition: all 0.3s ease-in-out;
        }

        .input-box:focus {
            border-color: #ff4757;
            box-shadow: 0 0 8px rgba(255, 71, 87, 0.7);
        }

        /* Notification Box */
        .notification {
            background-color: #444;
            color: white;
            width: fit-content;
            padding: 15px 20px;
            border-radius: 8px;
            border: 2px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            text-transform: uppercase;
            box-shadow: 0px 4px 10px rgba(255, 255, 255, 0.2);
        }

        /* Space Divider */
        .space {
            height: 50px;
        }

        /* Add Button */
        .add {
            background: linear-gradient(135deg, #ff4757, #ff6b81);
            color: white;
            padding: 10px 20px;
            font-size: 1.5rem;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(255, 71, 87, 0.5);
        }

        .add:hover {
            background: linear-gradient(135deg, #ff6b81, #ff4757);
            transform: scale(1.05);
        }

        /* Highlighted Span */
        span {
            text-decoration: solid;
            color: red;
            font-weight: bold;
            background-color: black;
            font-size: large;
            padding: 5px;
            border-radius: 5px;
        }

        button {
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: white;
            padding: 12px 24px;
            font-size: 1.2rem;
            font-weight: bold;
            text-transform: uppercase;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s ease-in-out;
            box-shadow: 0 4px 10px rgba(0, 114, 255, 0.5);
            display: inline-block;
        }

        button:hover {
            background: linear-gradient(135deg, #0072ff, #00c6ff);
            transform: scale(1.05);
        }

        button:active {
            transform: scale(0.95);
        }
        #cross{
            cursor: pointer;
            width: 100px;
            height: fit-content;
            position: absolute;
            text-align: center;
            background-color: red;
            margin-left: 120px;
            text-decoration: solid;
         }
         #cross:hover{
            color: white;
            font-weight: bold;
            background: linear-gradient(135deg,rgb(120, 124, 129), #00c6ff);
            transform: scale(2.05);
         }
    </style>
</head>

<body>
    <div class="container">
        <div id="notifications">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <?php echo "<h2>Pending Notifications</h2>" ?>
                <div class="notification">
                    New Signup:
                    <span> <?php echo htmlspecialchars($row['user_email']); ?></span>
                    <div class="buttons">
                        <button class="btn approve" onclick="approveUser('<?php echo htmlspecialchars($row['user_email']); ?>')">✔</button>
                        <button class="btn reject" onclick="rejectUser('<?php echo htmlspecialchars($row['user_email']); ?>')">✖</button>
                    </div>
                </div>
            <?php } ?>
        </div>
        <div class="space"></div>
        <div class="add-event">
            <button class="add" id="add">ADD EVENT</button>
        </div>
        <div class="details-of-event" id="details-of-event" style="display:none">
            <form id="eventForm" method="post" enctype="multipart/form-data">
                <label for="event-name">Event Name</label>
                <input type="text" class="input-box" name="event-name" placeholder="Event" required>

                <label for="event-date">Date of event</label>
                <input type="date" class="input-box" name="event-date" required>

                <label for="location">Location</label>
                <input type="text" class="input-box" name="location" required>

                <label for="thumbnail">Thumbnail</label>
                <input type="file" class="input-box" name="thumbnail" accept="image/*" required>

                <button type="submit" id="submit" class="input-box">Submit</button>
            </form>
            <div id="cross" style="display: block;">✖</div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function approveUser(email) {
            fetch('approve_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `email=${encodeURIComponent(email)}`
                })
                .then(response => response.text())
                .then(result => {
                    console.log("Approval result:", result);
                    if (result.trim() === "approved") {
                        alert("User approved successfully!");
                        location.reload();
                    } else {
                        alert("Approval failed.");
                    }
                })
                .catch(error => console.error("Error approving user:", error));
        }

        function rejectUser(email) {
            fetch('reject_user.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `email=${encodeURIComponent(email)}`
                })
                .then(response => response.text())
                .then(result => {
                    console.log("Rejection result:", result);
                    if (result.trim() === "rejected") {
                        alert("User rejected successfully!");
                        location.reload();
                    } else {
                        alert("Rejection failed.");
                    }
                })
                .catch(error => console.error("Error rejecting user:", error));
        }
        const addbtn = document.getElementById("add");
        const formbox = document.getElementById("details-of-event");
        const submitbtn = document.getElementById("submit");
        const cross = document.getElementById("cross");
        cross.addEventListener("click", function() {
            formbox.style.display = "none";
            addbtn.style.display = "block";
        })
        
        addbtn.addEventListener("click", function() {
            formbox.style.display = "block";
            addbtn.style.display = "none";
        })
        //ajax for adding event
        $(document).ready(function() {
            $("#eventForm").on("submit", function(e) {
                e.preventDefault(); // Prevent default form submission

                var formData = new FormData(this); // Create form data object

                $.ajax({
                    url: "userhome.php", // PHP script to process the form
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert("Event added successfully!"); // Show success message
                        
            formbox.style.display = "none";
            addbtn.style.display = "block";
            location.reload();
                    },
                    error: function() {
                        alert("Error occurred while submitting."); // Show error message
                    }
                });
            });
        });
        
          
 
    </script>
</body>

</html>