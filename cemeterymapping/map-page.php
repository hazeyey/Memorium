<?php
include 'db.php';



$sql = "SELECT g.grave_id, g.status, 
               COALESCE(d.first_name, '') AS first_name, 
               COALESCE(d.last_name, '') AS last_name,
               g.section, g.block_number, g.lot_number
        FROM graves g
        LEFT JOIN deceased d ON g.grave_id = d.grave_id 
            AND (d.deleted_at IS NULL OR d.deleted_at = '') 
        WHERE g.deleted_at IS NULL OR g.deleted_at = ''
        ORDER BY g.grave_id ASC";


$result = $conn->query($sql);
$graves = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $graves[] = $row;
    }
}

$sql = "SELECT d.deceased_id, d.first_name, d.last_name, d.birth_date, d.death_date, d.obituary, 
               g.grave_id, g.section, g.block_number, g.lot_number, g.status
        FROM deceased d
        LEFT JOIN graves g ON d.grave_id = g.grave_id
        WHERE d.deleted_at IS NULL AND g.deleted_at IS NULL
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
    <script src="searchTable.js" defer></script>
    <script src="script.js"></script>
   
   


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
                <?php
                // Find the matching deceased record based on grave_id
                $deceased = null;
                foreach ($deceasedList as $person) {
                    if ($person['grave_id'] == $grave['grave_id']) {
                        $deceased = $person;
                        break;
                    }
                }
                ?>
                <div class="grave <?php echo strtolower($grave['status']); ?>" 
                     onclick="openModal('<?php echo $grave['grave_id']; ?>', 
                                       '<?php echo htmlspecialchars($grave['first_name'] . ' ' . $grave['last_name']); ?>',
                                        '<?php echo htmlspecialchars($grave['section'] . '- Block ' . $grave['block_number'] . ' Lot ' . $grave['lot_number']); ?>', 
                                        '<?php echo $deceased ? htmlspecialchars($deceased['birth_date']) : ''; ?>', 
                                        '<?php echo $deceased ? htmlspecialchars($deceased['death_date']) : ''; ?>', 
                                        '<?php echo $deceased ? htmlspecialchars($deceased['obituary']) : ''; ?>')"
                     data-name="<?php echo strtolower(htmlspecialchars($grave['first_name'] . ' ' . $grave['last_name'])); ?>"
                     data-location="<?php echo strtolower(htmlspecialchars($grave['section'] . ' Block ' . $grave['block_number'] . ' Lot ' . $grave['lot_number'])); ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- GRAVE DETAILS MODAL -->
<div id="graveModal" class="modal">
    <div class="modal-content">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h2>Grave Details</h2>
        <p><strong>Name: </strong><span id="grave-name"></span></p>
        <p><strong>Location: </strong><span id="grave-location"></span></p>
       
        <p><strong>Date of Birth: </strong><span id="grave-dob"></span></p>
        <p><strong>Date of Death: </strong><span id="grave-dod"></span></p>
        <p><strong>Inscriptions: </strong><span id="grave-inscription"></span></p>
    </div>
</div>









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
            <p>&copy; 2024 Memorium Cemetery Mapping. All rights reserved.</p>
            <p>Developed by <a href="https://github.com/yourprofile" target="_blank">Nazlah Nanding and Hazeljoy Hingpit</a></p>
            <div class="social-links">
                <a href="https://facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
        </div>
    </footer>


<script>
// Open modal with grave details
function openModal(graveId, name, location, dob, dod, inscription) {
    
    document.getElementById('grave-name').innerText = name;
    document.getElementById('grave-location').innerText = location;
    document.getElementById('grave-dob').innerText = dob;
    document.getElementById('grave-dod').innerText = dod;
    document.getElementById('grave-inscription').innerText = inscription;
    document.getElementById('graveModal').style.display = 'block';
}

// Close modal
function closeModal() {
    document.getElementById('graveModal').style.display = 'none';
}

// Close modal when clicking outside the modal content
window.onclick = function(event) {
    if (event.target == document.getElementById('graveModal')) {
        closeModal();
    }
}

</script>



</body>
</html>
