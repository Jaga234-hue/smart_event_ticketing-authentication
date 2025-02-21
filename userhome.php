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
        .left-arrow { left: 10px; }
        .right-arrow { right: 10px; }

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
    </style>
</head>
<body>
    <div class="container">
        <div class="top-bar">
            <div class="menu" onclick="toggleMenu()">☰</div>
            <div class="profile">P</div>
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
            <div class="event">Event no 1</div>
            <div class="event">Event no 2</div>
            <div class="event">Event no 3</div>
        </div>
    </div>
    <script>
        let currentIndex = 0;
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
        function toggleMenu() {
            const menu = document.getElementById("menuOptions");
            menu.style.display = menu.style.display === "block" ? "none" : "block";
        }
        function filterEvents() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const events = document.querySelectorAll(".event");
            events.forEach(event => {
                event.style.display = event.innerText.toLowerCase().includes(input) ? "flex" : "none";
            });
        }
    </script>
</body>
</html>
