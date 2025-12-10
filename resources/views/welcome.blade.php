<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Progressly - Simplify Your Project Management</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        /* Reset & Base */
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Figtree', sans-serif; 
            background: #111827; 
            color: #f8fafc; 
            overflow-x: hidden; 
            line-height: 1.6;
        }
        
        a { 
            text-decoration: none; 
            transition: all 0.3s ease; 
        }
        
        .container { 
            max-width: 1200px; 
            margin: 0 auto; 
            padding: 0 1.5rem; 
        }

        /* Header/Navigation */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: rgba(31, 41, 55, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(55, 65, 81, 1);
            z-index: 1000;
            padding: 1rem 0;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-auth {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login {
            color: #d1d5db;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            background: rgba(55, 65, 81, 0.6);
            color: white;
        }

        .btn-register {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 500;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
            transition: all 0.3s ease;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }

        /* Typography */
        h1 { font-size: 3.5rem; font-weight: 700; line-height: 1.1; }
        h2 { font-size: 2.5rem; font-weight: 700; margin-bottom: 1.5rem; }
        h3 { font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; }
        p { margin-bottom: 1.5rem; opacity: 0.9; }

        /* Buttons */
        .btn { 
            display: inline-flex; 
            align-items: center; 
            justify-content: center; 
            padding: 1rem 2rem; 
            border-radius: 12px; 
            font-weight: 600; 
            border: none; 
            cursor: pointer; 
            font-size: 1rem;
            transition: all 0.3s ease;
            gap: 0.5rem;
        }
        
        .btn-primary { 
            background: linear-gradient(135deg, #3b82f6, #8b5cf6); 
            color: white; 
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        
        .btn-primary:hover { 
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        .btn-secondary { 
            background: rgba(31, 41, 55, 0.8); 
            color: #d1d5db; 
            border: 1px solid rgba(55, 65, 81, 1);
            backdrop-filter: blur(10px);
        }
        
        .btn-secondary:hover { 
            background: rgba(55, 65, 81, 0.8);
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            background: #111827;
            overflow: hidden;
            padding-top: 80px;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(139, 92, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(16, 185, 129, 0.05) 0%, transparent 50%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr;
            gap: 3rem;
            align-items: center;
        }

        @media (min-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr 1fr;
            }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            background: rgba(59, 130, 246, 0.2);
            color: #60a5fa;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(59, 130, 246, 0.3);
            backdrop-filter: blur(10px);
        }

        .hero-badge::before {
            content: '✨';
            margin-right: 0.5rem;
        }

        .hero-text h1 {
            margin-bottom: 1.5rem;
        }

        .hero-text p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.9;
            color: #d1d5db;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1rem;
        }

        .hero-note {
            font-size: 0.875rem;
            color: #9ca3af;
        }

        /* Dashboard Preview */
        .dashboard-preview {
            position: relative;
            background: rgba(31, 41, 55, 0.9);
            border-radius: 16px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(55, 65, 81, 1);
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1);
            transform: perspective(1000px) rotateY(-5deg) rotateX(5deg);
            transition: transform 0.5s ease;
        }

        .dashboard-preview:hover {
            transform: perspective(1000px) rotateY(0deg) rotateX(0deg);
        }

        .dashboard-header {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .dashboard-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
        }

        .dashboard-dot.red { background: #ef4444; }
        .dashboard-dot.yellow { background: #eab308; }
        .dashboard-dot.green { background: #22c55e; }

        .dashboard-content {
            background: rgba(17, 24, 39, 0.9);
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid rgba(55, 65, 81, 1);
        }

        .dashboard-widget {
            background: rgba(31, 41, 55, 0.9);
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(55, 65, 81, 0.8);
        }

        .dashboard-widget:last-child {
            margin-bottom: 0;
        }

        /* Features Section */
        .features {
            padding: 6rem 0;
            background: #111827;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-subtitle {
            color: #60a5fa;
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: rgba(31, 41, 55, 0.9);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            border: 1px solid rgba(55, 65, 81, 1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border-color: rgba(99, 102, 241, 0.5);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);
        }

        .feature-card h3 {
            color: #f3f4f6;
            margin-bottom: 1rem;
        }

        .feature-card p {
            color: #d1d5db;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            background: rgba(31, 41, 55, 0.9);
            padding: 6rem 0;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(55, 65, 81, 1);
            border-bottom: 1px solid rgba(55, 65, 81, 1);
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 30% 70%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 70% 30%, rgba(139, 92, 246, 0.1) 0%, transparent 50%);
        }

        .cta-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .cta-section h2 {
            margin-bottom: 1.5rem;
        }

        .cta-section p {
            font-size: 1.25rem;
            margin-bottom: 2.5rem;
            opacity: 0.9;
            color: #d1d5db;
        }

        .cta-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Footer */
        footer {
            background: #111827;
            border-top: 1px solid rgba(55, 65, 81, 1);
            padding: 3rem 0;
            text-align: center;
        }

        footer p {
            margin-bottom: 0;
            color: #9ca3af;
        }

        /* Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Gradient text */
        .gradient-text {
            background: linear-gradient(135deg, #3b82f6, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar">
    <div class="container nav-container">
        <div class="logo">Progressly</div>
        <div class="nav-auth">
            <a href="{{ route('login') }}" class="btn-login"> Login</a>
            <a href="{{ route('register') }}" class="btn-register"> Register</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<section class="hero">
    <div class="container hero-content">
        <div class="hero-text">
            <div class="hero-badge">All-in-One Project Management Solution</div>
            <h1>Streamline Your Workflow with <span class="gradient-text">Progressly</span></h1>
            <p>Progressly helps teams organize, track, and collaborate on projects effortlessly. From Kanban boards to calendar integration, we provide everything you need to boost productivity.</p>
            
            <div class="hero-actions">
                <a href="{{ route('register') }}" class="btn btn-primary">
                     Start Free Trial
                </a>
            </div>
            
            <p class="hero-note">No credit card required • Free 14-day trial • Cancel anytime</p>
        </div>
        
        <div class="dashboard-preview floating">
            <div class="dashboard-header">
                <div class="dashboard-dot red"></div>
                <div class="dashboard-dot yellow"></div>
                <div class="dashboard-dot green"></div>
            </div>
            <div class="dashboard-content">
                <h3 style="color:#f3f4f6; margin-bottom:1rem;">Project Dashboard</h3>
                <div class="dashboard-widget">
                    <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                        <span style="color:#9ca3af;">In Progress</span>
                        <span style="color:#60a5fa; font-weight:600;">3 tasks</span>
                    </div>
                    <div style="height:4px; background:rgba(55, 65, 81, 1); border-radius:2px;">
                        <div style="width:60%; height:100%; background:#3b82f6; border-radius:2px;"></div>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                        <span style="color:#9ca3af;">Completed</span>
                        <span style="color:#22c55e; font-weight:600;">12 tasks</span>
                    </div>
                    <div style="height:4px; background:rgba(55, 65, 81, 1); border-radius:2px;">
                        <div style="width:80%; height:100%; background:#22c55e; border-radius:2px;"></div>
                    </div>
                </div>
                <div class="dashboard-widget">
                    <div style="display:flex; justify-content:space-between; margin-bottom:0.5rem;">
                        <span style="color:#9ca3af;">Team Performance</span>
                        <span style="color:#8b5cf6; font-weight:600;">85%</span>
                    </div>
                    <div style="height:4px; background:rgba(55, 65, 81, 1); border-radius:2px;">
                        <div style="width:85%; height:100%; background:#8b5cf6; border-radius:2px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section id="features" class="features">
    <div class="container">
        <div class="section-header">
            <span class="section-subtitle">WHY CHOOSE Progressly</span>
            <h2>Powerful Features for Seamless Project Management</h2>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">📋</div>
                <h3>Kanban Boards</h3>
                <p>Visualize workflow and drag & drop tasks between columns. Track progress with intuitive boards that adapt to your workflow.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Calendar Integration</h3>
                <p>Never miss a deadline with integrated calendar views. Sync with Google Calendar and set smart reminders.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">👥</div>
                <h3>Team Collaboration</h3>
                <p>Assign tasks, leave comments, and collaborate in real-time. Mention teammates and get instant notifications.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Advanced Analytics</h3>
                <p>Track team performance and project metrics with detailed reports and insights.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">🔒</div>
                <h3>Secure & Private</h3>
                <p>Enterprise-grade security with end-to-end encryption and role-based access control.</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">⚡</div>
                <h3>Lightning Fast</h3>
                <p>Built for speed with optimized performance that keeps your team productive.</p>
            </div>
        </div>
    </div>
</section>



<!-- Footer -->
<footer>
    <div class="container">
        <p>&copy; 2025 Progressly. All rights reserved. | Built with ❤️ for productive teams</p>
    </div>
</footer>

</body>
</html>