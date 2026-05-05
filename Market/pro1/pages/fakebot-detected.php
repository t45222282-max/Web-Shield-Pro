<?php
include "header.php";
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الموقع تحت الصيانة</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- Tajawal Font -->
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6b7280, #1f2937);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
            margin: 0;
            font-family: 'Tajawal', sans-serif;
            transition: background 0.5s;
        }
        body.dark-mode {
            background: linear-gradient(135deg, #1a1a1a, #2c3e50);
        }
        .maintenance-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeInUp 0.6s ease-out;
        }
        .dark-mode .maintenance-container {
            background: rgba(30, 30, 30, 0.95);
            color: #e5e7eb;
        }
        .maintenance-container h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
        }
        .dark-mode .maintenance-container h1 {
            color: #e5e7eb;
        }
        .maintenance-container p {
            font-size: 1.2rem;
            color: #4b5563;
            margin-bottom: 2rem;
        }
        .dark-mode .maintenance-container p {
            color: #d1d5db;
        }
        .maintenance-icon {
            font-size: 5rem;
            color: #4f46e5;
            margin-current: 1.5rem;
            animation: pulse 2s infinite;
        }
        .btn-support {
            background: #4f46e5;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 0.8rem 2rem;
            font-weight: 500;
            transition: transform 0.2s, background 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-support:hover {
            background: #6366f1;
            transform: translateY(-2px);
        }
        .toggle-theme {
            position: fixed;
            top: 20px;
            left: 20px;
            cursor: pointer;
            font-size: 1.5rem;
            color: #fff;
            z-index: 1000;
        }
        .background-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            overflow: hidden;
        }
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 15s infinite;
        }
        .shape:nth-child(1) {
            width: 200px;
            height: 200px;
            top: 10%;
            right: 15%;
        }
        .shape:nth-child(2) {
            width: 150px;
            height: 150px;
            top: 60%;
            left: 20%;
            animation-delay: 5s;
        }
        @keyframes float {
            0% { transform: translateY(0); }
            50% { transform: translateY(-50px); }
            100% { transform: translateY(0); }
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <!-- Background Shapes -->
    <div class="background-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <!-- Theme Toggle -->
    <i class="fas fa-moon toggle-theme" id="themeToggle"></i>

    <!-- Maintenance Container -->
    <div class="maintenance-container">
        <i class="fas fa-tools maintenance-icon"></i>
        <h1>الموقع تحت الصيانة</h1>
        <p>نعتذر عن الإزعاج، الموقع خارج الخدمة حاليًا بسبب أعمال الصيانة. يرجى المحاولة لاحقاً.</p>
        <a href="mailto:<?php echo $settings['email']; ?>" class="btn btn-support" target="_blank">
            <i class="fas fa-envelope"></i> تواصل مع الدعم
        </a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Theme Toggle
        const themeToggle = document.getElementById('themeToggle');
        themeToggle.addEventListener('click', () => {
            document.body.classList.toggle('dark-mode');
            themeToggle.classList.toggle('fa-moon');
            themeToggle.classList.toggle('fa-sun');
        });
    </script>
</body>
</html>