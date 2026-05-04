<?php
include "header.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>للأسف، الموقع لم يعد صالحًا للاستخدام</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6b7280, #1f2937);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Tajawal', sans-serif;
        }
        .container {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            text-align: center;
        }
        .badbot-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1.5rem;
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1.2rem;
            color: #4b5563;
            margin-bottom: 2rem;
        }
        .btn-support {
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-support:hover {
            background: #6366f1;
        }
    </style>
</head>
<body>
    <div class="container">
        <i class="fas fa-user-secret badbot-icon"></i>
        <h1>للأسف، الموقع لم يعد صالحًا للاستخدام</h1>
        <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-support" target="_blank">
            <i class="fas fa-envelope"></i> تواصل مع الدعم
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include "footer.php";
?>