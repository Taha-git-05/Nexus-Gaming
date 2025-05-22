<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.html');
    exit;
}

// Include config
require_once 'login_config.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NexusGaming - Ultimate Gaming Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="favicon-32x32.png" type="image/x-icon">
    <style>
        :root {
            --primary: #00ff00;
            /* Neon green */
            --secondary: #33e333;
            --dark: #000000;
            --light: #f5f5f5;
            --accent: #00ff88;
            --card-bg: #121212;

        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Rajdhani', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        @import url('https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;600;700&display=swap');

        body {
            background-color: var(--dark);
            color: var(--light);
            overflow-x: hidden;
        }

        /* Navigation */
        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            background-color: rgba(0, 0, 0, 0.9);
            backdrop-filter: blur(10px);
            position: fixed;
            width: 100%;
            z-index: 100;
            border-bottom: 1px solid var(--primary);
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.3);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary);
            text-decoration: none;
            text-shadow: var(--text-glow);
            letter-spacing: 1px;
        }

        .logo span {
            color: var(--accent);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--light);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .nav-links a:hover {
            color: var(--primary);
            text-shadow: var(--text-glow);
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
        }

        .btn {
            padding: 0.6rem 1.5rem;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        .btn-login {
            background: transparent;
            border: 2px solid var(--primary);
            color: var(--primary);
        }

        .btn-signup {
            background: linear-gradient(to right, var(--primary), var(--accent));
            border: none;
            color: var(--dark);
            font-weight: 700;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0, 255, 0, 0.5);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            background:
                linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.9)),
                url('https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80') no-repeat center center/cover;
        }

        .hero-content {
            max-width: 700px;
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(to right, var(--primary), var(--accent));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            line-height: 1.2;
            text-shadow: 0 0 10px rgba(0, 255, 0, 0.5);
            letter-spacing: 2px;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            line-height: 1.6;
            color: #cccccc;
        }

        .hero-buttons {
            display: flex;
            gap: 1.5rem;
        }

        .btn-explore {
            background: var(--primary);
            color: var(--dark);
            padding: 1rem 2.5rem;
            font-size: 1.1rem;
            border: none;
            border-radius: 30px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-explore:hover {
            box-shadow: 0 0 20px var(--primary);
        }

        /* Games Section */
        .games-section {
            padding: 7rem 5%;
            background: radial-gradient(circle at center, #0a0a0a 0%, #000000 100%);
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            position: relative;
            display: inline-block;
            color: var(--primary);
            text-shadow: var(--text-glow);
            letter-spacing: 2px;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 70px;
            height: 4px;
            background: linear-gradient(to right, var(--primary), var(--accent));
            box-shadow: 0 0 10px var(--primary);
        }

        .view-all {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .view-all:hover {
            text-shadow: var(--text-glow);
        }

        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2.5rem;
        }

        .game-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 255, 0, 0.2);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }

        .game-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 255, 0, 0.2);
            border: 1px solid var(--primary);
        }

        .game-image {
            height: 200px;
            width: 100%;
            object-fit: cover;
            border-bottom: 2px solid var(--primary);
        }

        .game-info {
            padding: 1.8rem;
        }

        .game-title {
            font-size: 1.4rem;
            margin-bottom: 0.8rem;
            color: var(--light);
            font-weight: 600;
        }

        .game-genre {
            color: var(--secondary);
            font-size: 1rem;
            margin-bottom: 1.2rem;
            display: block;
            font-weight: 500;
        }

        .game-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .game-price {
            font-weight: 700;
            color: var(--accent);
            font-size: 1.2rem;
        }

        .game-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #f1c40f;
            font-weight: 600;
        }

        .game-btn {
            background: linear-gradient(to right, var(--primary), var(--accent));
            border: none;
            color: var(--dark);
            font-weight: 700;
            padding: 0.5rem 0.5rem;
            border-radius: 30px;

            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 1px;
        }

        /* Categories Section */
        .categories {
            padding: 0 5% 7rem;
            background: radial-gradient(circle at center, #0a0a0a 0%, #000000 100%);
        }

        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 2rem;
        }

        .category-card {
            background-color: var(--card-bg);
            border-radius: 15px;
            padding: 2rem 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 255, 0, 0.1);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .category-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 255, 0, 0.2);
            border: 1px solid var(--primary);
            background: linear-gradient(135deg, rgba(0, 255, 0, 0.05), rgba(0, 206, 201, 0.05));
        }

        .category-icon {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            color: var(--primary);
            text-shadow: 0 0 10px var(--primary);
        }

        .category-card h3 {
            color: var(--light);
            font-size: 1.3rem;
            font-weight: 600;
        }

        /* Footer */
        footer {
            background-color: #000000;
            padding: 4rem 5% 2rem;
            border-top: 1px solid var(--primary);
            box-shadow: 0 0 20px rgba(0, 255, 0, 0.1);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-column h3 {
            color: var(--primary);
            margin-bottom: 1.8rem;
            font-size: 1.4rem;
            text-shadow: 0 0 5px var(--primary);
            letter-spacing: 1px;
        }

        .footer-column p {
            color: #aaaaaa;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .footer-column ul {
            list-style: none;
        }

        .footer-column ul li {
            margin-bottom: 1rem;
        }

        .footer-column ul li a {
            color: #cccccc;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .footer-column ul li a:hover {
            color: var(--primary);
            text-shadow: var(--text-glow);
            padding-left: 5px;
        }

        .social-links {
            display: flex;
            gap: 1.2rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background-color: var(--card-bg);
            border-radius: 50%;
            color: var(--light);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 255, 0, 0.3);
            font-size: 1.2rem;
        }

        .social-links a:hover {
            background: linear-gradient(to right, var(--primary), var(--accent));
            transform: translateY(-5px);
            color: var(--dark);
            box-shadow: 0 0 15px var(--primary);
        }

        .copyright {
            text-align: center;
            padding-top: 3rem;
            border-top: 1px solid rgba(0, 255, 0, 0.2);
            color: #777777;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }

        /* Sidebar Navigation */
        .sidebar {
            height: 100vh;
            width: 300px;
            position: fixed;
            top: 0;
            right: -300px;
            background-color: rgba(10, 10, 10, 0.98);
            backdrop-filter: blur(10px);
            overflow-x: hidden;
            transition: right 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 1000;
            border-left: 2px solid var(--primary);
            box-shadow: -5px 0 30px rgba(0, 255, 0, 0.2);
            display: flex;
            flex-direction: column;
            padding-top: 80px;
        }

        .sidebar a {
            padding: 18px 30px;
            text-decoration: none;
            font-size: 1.3rem;
            color: var(--light);
            display: block;
            transition: all 0.3s ease;
            font-weight: 600;
            letter-spacing: 1px;
            border-bottom: 1px solid rgba(0, 255, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar a i {
            width: 25px;
            text-align: center;
            color: var(--primary);
        }

        .sidebar a:hover {
            background-color: rgba(0, 255, 0, 0.1);
            color: var(--primary);
            padding-left: 40px;
            text-shadow: var(--text-glow);
        }

        .sidebar a.active {
            background-color: rgba(0, 255, 0, 0.2);
            color: var(--primary);
            text-shadow: var(--text-glow);
        }

        .sidebar .closebtn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 2rem;
            color: var(--primary);
            padding: 0;
            border: none;
        }

        .openbtn {
            font-size: 1.5rem;
            cursor: pointer;
            background-color: var(--primary);
            color: var(--dark);
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px var(--primary);
        }

        .openbtn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px var(--primary);
        }

        .openbtn {
            font-size: 24px;
            cursor: pointer;
            border: none;
            position: fixed;
            top: 35%;
            right: 3%;
            background-color: var(--primary);
            color: var(--dark);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            box-shadow: 0 0 15px var(--primary);
            transition: all 0.3s ease;
        }

        A.btn {
            color: #000000;
        }

        a.login {
            color: #00ff00;
        }

        .openbtn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 25px var(--primary);
        }

        .sidebar .closebtn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 2rem;
            color: var(--primary);
        }

        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background-color: var(--accent-color);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(29, 185, 84, 0.5);
            z-index: 99;
        }

        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--accent-light);
            transform: translateY(-3px);
        }

        /* User Profile Section */
        .user-profile {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 2px solid var(--primary);
            object-fit: cover;
        }

        .username {
            font-weight: 600;
            color: var(--primary);
        }

        .logout-btn {
            background: transparent;
            border: none;
            color: var(--light);
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .logout-btn:hover {
            color: var(--accent);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .hero h1 {
                font-size: 3rem;
            }

            .games-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 768px) {
            nav {
                padding: 1.2rem 5%;
            }

            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-buttons {
                flex-direction: column;
                gap: 1rem;
            }

            .btn {
                padding: 0.8rem 1.5rem;
                width: 100%;
                text-align: center;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }

            .user-profile {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-end;
            }

            .username {
                display: none;
            }
        }

        @media (max-width: 576px) {
            .hero h1 {
                font-size: 2rem;
            }

            nav {
                padding: 1.2rem 5%;
            }

            .nav-links {
                display: none;
            }

            .game-card {
                max-width: 100%;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .openbtn {
                width: 40px;
                height: 40px;
                font-size: 20px;
            }
        }


        /* Animations */
        @keyframes pulse {
            0% {
                box-shadow: 0 0 10px var(--primary);
            }

            50% {
                box-shadow: 0 0 20px var(--primary);
            }

            100% {
                box-shadow: 0 0 10px var(--primary);
            }
        }

        .btn-signup {
            animation: pulse 2s infinite;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }
        .user-menu {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            position: relative;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: var(--dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid var(--primary);
            box-shadow: 0 0 10px var(--primary);
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px var(--primary);
        }

        .user-dropdown {
            position: absolute;
            top: 60px;
            right: 0;
            background-color: var(--card-bg);
            border-radius: 10px;
            padding: 1.5rem;
            width: 280px;
            box-shadow: 0 5px 30px rgba(0, 255, 0, 0.2);
            border: 1px solid var(--primary);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .user-dropdown.active {
            opacity: 1;
            visibility: visible;
            top: 70px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(0, 255, 0, 0.2);
            margin-bottom: 1rem;
        }

        .user-info-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .user-info-item i {
            color: var(--primary);
            width: 20px;
            text-align: center;
        }

        .user-info-item span {
            font-weight: 500;
        }

        .user-info-item .value {
            color: var(--accent);
            font-weight: 600;
        }

        .user-rank {
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: linear-gradient(to right, var(--primary), var(--accent));
            color: var(--dark);
            border-radius: 20px;
            font-weight: 700;
            font-size: 0.8rem;
            margin-top: 0.5rem;
        }

        .dropdown-links {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .dropdown-links a {
            color: var(--light);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .dropdown-links a:hover {
            background-color: rgba(0, 255, 0, 0.1);
            color: var(--primary);
            padding-left: 1rem;
        }

        .dropdown-links a i {
            width: 20px;
            text-align: center;
            color: var(--primary);
        }
        .signature{
            color: #585858;
        }
        /* Modified styles */
        img.main-logo {
            width: 400px;
            top: 10%;
            height: auto;

            max-width: 500%;


        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav>
        <a href="dashboard.php"><img src="pics/NEXUS LOGO.png"
                alt="critical-mass-ldr-font"  class="main-logo"></a>

        <div class="nav-links">
            <a href="dashboard.php">Home</a>
            <a href="#games-section">Games</a>
            <a href="#">News</a>
            <a href="#">Reviews</a>
            <a href="#">Community</a>
        </div>

        <div class="auth-buttons">
            <div class="user-profile">
                
                
                <div class="user-menu">
            <div class="user-avatar" id="user-avatar">TI</div>
            <div class="user-dropdown" id="user-dropdown">
                <div class="user-info">
                    <div class="user-info-item">
                        <i class="fas fa-user"></i>
                        <span>Username: <span class="value">Taha</span></span>
                    </div>
                    <div class="user-info-item">
                        <i class="fas fa-id-card"></i>
                        <span>User ID: <span class="value">NG-7429</span></span>
                    </div>
                    <div class="user-info-item">
                        <i class="fas fa-trophy"></i>
                        <span>Rank: <span class="user-rank">Elite Gamer</span></span>
                    </div>
                </div>
                  <div class="dropdown-links">
                    <a href="#"><i class="fas fa-user"></i>Profile</a>
                    <a href="settings.html"><i class="fas fa-cog"></i>Settings</a>
                    <a href="#"><i class="fas fa-gamepad"></i>My Games</a>
                    
                  </div>
                </div>
             </div>
             <span class="username">Taha</span>
                <button class="logout-btn">Logout</button>
            </div>
        </div>
    </nav>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
        <a href="dashboard.php" class="active">
            <i class="fas fa-home"></i>Home
        </a>
        <a href="about.html">
            <i class="fas fa-info-circle"></i>About
        </a>
        <a href="contact.html">
            <i class="fas fa-envelope"></i>Contact
        </a>
        <a href="#">
            <i class="fas fa-user"></i>My Profile
        </a>
        <a href="#">
            <i class="fas fa-gamepad"></i>My Games
        </a>
        <a href="#">
            <i class="fas fa-users"></i>Friends
        </a>
        <a href="#">
            <i class="fas fa-cog"></i>Settings
        </a>
        <a href="javascript:void(0)" class="closebtn" onclick="closeSidebar()">
            <i class="fas fa-times"></i>Close
        </a>
    </div>

    <div id="main">
        <button class="openbtn" onclick="openSidebar()">☰</button>

        <!-- Hero Section -->
        <section class="hero">
            <div class="hero-content">
                <h1>WELCOME BACK, TAHA</h1>
                <p>Continue your gaming journey with personalized recommendations based on your play history. Check out what's new in your favorite genres.</p>
                <div class="hero-buttons">
                    <button class="btn btn-explore"><a href="games/hangman.html" style="color: #000000;">Continue Playing</a></button>
                   
                </div>
            </div>
        </section>

        <!-- Featured Games -->
        <section class="games-section" id="games-section">
            <div class="section-header">
                <h2>HOT GAMES</h2>
                <a href="library.html" class="view-all">View Library <i class="fas fa-chevron-right"></i></a>
            </div>

            <div class="games-grid">
                <!-- Game Card 1 -->
                <div class="game-card">
                    <img src="pics/cs 1.6.png" alt="counter-strike" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Counter-Strike 1.6</h3>
                        <span class="game-genre">Tactical • Shooter</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="https://datanodes.to/download">Download</a></button>
                            <span class="game-rating">
                                <i class="fas fa-clock"></i> 32h
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 2 -->
                <div class="game-card">
                    <img src="pics/cod.png" alt="call of duty 4" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Call of Duty 4-<br> Modern Warfare</h3>
                        <span class="game-genre">Tactical • Shooter</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="https://datavaults.co/gitatgx0m7ry/Call_of_Duty_4_Modern_Warfare_%5BCONOR%5D.rar">Download</a></button>
                            <span class="game-rating">
                                <i class="fas fa-clock"></i> 15h
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 3 -->
                <div class="game-card">
                    <img src="pics/gta-5-qpjtjdxwbwrk4gyj.png" alt="GTA V" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">GTA V</h3>
                        <span class="game-genre">Fantasy • RPG</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="https://datavaults.co/i7ptvaq5vne6/Grand_Theft_Auto_V_%5BCONOR%5D.rar">Download</a></button>
                            <span class="game-rating">
                                <i class="fas fa-clock"></i> 87h
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 4 -->
                <div class="game-card">
                    <img src="pics/Resident_Evil_3.png" alt="resident Resident_Evil_3" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Resident Evil 3</h3>
                        <span class="game-genre">Survival • Adventure</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="https://datavaults.co/nsjcw3anecji/Resident_Evil_3_%5BCONOR%5D.rar">Download</a></button>
                            <span class="game-rating">
                                <i class="fas fa-clock"></i> 42h
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="games-section" id="games-section">
            <div class="section-header">
                <h2>FREE TO PLAY</h2>
                <a href="#" class="view-all">View All <i class="fas fa-chevron-right"></i></a>
            </div>

            <div class="games-grid">
                <!-- Game Card 1 -->
                <div class="game-card">
                    <img src="pics/snake.png" alt="snake game" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Snake Game</h3>
                        <span class="game-genre">Comedy • Action</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="games/snake.html">Play</a></button>

                            <span class="game-rating">
                                <i class="fas fa-star"></i> 4.9
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 2 -->
                <div class="game-card">
                    <img src="pics/tictactoe.png" alt="tictactoe" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">TicTacToe</h3>
                        <span class="game-genre">Paper-and-pencil</span>
                        <div class="game-meta">
                           <button class="game-btn"><a class="btn"
                                    href="games/tictactoe.html">Play</a></button>
                            <span class="game-rating">
                                <i class="fas fa-star"></i> 4.7
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 3 -->
                <div class="game-card">
                    <img src="pics/flappybird.png" alt="flappybird" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Flappybird</h3>
                        <span class="game-genre">arcade • action</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="games/flappybird.html">Play</a></button>
                            <span class="game-rating">
                                <i class="fas fa-star"></i> 4.8
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Game Card 4 -->
                <div class="game-card">
                    <img src="pics/hangman.png" alt="hangman" class="game-image">
                    <div class="game-info">
                        <h3 class="game-title">Hangman</h3>
                        <span class="game-genre">word game • Mind Sports</span>
                        <div class="game-meta">
                            <button class="game-btn"><a class="btn"
                                    href="games/hangman.html">Play</a></button>
                            <span class="game-rating">
                                <i class="fas fa-star"></i> 4.5
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Categories -->
        <section class="categories">
            <div class="section-header">
                <h2>YOUR FAVORITE GENRES</h2>
                <a href="#" class="view-all">View All <i class="fas fa-chevron-right"></i></a>
            </div>

            <div class="categories-grid">
                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-user-ninja"></i>
                    </div>
                    <h3>Action</h3>
                    <p>12 games</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-chess"></i>
                    </div>
                    <h3>Strategy</h3>
                    <p>8 games</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-running"></i>
                    </div>
                    <h3>Sports</h3>
                    <p>5 games</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-robot"></i>
                    </div>
                    <h3>Sci-Fi</h3>
                    <p>7 games</p>
                </div>

                <div class="category-card">
                    <div class="category-icon">
                        <i class="fas fa-dragon"></i>
                    </div>
                    <h3>Fantasy</h3>
                    <p>9 games</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-grid">
                <div class="footer-column">
                    <h3>GameNexus</h3>
                    <p>Your portal to the gaming universe. Discover, play, and connect with gamers worldwide across all
                        platforms and genres.</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-discord"></i></a>
                        <a href="#"><i class="fab fa-twitch"></i></a>
                    </div>
                </div>

                <div class="footer-column">
                    <h3>Explore</h3>
                    <ul>
                        <li><a href="#">PC Games</a></li>
                        <li><a href="#">Console Games</a></li>
                        <li><a href="#">Mobile Games</a></li>
                        <li><a href="#">VR Games</a></li>
                        <li><a href="#">Upcoming Releases</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Company</h3>
                    <ul>
                        <li><a href="about.html">About Us</a></li>
                       
                        <li><a href="contact.html">Contact</a></li>
                        <li><a href="#">Support</a></li>
                    </ul>
                </div>

                <div class="footer-column">
                    <h3>Legal</h3>
                    <ul>
                        <li><a href="terms-conditions.html">Terms of Service</a></li>
                        <li><a href="privacy-policy.html">Privacy Policy</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Refund Policy</a></li>
                        
                    </ul>
                </div>
            </div>

            <div class="copyright">
                <p>&copy; 2023 NexusGaming. All rights reserved. All trademarks and logos are property of their
                    respective
                    owners.</p>
            </div>
        </footer>
        <div class="back-to-top" id="backToTop">
            <i class="fas fa-arrow-up"></i>
        </div>
    </div>
    <div class="signature" align="right">
        <p>@ Mr.Innoxence.</p>
    </div>
    <script>
          // User dropdown functionality
        const userAvatar = document.getElementById('user-avatar');
        const userDropdown = document.getElementById('user-dropdown');

        userAvatar.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('active');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userDropdown.classList.remove('active');
        });

        // Prevent dropdown from closing when clicking inside it
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        // Sidebar functionality
        function openSidebar() {
            document.getElementById("sidebar").style.right = "0";
            document.getElementById("main").style.marginRight = "280px";
        }

        function closeSidebar() {
            document.getElementById("sidebar").style.right = "-280px";
            document.getElementById("main").style.marginRight = "0";
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function (event) {
            const sidebar = document.getElementById('sidebar');
            const openBtn = document.querySelector('.openbtn');

            if (!sidebar.contains(event.target) && !openBtn.contains(event.target)) {
                closeSidebar();
            }
        });

        // Add animation to game cards on scroll
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = "1";
                    entry.target.style.transform = "translateY(0)";
                }
            });
        }, observerOptions);

        document.querySelectorAll('.game-card, .category-card').forEach(card => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            card.style.transition = "all 0.5s ease";
            observer.observe(card);
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('show');
            } else {
                backToTopButton.classList.remove('show');
            }
        });

        backToTopButton.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
        
        // Logout functionality
        document.querySelector('.logout-btn').addEventListener('click', function() {
            if(confirm('Are you sure you want to logout?')) {
                window.location.href = 'index.html'; // Redirect to home page after logout
            }
        });
    </script>
</body>

</html>
