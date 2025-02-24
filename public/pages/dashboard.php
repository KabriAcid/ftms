<?php
session_start();
require __DIR__ . '/../partials/header.php';
?>
<body>
    <?php #require __DIR__ . '/../partials/sidebar.php'; 
    ?>
    <main>
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6 col-xl-6 mb-3 mb-md-0">
                    <div class="card" onclick="loadContent('total-children.php')">
                        <div class="card-header">
                            <h3>Total children</h3>
                        </div>
                        <div class="card-body">
                            <p><i class="fa fa-child fa-2x"></i></p>
                            <h2>31</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="card" onclick="loadContent('late-children.php')">
                        <div class="card-header">
                            <h3>Late children</h3>
                        </div>
                        <div class="card-body">
                            <p><i class="fa fa-clock-o fa-2x"></i></p>
                            <h2>4</h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6 col-xl-6 mb-3 mb-md-0">
                    <div class="card" onclick="loadContent('males.php')">
                        <div class="card-header">
                            <h3>Males</h3>
                        </div>
                        <div class="card-body">
                            <p><i class="fa fa-male fa-2x"></i></p>
                            <h2>25</h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-xl-6">
                    <div class="card" onclick="loadContent('females.php')">
                        <div class="card-header">
                            <h3>Females</h3>
                        </div>
                        <div class="card-body">
                            <p><i class="fa fa-female fa-2x"></i></p>
                            <h2>6</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="content"></div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function loadContent(page) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', page, true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = page
                    document.getElementById('content').innerHTML = xhr.responseText;
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