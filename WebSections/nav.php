<nav>
    <a href="#"><img src="./Images\Debidwar Diabetes & Diagnostic Center.png" alt=""></a>

    <ul class="nav-menu">
        <li><a href="#" class="nav-link active" onclick="setActiveClass(this)">Home</a></li>
        <li><a href="#about" class="nav-link" onclick="setActiveClass(this)">About</a></li>
        <li><a href="#services" class="nav-link" onclick="setActiveClass(this)">Services</a></li>
        <li><a href="#doctorlist" class="nav-link" onclick="setActiveClass(this)">Doctors</a></li>
        <li><a href="#contact" class="nav-link" onclick="setActiveClass(this)">Contact</a></li>
        <li><a href="Modules\Account\login.php"><button class="login-btn">Login</button></a></li>
    </ul>

    <script>
        function setActiveClass(element) {
            var links = document.querySelectorAll('.nav-link');
            links.forEach(function(link) {
                link.classList.remove('active');
            });
            element.classList.add('active');
        }

        window.addEventListener("scroll", function(){
            var nav = document.querySelector("nav");
            nav.classList.toggle("sticky", window.scrollY > 0);
        })
    </script>
</nav>