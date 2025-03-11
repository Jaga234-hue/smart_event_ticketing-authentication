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
            overflow-x: hidden;
            /* Hide horizontal scrollbar */
            overflow: auto !important;
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

        #cross {
            cursor: pointer;
            width: 100px;
            height: fit-content;
            position: absolute;
            text-align: center;
            background-color: red;
            margin-left: 120px;
            text-decoration: solid;
        }

        #cross:hover {
            color: white;
            font-weight: bold;
            background: linear-gradient(135deg, rgb(120, 124, 129), #00c6ff);
            transform: scale(2.05);
        }

        /* Event List */
        .event-list {
            background: black;
            padding: 15px;
            border-radius: 10px;
            color: white;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
        }

        .event {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: rgba(255, 255, 255, 0.1);
            margin: 8px 0;
            border-radius: 5px;
            transition: transform 0.2s ease-in-out;
            cursor: pointer;
        }

        .event:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.3);
        }

        .search {
            width: 90%;
            padding: 12px;
            margin: 15px auto;
            display: block;
            border: 2px solid #007bff;
            border-radius: 5px;
            text-align: center;
            font-size: 16px;
        }

        /* Verified List */
        .verified-list {
            position: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.9);
            /* Dark theme */
            color: white;
            /* Text color */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            text-align: center;
            display: none;
            /* Initially hidden */
            z-index: 1000;
            max-height: 80vh;
            /* Limits height to 80% of the viewport */
            overflow-y: auto;
            /* Enables vertical scrolling */
        }
        #popupcls {
    position: fixed; /* Fix it independently */
    bottom: 20px; /* Distance from bottom */
    right: 20px; /* Adjust as needed */
    background-color: #ff5722;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    z-index: 1100; /* Ensure it's above .verified-list */
    overflow: hidden;
}

        .verified-list h3 {
            color:rgb(186, 193, 201);
            font-size: 26px;
            font-weight: 600;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 3px solid #3498db;
        }

        .verified-list table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 30px;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .verified-list table th,
        .verified-list table td {
            padding: 15px 20px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .verified-list table th {
            background-color: #3498db;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .verified-list table td {
            color: #555;
        }

        .verified-list table tr:last-child td {
            border-bottom: none;
        }

        .verified-list table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .verified-list table tr:hover {
            background-color: #f1f8ff;
            transition: background-color 0.3s ease;
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
    <input type="text" class="search" id="searchInput" onkeyup="filterEvents()" placeholder="Search event with name or date">
    <div class="evens-list" id="events">
        <?php
        $sql = "SELECT Event_ID, Name, Date, Location FROM event";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="event" data-id="' . htmlspecialchars($row['Event_ID']) . '" data-date="' . htmlspecialchars($row['Date']) . '" data-location="' . htmlspecialchars($row['Location']) . '">' . htmlspecialchars($row['Name']) . '</div>';
            }
        } else {
            echo "<div class='event'>No events found</div>";
        }
        ?>
    </div>
    <div class="total_verified" id="total_verified">
        
        <button class="detailBtn" id="detailBtn" onclick="showList()"> Details </button>
    </div>
    <button id="popupcls" style="display: none;"> <-- GO BACK </button>
    <div class="verified-list" id="verified-list" style="display: none;">
        <?php
        // Assuming the database connection is already established

        // Query to select name, eventname, and datetime where status is 'successful'
        $query = "SELECT Name, Event_name, datetime FROM authentication WHERE status = 'successful'";
        $result = mysqli_query($conn, $query); // Replace $connection with your actual connection variable

        // Array to hold events and their corresponding data
        $events = [];

        // Fetch data and organize by event name
        while ($row = mysqli_fetch_assoc($result)) {
            $eventName = $row['Event_name'];
            if (!isset($events[$eventName])) {
                $events[$eventName] = [];
            }
            $events[$eventName][] = $row;
        }

        // Generate a table for each event
        foreach ($events as $eventName => $attendees) {
            echo "<h3>Event: $eventName</h3>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th><th>Date Time</th></tr>";
            foreach ($attendees as $attendee) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($attendee['Name']) . "</td>";
                echo "<td>" . htmlspecialchars($attendee['datetime']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
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
        //search event functionality
        function filterEvents() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const events = document.querySelectorAll(".event");
            events.forEach(event => {
                event.style.display = event.innerText.toLowerCase().includes(input) ? "flex" : "none";
            });
        }
        //list shown
        const cls = document.getElementById("popupcls");
        function showList() {
            const list = document.getElementById("verified-list");
            if (list.style.display === "none") {
                list.style.display = "block";
                cls.style.display = "block";
            } else {
                list.style.display = "none";
            }
        }
        cls.addEventListener("click", function() {
            const list = document.getElementById("verified-list");
            list.style.display = "none";
            cls.style.display = "none";

        })
        /* document.body.style.overflow = "hidden"; // REMOVE or CHANGE THIS if applied */
    </script>
</body>

</html>