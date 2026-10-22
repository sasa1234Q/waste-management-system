
<?php
require_once __DIR__ . "/includes/db.php";

$stmt = $pdo->query(
    "SELECT * FROM services WHERE status = 'active' ORDER BY id ASC"
);
$services = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Management System | Clean Nairobi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-success sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">
            🗑️ Waste Management
        </a>

        <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link" href="#services">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact</a>
                </li>
                <li class="nav-item ms-lg-3">
                    <a class="btn btn-light text-success fw-bold"
                       href="login.php">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <span class="badge bg-success mb-3">
                A Cleaner, Greener Nairobi
            </span>

            <h1>Clean Nairobi<br>Starts Here</h1>

            <p>
                Smart waste collection, recycling, and management
                for a sustainable future.
            </p>

            <a href="#services" class="btn btn-success btn-lg me-2">
                Explore Services
            </a>

            <a href="register.php" class="btn btn-outline-success btn-lg">
                Get Started
            </a>
        </div>
    </div>
</section>

<section id="services" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title">Our Services</h2>
            <p class="text-muted">
                Reliable and environmentally responsible waste solutions.
            </p>
        </div>

        <div class="row g-4">
            <?php if (count($services) > 0): ?>
                <?php foreach ($services as $service): ?>
                    <div class="col-md-4">
                        <div class="card service-card h-100">
                            <div class="card-body p-4">
                                <div class="service-icon">♻️</div>

                                <h4 class="mt-3">
                                    <?= htmlspecialchars($service["name"]) ?>
                                </h4>

                                <p class="text-muted">
                                    <?= htmlspecialchars($service["description"]) ?>
                                </p>

                                <p class="price">
                                    KSh <?= number_format((float)$service["price"], 2) ?>
                                </p>

                                <a href="register.php"
                                   class="btn btn-outline-success">
                                    Request Service
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p>No services are currently available.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section id="about" class="about-section py-5">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <h2 class="section-title">About Our Mission</h2>
                <p>
                    We aim to make waste collection easier, cleaner,
                    and more reliable for households and businesses.
                </p>
                <p>
                    Our platform helps clients request waste collection,
                    access recycling services, and follow the progress
                    of their requests.
                </p>
                <a href="register.php" class="btn btn-success">
                    Join Our Community
                </a>
            </div>

            <div class="col-md-6">
                <div class="about-box">
                    <h3>Building a Cleaner Future</h3>
                    <p>
                        Responsible disposal starts with all of us.
                        Together, we can reduce pollution and encourage
                        recycling across Nairobi.
                    </p>
                    <div class="row text-center mt-4">
                        <div class="col-6">
                            <h4>♻️</h4>
                            <p>Eco-conscious</p>
                        </div>
                        <div class="col-6">
                            <h4>🏠</h4>
                            <p>Community-focused</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="py-5">
    <div class="container text-center">
        <h2 class="section-title">Contact Us</h2>
        <p class="text-muted">
            Have a question or need waste collection? Get in touch.
        </p>
        <p><strong>Email:</strong> info@wastemanagement.co.ke</p>
        <p><strong>Location:</strong> Nairobi, Kenya</p>
        <p><strong>Phone:</strong> +254 700 123 456</p>
        <p class="small text-muted">
            Replace these sample contact details with your verified details
            before publishing the website.
        </p>
    </div>
</section>

<footer class="bg-dark text-white text-center py-3">
    <p class="mb-0">
        &copy; 2026 Waste Management System. Building a cleaner Nairobi.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
