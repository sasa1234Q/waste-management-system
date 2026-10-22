
<?php
session_start();
require_once __DIR__ . "/includes/db.php";

$message = "";
$messageType = "danger";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST["full_name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm_password = $_POST["confirm_password"] ?? "";
    $role = $_POST["role"] ?? "client";

    if ($full_name === "" || !filter_var($email, FILTER_VALIDATE_EMAIL)
        || $password === "" || $confirm_password === "") {
        $message = "Please fill in all required fields with valid information.";
    } elseif (!in_array($role, ["client", "admin"], true)) {
        $message = "Please select a valid account type.";
    } elseif ($password !== $confirm_password) {
        $message = "The passwords do not match.";
    } elseif (strlen($password) < 8) {
        $message = "Your password must contain at least 8 characters.";
    } elseif ($role === "admin" && ($_SESSION["role"] ?? "") !== "admin") {
        $message = "Administrator accounts can only be created by an existing administrator. Please register as a client or contact the system administrator.";
    } else {
        try {
            $check = $pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
            $check->execute([$email]);

            if ($check->fetch()) {
                $message = "An account with this email already exists. Please log in.";
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    "INSERT INTO users (full_name, email, phone, password, role)
                     VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->execute([
                    $full_name,
                    $email,
                    $phone,
                    $hashedPassword,
                    $role
                ]);

                $messageType = "success";
                $message = "Registration successful! You can now log in.";
            }
        } catch (PDOException $e) {
            $message = "Registration could not be completed. Check that your users table has the required columns.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register | Waste Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f1f5f2;
            display: flex;
            align-items: center;
            padding: 24px 0;
        }
        .register-card {
            max-width: 520px;
            width: 100%;
            margin: auto;
            border: 0;
            border-radius: 16px;
            box-shadow: 0 8px 28px rgba(0,0,0,.09);
        }
        .brand { color: #198754; font-weight: 700; }
    </style>
</head>
<body>
<div class="container px-3">
    <div class="card register-card">
        <div class="card-body p-4 p-md-5">
            <h2 class="brand text-center mb-2">🗑️ Waste Management</h2>
            <h4 class="text-center mb-4">Create an Account</h4>

            <?php if ($message !== ""): ?>
                <div class="alert alert-<?= htmlspecialchars($messageType) ?>">
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="register.php">
                <div class="mb-3">
                    <label for="full_name" class="form-label">Full name *</label>
                    <input type="text" class="form-control" id="full_name"
                           name="full_name" required
                           value="<?= htmlspecialchars($_POST["full_name"] ?? "") ?>">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address *</label>
                    <input type="email" class="form-control" id="email"
                           name="email" required
                           value="<?= htmlspecialchars($_POST["email"] ?? "") ?>">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone number</label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                           value="<?= htmlspecialchars($_POST["phone"] ?? "") ?>">
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">Registering as *</label>
                    <select class="form-select" id="role" name="role" required>
                        <option value="client"
                            <?= ($_POST["role"] ?? "client") === "client" ? "selected" : "" ?>>
                            Client — request waste collection
                        </option>
                        <option value="admin"
                            <?= ($_POST["role"] ?? "") === "admin" ? "selected" : "" ?>>
                            Administrator — restricted registration
                        </option>
                    </select>
                    <div class="form-text">
                        Administrator accounts can only be created by an existing administrator.
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" class="form-control" id="password"
                           name="password" minlength="8" required>
                    <div class="form-text">Use at least 8 characters.</div>
                </div>

                <div class="mb-4">
                    <label for="confirm_password" class="form-label">Confirm password *</label>
                    <input type="password" class="form-control" id="confirm_password"
                           name="confirm_password" minlength="8" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    Create Account
                </button>
            </form>

            <p class="text-center mt-4 mb-0">
                Already have an account?
                <a href="login.php">Log in</a>
            </p>
            <p class="text-center mt-2 mb-0">
                <a href="index.php">Back to Home</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
