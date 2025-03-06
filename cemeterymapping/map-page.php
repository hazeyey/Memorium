<?php
include 'db.php';

// Fetch graves for visual representation
$sql = "SELECT g.grave_id, g.status, d.first_name, d.last_name
        FROM graves g
        LEFT JOIN deceased d ON g.grave_id = d.grave_id
        ORDER BY g.grave_id ASC";  
$result = $conn->query($sql);
$graves = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $graves[] = $row;
    }
}

// Fetch all deceased individuals
$sql = "SELECT d.deceased_id, d.first_name, d.last_name, d.birth_date, d.death_date, d.obituary, 
               g.grave_id, g.section, g.block_number, g.lot_number, g.status
        FROM deceased d
        LEFT JOIN graves g ON d.grave_id = g.grave_id
        ORDER BY g.grave_id ASC";
$result = $conn->query($sql);
$deceasedList = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $deceasedList[] = $row;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cemetery Map</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
       

    <link rel="stylesheet" href="css/mappage.css">    
</head>
<body>


 <!-- HEADER / NAVBAR -->
<header>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <nav class="navbar section-content">
        <a href="homepage.php" class="nav-logo">
        <img src="css/image/logo.png" alt="Logo" class="logo-icon">
            <h2 class="logo-text">Memorium</h2>
        </a>
        <ul class="nav-menu">    
            <button id="menu-close-button" class="fas fa-times"></button>

            <li class="nav-item">
                <a href="homepage.php#home" class="nav-link">Home</a>
            </li>
            
            <li class="nav-item">
                <a href="map-page.php" class="nav-link">Map</a>
            </li>
            <li class="nav-item">
                <a href="homepage.php#about" class="nav-link">About Us</a>
            </li>
            <li class="nav-item">
                <a href="homepage.php#contact" class="nav-link">Contact</a>
            </li>
            <li class="nav-item">
            <a href="admin/admin-login.php" class="nav-link admin-button">
                    <img src="css/image/admin.png" alt="Admin" class="admin-icon">
                </a>            
            </li>
        </ul>
        <button id="menu-open-button" class="fas fa-bars"></button>
    </nav>
</header>


<!-- MAP SECTION -->
<section id="map" class="map-section">
    <div class="section-content">
        <h2>Section A</h2>
        <div class="grid">
            <?php foreach ($graves as $grave): ?>
                <div class="grave <?php echo strtolower($grave['status']); ?>" 
                     onclick="alert('Grave ID: <?php echo $grave['grave_id']; ?>')" 
                     data-name="<?php echo strtolower(htmlspecialchars($grave['first_name'] . ' ' . $grave['last_name'])); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>



<!--LIST AND SEARCH SECTION -->
<section class="list-section">
    <h2>List of Deceased</h2>
    <p>Below is a list of all deceased individuals in the cemetery.</p>

    <!-- Search Input -->
    <input type="text" id="searchInput" placeholder="Search by name..." onkeyup="searchTable()">

    <table border="1" id="deceasedTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Birth Date</th>
                <th>Death Date</th>
                <th>Obituary</th>
                <th>Grave Location</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($deceasedList as $person): ?>
                <tr>
                    <td><?php echo $person['deceased_id']; ?></td>
                    <td><?php echo htmlspecialchars($person['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($person['last_name']); ?></td>
                    <td><?php echo $person['birth_date']; ?></td>
                    <td><?php echo $person['death_date']; ?></td>
                    <td><?php echo htmlspecialchars($person['obituary'] ?: 'N/A'); ?></td>
                    <td>Section <?php echo $person['section']; ?>, Block <?php echo $person['block_number']; ?>, Lot <?php echo $person['lot_number']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


<!-- FOOTER SECTION -->
<footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Memorium Cemetery Mapping. All rights reserved.</p>
            <p>Developed by <a href="https://github.com/hazeyey" target="_blank">Nazlah Nanding and Hazeljoy Hingpit</a></p>
            
    </footer>


<script src="searchTable.js"></script>    
<script src="script.js"></script>

</body>
</html>
