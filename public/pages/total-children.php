<?php
session_start();
require __DIR__ . '/../../config/database.php';
require __DIR__ . '/../partials/header.php';


?>

<body>
    <?php #require __DIR__ . '/../partials/sidebar.php'; 
    ?>
    <main>
        <div class="container">
            <div class="row">
                <div class="col-4 col-md-4 col-xl-3">
                    <div class="card" onclick="loadContent('total-children.php')">
                        <div class="avatar-container">
                            <img src="../img/avatar.jpg" alt="avatar" class="avatar">
                        </div>
                    </div>
                    <p class="text-center mt-3 fs-4 bold">Engr. Ahmad Checko</pc>
                </div>
                <div class="col-8 col-md-8 col-xl-9">
                    <div class="row mb-3">
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="title">Children</p>
                                    <h2 class="number">3</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="title">Children</p>
                                    <h2 class="number">3</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="title">Children</p>
                                    <h2 class="number">3</h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <p class="title">Children</p>
                                    <h2 class="number">3</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-3">
                <a href="" class="btn button">View Details</a>
            </div>
        </div>
    </main>
    <footer>
        <a href="../../index.php" class="text-center mt-4">Home</a>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function loadContent(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = page
                    console.log(xhr.responseText);
                }
            };
            xhr.send();
        }
    </script>
    <script>
        $(document).ready(function() {

            //toggle menu
            $('.hamburger-container').click(function() {
                $('#menu').slideToggle();
            });

            //to fix issue that toggle adds style(hides) to nav
            $(window).resize(function() {
                if (window.innerWidth > 1024) {
                    $('#menu').removeAttr('style');
                }
            });

            //icon animation
            var topBar = $('.hamburger li:nth-child(1)'),
                middleBar = $('.hamburger li:nth-child(2)'),
                bottomBar = $('.hamburger li:nth-child(3)');

            $('.hamburger-container').on('click', function() {
                if (middleBar.hasClass('rot-45deg')) {
                    topBar.removeClass('rot45deg');
                    middleBar.removeClass('rot-45deg');
                    bottomBar.removeClass('hidden');
                } else {
                    bottomBar.addClass('hidden');
                    topBar.addClass('rot45deg');
                    middleBar.addClass('rot-45deg');
                }
            });

        });
    </script>
</body>

</html>