<!-- Sidebar -->
<div class="sidebar">
        <div class="logo-details">
            <div class="logo_name">Memorium</div>
            <i class='bx bx-menu' id="btn"></i>
        </div>
        <ul class="nav-list">

        <li>
    <a href="#" data-section="dashboard">
        <i class='bx bxs-dashboard'></i>
        <span class="links_name">Dashboard</span>
    </a>
    <span class="tooltip">Dashboard</span>
</li>
<li>
    <a href="#" data-section="grave">
        <i class='bx bxs-folder-plus'></i>
        <span class="links_name">Grave</span>
    </a>
    <span class="tooltip">Grave</span>
</li>
<li>
    <a href="#" data-section="deceased">
        <i class='bx bxs-folder-open'></i>
        <span class="links_name">Deceased</span>
    </a>
    <span class="tooltip">Deceased</span>
</li>


<li>
<a href="../index.php">
    <i class='bx bx-transfer-alt'></i>
        <span class="links_name">Website</span>
    </a>
    <span class="tooltip">Website</span>
</li>



            

            <!-- Profile -->
            <li class="profile">
                <div class="profile-details">
                    <img src="css/image/profile.png" alt="profileImg">
                    <div class="name_job">
                        <div class="name">Memorium</div>
                        <div class="job">Cemetery Find</div>
                    </div>
                </div>
                <i class='bx bx-log-out' id="log_out" style="cursor: pointer;" onclick="logoutUser()"></i>

                <script>
                function logoutUser() {
                    localStorage.clear();
                    sessionStorage.clear();
                    window.location.href = "login.html";
                }
                </script>

            </li>
        </ul>
    </div>