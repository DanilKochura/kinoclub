<div class="container-fluid forum-card">
    <footer class="my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="/" class="nav-link px-2 text-muted">Главная</a></li>
            <li class="nav-item"><a href="/news.php" class="nav-link px-2 text-muted">Новости</a></li>
            <li class="nav-item"><a href="/feedback.php" class="nav-link px-2 text-muted">Форум</a></li>
            <li class="nav-item"><a href="/statistics.php" class="nav-link px-2 text-muted">Аналитика</a></li>
        </ul>
        <p class="text-center text-muted">© 2022 IMDBil</p>
    </footer>
</div>
 <script src="<?=ROOT?>/scripts/bootstrap.bundle.min.js"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
 <?php if($routed_file=='profile.php'): ?>
     <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
 <?php endif; ?>
 <script src="<?=ROOT?>/scripts/main.js"></script>

  </body>
</html>