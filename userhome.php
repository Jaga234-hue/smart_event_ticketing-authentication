<?php
require_once 'db_connect.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $event_name = $_POST['event-name'] ?? '';
    $event_date = $_POST['event-date'] ?? '';
    $location = $_POST['location'] ?? '';
    $organizer_id = 24577; // Fixed Organizer ID

    // Validate form data
    if (empty($event_name) || empty($event_date) || empty($location)) {
        die("All fields are required.");
    }

    // Generate unique Event_ID between 10000 and 99999
    do {
        $event_id = rand(10000, 99999);
        $check_stmt = $conn->prepare("SELECT Event_ID FROM event WHERE Event_ID = ?");
        $check_stmt->bind_param("i", $event_id);
        $check_stmt->execute();
        $check_stmt->store_result();
    } while ($check_stmt->num_rows > 0);
    $check_stmt->close();

    // Handling file upload
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $thumbnail_name = basename($_FILES['thumbnail']['name']);
        $thumbnail_tmp = $_FILES['thumbnail']['tmp_name'];
        $thumbnail_folder = 'thumbnail/' . $thumbnail_name;

        // Validate file type and size
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        $file_type = strtolower(pathinfo($thumbnail_name, PATHINFO_EXTENSION));
        if (!in_array($file_type, $allowed_types)) {
            die("Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.");
        }
        if ($_FILES['thumbnail']['size'] > 5000000) { // 5MB limit
            die("File size is too large. Maximum size allowed is 5MB.");
        }

        // Move uploaded file to the target folder
        if (move_uploaded_file($thumbnail_tmp, $thumbnail_folder)) {
            // Insert data into database
            $stmt = $conn->prepare("INSERT INTO event (Event_ID, Name, Date, Location, Organizer_ID) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("isssi", $event_id, $event_name, $event_date, $location, $organizer_id);

            if ($stmt->execute()) {
                echo ' ';
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Failed to upload thumbnail.";
        }
    } else {
        echo "No file uploaded or there was an error.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Page</title>
    <style>
        /* Global Styles */
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #e3e3e3;
            font-family: Arial, sans-serif;
        }

        .container {
            width: 500px;
            height: 100vh;
            background-color: white;
            position: relative;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        /* Top Bar */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #fff;
            position: relative;
            z-index: 10;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }

        .menu {
            font-size: 24px;
            cursor: pointer;
            padding: 5px 10px;
            background: black;
            color: white;
            border-radius: 5px;
            position: relative;
        }

        .menu-options {
            display: none;
            position: absolute;
            top: 50px;
            left: 10px;
            background: white;
            border-radius: 5px;
            width: 160px;
            z-index: 20;
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
        }

        .menu-options div {
            padding: 12px;
            cursor: pointer;
            border-bottom: 1px solid #ddd;
        }

        .menu-options div:hover {
            background: #007bff;
            color: white;
        }

        .profile {
            width: 50px;
            height: 50px;
            background: blue;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            font-weight: bold;
            cursor: pointer;
        }

        /* Flipkart-style Slider */
        .slider-container {
            width: 100%;
            height: 250px;
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            margin: 10px 0;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            height: 250px;
            background-size: cover;
            background-position: center;
        }

        .arrow {
            font-size: 30px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: white;
            background: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 50%;
            z-index: 10;
        }

        .left-arrow {
            left: 10px;
        }

        .right-arrow {
            right: 10px;
        }

        /* Search Bar */
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

        #eventPopup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: linear-gradient(135deg, #ff7e5f, #feb47b);
            /* Gradient background */
            padding: 25px;
            border-radius: 12px;
            width: fit-content;
            height: fit-content;
            text-align: center;
            color: white;
            font-family: "Syne", "Space Grotesk";
            font-size: 2.5rem;
            font-weight: bold;
            line-height: 1.5;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            animation: fadeIn 0.3s ease-in-out;
            border: none;
        }

        /* Smooth fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translate(-50%, -55%);
            }

            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        /* Close button styling */
        #eventPopup .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
            font-size: 22px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            width: 28px;
            height: 28px;
            line-height: 28px;
            text-align: center;
            transition: 0.3s;
        }

        #eventPopup .close-btn:hover {
            background: rgba(255, 255, 255, 0.4);
            color: #ff3b3b;
        }

        /* Inner text styles */
        #eventPopup .popup-content {
            margin-top: 10px;
            font-size: 17px;
            line-height: 1.5;
        }

        /* Optional: Add a subtle glow effect */
        #eventPopup::before {
            content: "";
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            z-index: -1;
            box-shadow: 0 0 20px rgba(255, 165, 0, 0.4);
        }

        .proceed {
            background: linear-gradient(45deg, #ff416c, #ff4b2b);
            color: white;
            font-size: 18px;
            font-weight: bold;
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(255, 75, 43, 0.4);
            transition: all 0.3s ease-in-out;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-left: 150px;
        }



        .proceed:hover {
            transform: scale(1.05);
            background: linear-gradient(45deg, #ff4b2b, #ff416c);
            box-shadow: 0 6px 20px rgba(255, 75, 43, 0.6);
        }

        .proceed span {
            transition: transform 0.3s ease;
        }

        .proceed:hover span {
            transform: translateX(5px);
        }

        .prfileDetails {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(0, 0, 0, 0.9);
            color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);
            display: none;
            width: 300px;
            text-align: center;
            z-index: 1000;
        }

        .prfileDetails h2 {
            margin-top: 0;
            font-size: 24px;
        }

        .close-profile {
            position: absolute;
            top: 10px;
            right: 15px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
            color: red;
        }

        .close-profile:hover {
            color: white;
        }

        .user-info {
            margin: 10px 0;
            font-size: 18px;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="top-bar">
            <div class="menu" onclick="toggleMenu()">☰</div>
            <div class="profile" id="profile">Profile</div>
        </div>
        <div class="prfileDetails" id="profileDetails" style="display: none;">
            <h2>Profile</h2>
            <h1 class="close-profile">X</h1>
            <?php
            if (isset($_COOKIE["user_id"]) && isset($_COOKIE["username"]) && isset($_COOKIE["email"]) && isset($_COOKIE["phone"])) {
                $user_id = $_COOKIE["user_id"];
                $username = $_COOKIE["username"];
                $email = $_COOKIE["email"];
                $phone = $_COOKIE["phone"];
            } else {
                echo "No user information found in cookies.";
            }
            ?>
            <p class="user-info"><strong>Name:</strong> <?php echo htmlspecialchars($username ?? ''); ?></p>
            <p class="user-info"><strong>User ID:</strong> <?php echo htmlspecialchars($user_id ?? ''); ?></p>
            <p class="user-info"><strong>Email:</strong> <?php echo htmlspecialchars($email ?? ''); ?></p>
            <p class="user-info"><strong>Phone:</strong> <?php echo htmlspecialchars($phone ?? ''); ?></p>


        </div>
        <div class="menu-options" id="menuOptions">
            <div>My Selected Event</div>
            <div>My QR Codes</div>
            <div>Settings</div>
        </div>
        <div class="slider-container">
            <div class="slider" id="slider">
                <div class="slide" style="background: red;"></div>
                <div class="slide" style="background: blue;"></div>
                <div class="slide" style="background: green;"></div>
            </div>
            <div class="arrow left-arrow" onclick="prevSlide()">⬅</div>
            <div class="arrow right-arrow" onclick="nextSlide()">➡</div>
        </div>
        <input type="text" class="search" id="searchInput" onkeyup="filterEvents()" placeholder="Search event with name or date">
        <div class="event-list" id="eventList">
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
            <!-- popup -->
            <!-- Popup Container -->
            <div id="eventPopup" style="display: none;">
                <h2 id="popupEventName"></h2>
                <p><strong>Date:</strong> <span id="popupEventDate"></span></p>
                <p><strong>Location:</strong> <span id="popupEventLocation"></span></p>
                <form id="eventForm" action="payment.php" method="POST">
                    <input type="hidden" name="eventName" id="eventNameInput">
                    <input type="hidden" name="eventDate" id="eventDateInput">
                    <input type="hidden" name="eventLocation" id="eventLocationInput">
                    <button class="proceed" id="proceedButton" type="submit">
                        Proceed <span>➡</span>
                    </button>
                    <button id="closePopup" class="close-btn">✖</button>
                </form>
            </div>
        </div>

        <!-- Overlay for the popup -->
        <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

    </div>



    </div>
    <script>
        let currentIndex = 0;
        const profileDetails = document.getElementById('profileDetails');
        const profile = document.getElementById('profile');
        const closeProfile = document.querySelector('.close-profile');
        const overlay = document.createElement('div');
        overlay.classList.add('overlay');
        document.body.appendChild(overlay);

        // Profile open and close functionality
        profile.addEventListener('click', () => {
            profileDetails.style.display = 'block';
            overlay.style.display = 'block';
        });

        closeProfile.addEventListener('click', closeOverlay);
        overlay.addEventListener('click', closeOverlay);

        function closeOverlay() {
            profileDetails.style.display = 'none';
            overlay.style.display = 'none';
        }

        // Slider functionality
        function nextSlide() {
            const slider = document.getElementById("slider");
            currentIndex = (currentIndex + 1) % 3;
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        function prevSlide() {
            const slider = document.getElementById("slider");
            currentIndex = (currentIndex - 1 + 3) % 3;
            slider.style.transform = `translateX(-${currentIndex * 100}%)`;
        }
        setInterval(nextSlide, 3000);

        // Toggle menu
        function toggleMenu() {
            const menu = document.getElementById("menuOptions");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }

        // Filter events
        function filterEvents() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const events = document.querySelectorAll(".event");
            events.forEach(event => {
                event.style.display = event.innerText.toLowerCase().includes(input) ? "flex" : "none";
            });
        }

        // Event selection popup functionality
        document.addEventListener('DOMContentLoaded', function() {
            const events = document.querySelectorAll('.event');
            const popup = document.getElementById('eventPopup');
            const overlay = document.getElementById('overlay');
            const popupEventName = document.getElementById('popupEventName');
            const popupEventDate = document.getElementById('popupEventDate');
            const popupEventLocation = document.getElementById('popupEventLocation');
            const closePopupButton = document.getElementById('closePopup');
            const eventNameInput = document.getElementById('eventNameInput');
            const eventDateInput = document.getElementById('eventDateInput');
            const eventLocationInput = document.getElementById('eventLocationInput');

            events.forEach(event => {
                event.addEventListener('click', function() {
                    const eventName = this.textContent;
                    const eventDate = this.getAttribute('data-date');
                    const eventLocation = this.getAttribute('data-location');

                    popupEventName.textContent = eventName;
                    popupEventDate.textContent = eventDate;
                    popupEventLocation.textContent = eventLocation;

                    eventNameInput.value = eventName;
                    eventDateInput.value = eventDate;
                    eventLocationInput.value = eventLocation;

                    popup.style.display = 'block';
                    overlay.style.display = 'block';
                });
            });

            closePopupButton.addEventListener('click', closePopup);
            overlay.addEventListener('click', closePopup);

            function closePopup() {
                 popup.style.display = 'none'; 
                overlay.style.display = 'none';
            }
        });

        // Payment method selection
        /* document.addEventListener('DOMContentLoaded', function() {
            document.getElementById("payment-method").addEventListener("change", function() {
                let onlinePaymentForm = document.getElementById("online-payment-form");
                onlinePaymentForm.style.display = this.value === "online" ? "block" : "none";
            });
        }); */
    </script>
</body>