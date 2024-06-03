<section id="doctorlist">
    <h1 id="doctorlist-title">Meet Our Doctors</h1>

    <div class="doctorlist-container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                    include("./Includes\config.php");

                    $query = "SELECT * FROM doctor";
                    $result = mysqli_query($conn, $query);

                    if(mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {

                            $firstName = $row['firstName'];
                            $lastName = $row['lastName'];
                            $image = $row['image'];
                            $specialization = $row['specialization'];

                            $doctorName = $firstName . ' ' . $lastName;

                            echo '<div class="swiper-slide">';
                            echo '<img src="./Modules/Uploaded/Doctor/' . $image . '" alt="">';
                            echo '<div class="doctor-content">';
                            echo '<h1>' . $doctorName . '</h1>';
                            echo '<h3>Specialization: ' . $specialization . '</h3>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo 'No doctors found in the database.';
                    }
                ?>
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script>
        var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        });
    </script>
</section>