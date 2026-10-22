
<?php
session_start();

require_once __DIR__ . "/includes/db.php";

// Redirect users who are already logged in
if (isset($_SESSION["user_id"], $_SESSION["role"])) {
    if ($_SESSION["role"] === "admin") {
        header("Location: admin/dashboard.php");
        exit;
    }

    if ($_SESSION["role"] === "client") {
        header("Location: client/dashboard.php");
        exit;
    }
}

$error = "";
$email = "";
$selected_role = "client";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $selected_role = $_POST["role"] ?? "client";

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (!in_array($selected_role, ["admin", "client"], true)) {
        $error = "Please select a valid account type.";
    } elseif ($password === "") {
        $error = "Please enter your password.";
    } else {
        try {
            $stmt = $pdo->prepare(
                "SELECT id, full_name, email, password, role
                 FROM users
                 WHERE email = ?
                 LIMIT 1"
            );

            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (
                $user &&
                $user["role"] === $selected_role &&
                password_verify($password, $user["password"])
            ) {
                session_regenerate_id(true);

                $_SESSION["user_id"] = $user["id"];
                $_SESSION["role"] = $user["role"];
                $_SESSION["full_name"] = $user["full_name"];
                $_SESSION["email"] = $user["email"];

                if ($user["role"] === "admin") {
                    header("Location: admin/dashboard.php");
                    exit;
                }

                header("Location: client/dashboard.php");
                exit;
            } else {
                $error = "Incorrect email, password, or account type.";
            }
        } catch (PDOException $e) {
            $error = "A database error occurred. Please check your users table and database connection.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login | Waste Management System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #e8f5e9, #f5f7fa);
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #198754;
        }

        .navbar-brand {
            color: #fff;
            font-weight: 700;
        }

        .navbar-brand:hover {
            color: #e9f7ef;
        }

        .login-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 35px 15px;
        }

        .login-card {
            width: 100%;
            max-width: 460px;
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.10);
        }

        .login-heading {
            background: #198754;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .login-heading .logo {
            font-size: 42px;
        }

        .login-heading h1 {
            font-size: 25px;
            font-weight: 700;
            margin: 8px 0;
        }

        .login-body {
            padding: 30px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control,
        .form-select {
            min-height: 46px;
        }

        .btn-login {
            min-height: 48px;
            background: #198754;
            border-color: #198754;
            color: #fff;
            font-weight: 600;
        }

        .btn-login:hover {
            background: #146c43;
            color: #fff;
        }

        footer {
            text-align: center;
            padding: 16px;
            color: #6c757d;
            font-size: 14px;
        }

        @media (max-width: 480px) {
            .login-body {
                padding: 22px 18px;
            }

            .login-heading h1 {
                font-size: 22px;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            🗑️ Waste Management System
        </a>
        <a href="register.php" class="btn btn-light btn-sm">
            Register
        </a>
    </div>
</nav>

<main class="login-wrapper">
    <div class="card login-card">

        <div class="login-heading">
            <div class="logo">♻️</div>
            <h1>Welcome Back!</h1>
            <p class="mb-0">Clean Nairobi Starts Here</p>
        </div>

        <div class="login-body">

            <h2 class="h4 text-center mb-4">Sign In to Your Account</h2>

            <?php if ($error !== ""): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="login.php">

                <div class="mb-3">
                    <label for="role" class="form-label">
                        Login as
                    </label>

                    <select
                        name="role"
                        id="role"
                        class="form-select"
                        required
                    >
                        <option value="client"
                            <?= $selected_role === "client" ? "selected" : "" ?>>
                            Client — Request Waste Collection
                        </option>

                        <option value="admin"
                            <?= $selected_role === "admin" ? "selected" : "" ?>>
                            Administrator — Manage the System
                        </option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        Email Address
                    </label>

                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="form-control"
                        placeholder="Enter your email"
                        value="<?= htmlspecialchars($email, ENT_QUOTES, "UTF-8") ?>"
                        autocomplete="username"
                        required
                    >
                </div>

                <div class="mb-4">
                    <label for="password" class="form-label">
                        Password
                    </label>

                    <input
                        type="password"
                        name="password"
                        id="password"
                        class="form-control"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-login w-100">
                    Login
                </button>

            </form>

            <hr class="my-4">

            <p class="text-center mb-2">
                Don't have an account?
                <a href="register.php" class="text-success fw-semibold">
                    Create an account
                </a>
            </p>

            <p class="text-center mb-0">
                <a href="index.php" class="text-decoration-none">
                    ← Back to Home
                </a>
            </p>

        </div>
    </div>
</main>

<footer>
    &copy; 2026 Waste Management System. Clean Nairobi Starts Here!
</footer>

</body>
</html>
