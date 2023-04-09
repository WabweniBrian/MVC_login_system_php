<header class=" bg-white border-bottom">
    <nav class="container d-flex justify-content-between align-items-center">
        <a href="index.php nav-brand">
            <h1>Home</h1>
        </a>
        <a href="/logout">Logout</a>
    </nav>
</header>
<div class="mt-5">
    <div class="container py-5 bg-white rounded shadow-sm border-1">
        <h1 class="text-center">Welcome, <?= $_SESSION['username'] ?> </h1>
        <h5 class="text-center">Your email addess: <?= $_SESSION['email'] ?> </h5>
    </div>
</div>