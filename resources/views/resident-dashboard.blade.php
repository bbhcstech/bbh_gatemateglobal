@extends('admin.layout.app')

@section('title', 'Resident Dashboard')

@section('content')

@php
$unreadNotifications = \App\Models\Notification::where('resident_id', auth()->id())
                       ->where('audience', 'resident')
                        ->where('is_read', 0)
                        ->count();
@endphp

<style>
:root {
    --primary: #2563eb;
    --primary-dark: #1d4ed8;
    --primary-light: #3b82f6;
    --secondary: #64748b;
    --success: #10b981;
    --warning: #f59e0b;
    --danger: #ef4444;
    --info: #3b82f6;
    --dark: #0f172a;
    --light: #f8fafc;
    --gray-50: #f9fafb;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-700: #374151;
    --gray-800: #1f2937;
    --gray-900: #111827;

    --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
    --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
    --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
    --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

    --radius-sm: 0.375rem;
    --radius: 0.5rem;
    --radius-md: 0.75rem;
    --radius-lg: 1rem;
    --radius-xl: 1.5rem;
}

/* Base Styles - Updated Background */
body {
    background: linear-gradient(135deg, #f5f0ff 0%, #ffffff 50%, #f0e6ff 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    min-height: 100vh;
}

.dashboard {
    min-height: 100vh;
    padding: 2rem 1.5rem;
    background: transparent;
}

.dashboard-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Modern Header - Updated */
.modern-header {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: var(--radius-xl);
    padding: 1.5rem 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.welcome-section {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.welcome-badge {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    color: white;
    padding: 0.5rem 1.5rem;
    border-radius: 100px;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.welcome-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.welcome-subtitle {
    color: var(--gray-500);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.header-actions {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.header-action-btn {
    width: 44px;
    height: 44px;
    border-radius: 50%;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-600);
    transition: all 0.2s ease;
    position: relative;
    border: 1px solid var(--gray-200);
}

.header-action-btn:hover {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    color: white;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: transparent;
}

.notification-badge {
    position: absolute;
    top: -4px;
    right: -4px;
    background: var(--danger);
    color: white;
    font-size: 0.7rem;
    font-weight: 600;
    min-width: 20px;
    height: 20px;
    border-radius: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0 6px;
    border: 2px solid white;
}

/* Society Info Bar - Updated */
.society-bar {
    background: white;
    border-radius: var(--radius-lg);
    padding: 1rem 1.5rem;
    margin-bottom: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    flex-wrap: wrap;
    box-shadow: var(--shadow);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.society-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #f0e6ff 0%, #e0d7ff 100%);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #8b5cf6;
    font-size: 1.5rem;
}

.society-details {
    flex: 1;
}

.society-name {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.society-address {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.society-stats {
    display: flex;
    gap: 2rem;
}

.society-stat {
    text-align: center;
}

.stat-value {
    font-size: 1.25rem;
    font-weight: 700;
    color: #8b5cf6;
}

.stat-label {
    font-size: 0.75rem;
    color: var(--gray-500);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Profile Card - Updated */
.profile-card-modern {
    background: white;
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.section-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid #f0e6ff;
}

.section-header i {
    font-size: 1.25rem;
    color: #8b5cf6;
    background: linear-gradient(135deg, #f0e6ff 0%, #e0d7ff 100%);
    padding: 0.75rem;
    border-radius: var(--radius);
}

.section-header h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--gray-800);
    margin: 0;
}

.section-header p {
    color: var(--gray-500);
    font-size: 0.875rem;
    margin: 0.25rem 0 0 0;
}

.profile-grid {
    display: flex;
    gap: 2.5rem;
    flex-wrap: wrap;
}

.profile-avatar {
    position: relative;
    width: 140px;
    height: 140px;
}

.profile-avatar img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid white;
    box-shadow: var(--shadow-lg);
}

.avatar-badge {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    border: 3px solid white;
    font-size: 1rem;
}

.profile-info-grid {
    flex: 1;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
}

.info-item {
    background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
    padding: 1rem;
    border-radius: var(--radius-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
    transition: all 0.2s ease;
}

.info-item:hover {
    background: white;
    border-color: #8b5cf6;
    box-shadow: var(--shadow-md);
    transform: translateY(-2px);
}

.info-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--gray-500);
    margin-bottom: 0.5rem;
}

.info-value {
    font-size: 1rem;
    font-weight: 600;
    color: var(--gray-800);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-value i {
    color: #8b5cf6;
    font-size: 1rem;
}

/* Quick Actions - Updated */
.quick-actions-modern {
    background: white;
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
    gap: 1rem;
    margin-top: 1.5rem;
}

.action-card {
    background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
    border-radius: var(--radius-lg);
    padding: 1.5rem 1rem;
    text-align: center;
    text-decoration: none;
    color: var(--gray-700);
    transition: all 0.3s ease;
    border: 1px solid rgba(139, 92, 246, 0.1);
    position: relative;
    overflow: hidden;
}

.action-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #8b5cf6 0%, #6366f1 100%);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.action-card:hover {
    background: white;
    border-color: #8b5cf6;
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.action-card:hover::before {
    transform: scaleX(1);
}

.action-icon {
    width: 56px;
    height: 56px;
    background: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: #8b5cf6;
    font-size: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: var(--shadow);
}

.action-card:hover .action-icon {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    color: white;
    transform: rotate(360deg);
}

.action-title {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--gray-700);
    margin-bottom: 0.25rem;
}

.action-subtitle {
    font-size: 0.7rem;
    color: var(--gray-500);
}

/* Stats Grid Modern - Updated */
.stats-grid-modern {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}

.stat-card-modern {
    background: white;
    border-radius: var(--radius-xl);
    padding: 1.5rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
    display: flex;
    align-items: center;
    gap: 1.5rem;
    transition: all 0.3s ease;
}

.stat-card-modern:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
    border-color: #8b5cf6;
}

.stat-icon-wrapper {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #f0e6ff 0%, #e0d7ff 100%);
    border-radius: var(--radius-lg);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #8b5cf6;
}

.stat-content-modern {
    flex: 1;
}

.stat-label-modern {
    font-size: 0.875rem;
    color: var(--gray-500);
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-value-modern {
    font-size: 2rem;
    font-weight: 700;
    color: var(--gray-800);
    line-height: 1.2;
    margin-bottom: 0.25rem;
}

.stat-trend {
    font-size: 0.75rem;
    color: var(--success);
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.stat-trend.down {
    color: var(--danger);
}

/* Visitors Card - Updated */
.visitors-card-modern {
    background: white;
    border-radius: var(--radius-xl);
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
}

.visitors-list {
    margin-top: 1.5rem;
}

.visitor-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-bottom: 1px solid #f0e6ff;
    transition: all 0.2s ease;
}

.visitor-row:last-child {
    border-bottom: none;
}

.visitor-row:hover {
    background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
    border-radius: var(--radius);
}

.visitor-avatar-modern {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.125rem;
}

.visitor-details {
    flex: 1;
}

.visitor-name-modern {
    font-weight: 600;
    color: var(--gray-800);
    margin-bottom: 0.25rem;
}

.visitor-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--gray-500);
}

.visitor-time-modern {
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.visitor-badge {
    background: linear-gradient(135deg, #8b5cf6 0%, #6366f1 100%);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 100px;
    font-size: 0.7rem;
    font-weight: 500;
}

/* Bottom Navigation - Updated */
.bottom-nav-modern {
    background: white;
    border-radius: var(--radius-xl);
    padding: 1rem;
    box-shadow: var(--shadow-lg);
    border: 1px solid rgba(139, 92, 246, 0.1);
    margin-top: 2rem;
}

.nav-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 0.5rem;
}

.nav-link-modern {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1rem 0.5rem;
    border-radius: var(--radius-lg);
    color: var(--gray-600);
    text-decoration: none;
    transition: all 0.2s ease;
    gap: 0.5rem;
}

.nav-link-modern:hover {
    background: linear-gradient(135deg, #f0e6ff 0%, #e0d7ff 100%);
    color: #8b5cf6;
    transform: translateY(-3px);
}

.nav-link-modern i {
    font-size: 1.5rem;
}

.nav-link-modern span {
    font-size: 0.75rem;
    font-weight: 500;
}

/* Empty State - Updated */
.empty-state-modern {
    text-align: center;
    padding: 3rem;
    color: var(--gray-400);
    background: linear-gradient(135deg, #faf5ff 0%, #ffffff 100%);
    border-radius: var(--radius-lg);
}

.empty-state-modern i {
    font-size: 4rem;
    margin-bottom: 1rem;
    color: #8b5cf6;
    opacity: 0.5;
}

.empty-state-modern p {
    font-size: 1rem;
    color: var(--gray-500);
}

/* Responsive Design - Keep same */
@media (max-width: 1024px) {
    .dashboard {
        padding: 1.5rem 1rem;
    }

    .profile-grid {
        flex-direction: column;
        align-items: center;
    }

    .society-bar {
        flex-direction: column;
        align-items: flex-start;
    }

    .society-stats {
        width: 100%;
        justify-content: space-around;
    }
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
    }

    .welcome-section {
        flex-direction: column;
        align-items: flex-start;
    }

    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .nav-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .nav-link-modern:nth-child(n+4) {
        margin-top: 0.5rem;
    }

    .profile-info-grid {
        grid-template-columns: 1fr;
    }

    .visitor-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.25rem;
    }
}

@media (max-width: 480px) {
    .dashboard {
        padding: 1rem 0.75rem;
    }

    .modern-header,
    .profile-card-modern,
    .quick-actions-modern,
    .visitors-card-modern,
    .bottom-nav-modern {
        padding: 1.5rem;
    }

    .actions-grid {
        grid-template-columns: 1fr;
    }

    .society-stats {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }

    .society-stat {
        display: flex;
        gap: 0.5rem;
        align-items: baseline;
    }

    .stat-card-modern {
        flex-direction: column;
        text-align: center;
    }

    .visitor-row {
        flex-wrap: wrap;
    }

    .visitor-avatar-modern {
        width: 40px;
        height: 40px;
        font-size: 1rem;
    }
}

/* Animations - Keep same */
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dashboard-container > * {
    animation: slideIn 0.5s ease forwards;
}

.dashboard-container > *:nth-child(1) { animation-delay: 0.1s; }
.dashboard-container > *:nth-child(2) { animation-delay: 0.2s; }
.dashboard-container > *:nth-child(3) { animation-delay: 0.3s; }
.dashboard-container > *:nth-child(4) { animation-delay: 0.4s; }
.dashboard-container > *:nth-child(5) { animation-delay: 0.5s; }
</style>

<main class="dashboard">
    <div class="dashboard-container">

        <!-- Modern Header -->
        <div class="modern-header">
            <div class="header-content">
                <div class="welcome-section">
                    <span class="welcome-badge">Resident Portal</span>
                    <div>
                        <h1 class="welcome-title">Welcome back, {{ $user->name }}!</h1>
                        <p class="welcome-subtitle">{{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>

                <div class="header-actions">
                    <button class="header-action-btn" title="Search">
                        <i class="fa fa-search"></i>
                    </button>

                    <a href="{{ route('notifications.index') }}" class="header-action-btn" title="Notifications">
                        <i class="fa fa-bell"></i>
                        @if($unreadNotifications > 0)
                            <span class="notification-badge">{{ $unreadNotifications }}</span>
                        @endif
                    </a>

                    <a href="{{ url('/profile') }}" class="header-action-btn" title="Profile">
                        <i class="fa fa-user"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Society Info Bar -->
        <div class="society-bar">
            <div class="society-icon">
                <i class="fa fa-building"></i>
            </div>
            <div class="society-details">
                <div class="society-name">{{ auth()->user()->society_name ?? 'My Society' }}</div>
                <div class="society-address">Sector 62, Noida - 201301</div>
            </div>
            <div class="society-stats">
                <div class="society-stat">
                    <div class="stat-value">185</div>
                    <div class="stat-label">Total Flats</div>
                </div>
                <div class="society-stat">
                    <div class="stat-value">92%</div>
                    <div class="stat-label">Occupancy</div>
                </div>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="profile-card-modern">
            <div class="section-header">
                <i class="fa fa-id-card"></i>
                <div>
                    <h3>Resident Information</h3>
                    <p>Your complete profile details at a glance</p>
                </div>
            </div>

            <div class="profile-grid">
                <div class="profile-avatar">
                    @if($user->profile_pic)
                        <img src="{{ asset($user->profile_pic) }}" alt="Profile">
                    @else
                        <img src="{{ asset('default-user.png') }}" alt="Default Profile">
                    @endif
                    <div class="avatar-badge">
                        <i class="fa fa-check"></i>
                    </div>
                </div>

                <div class="profile-info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">
                            <i class="fa fa-user"></i>
                            {{ $user->name }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Mobile Number</div>
                        <div class="info-value">
                            <i class="fa fa-phone"></i>
                            {{ $user->mobile }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Tower</div>
                        <div class="info-value">
                            <i class="fa fa-building"></i>
                            {{ optional($user->tower)->name ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Floor</div>
                        <div class="info-value">
                            <i class="fa fa-layer-group"></i>
                            {{ optional($user->floor)->floor_no ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Flat Number</div>
                        <div class="info-value">
                            <i class="fa fa-door-open"></i>
                            {{ optional($user->flat)->flat_no ?? 'N/A' }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Parking Slot</div>
                        <div class="info-value">
                            <i class="fa fa-car"></i>
                            {{ optional($user->parking)->parking_no ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions-modern">
            <div class="section-header">
                <i class="fa fa-bolt"></i>
                <div>
                    <h3>Quick Actions</h3>
                    <p>Frequently used services and features</p>
                </div>
            </div>

            <div class="actions-grid">
                <a href="{{ route('visitor-preapproval.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-user-check"></i>
                    </div>
                    <div class="action-title">Pre-Approve</div>
                    <div class="action-subtitle">Visitor Access</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <div class="action-title">Payments</div>
                    <div class="action-subtitle">Dues & Bills</div>
                </a>

                <a href="{{ route('complaints.index') }}" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-headset"></i>
                    </div>
                    <div class="action-title">Helpdesk</div>
                    <div class="action-subtitle">Support</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-building"></i>
                    </div>
                    <div class="action-title">Amenities</div>
                    <div class="action-subtitle">Book Now</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-clipboard-check"></i>
                    </div>
                    <div class="action-title">Claim Facility</div>
                    <div class="action-subtitle">Request</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-comments"></i>
                    </div>
                    <div class="action-title">Posts</div>
                    <div class="action-subtitle">Community</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <div class="action-title">Security</div>
                    <div class="action-subtitle">Emergency</div>
                </a>

                <a href="#" class="action-card">
                    <div class="action-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </div>
                    <div class="action-title">View More</div>
                    <div class="action-subtitle">All Services</div>
                </a>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid-modern">
            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-users"></i>
                </div>
                <div class="stat-content-modern">
                    <div class="stat-label-modern">Today's Visitors</div>
                    <div class="stat-value-modern">{{ $todayVisitors ?? 0 }}</div>
                    <div class="stat-trend">
                        <i class="fa fa-arrow-up"></i> +12% from yesterday
                    </div>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-bell"></i>
                </div>
                <div class="stat-content-modern">
                    <div class="stat-label-modern">Unread Notifications</div>
                    <div class="stat-value-modern">{{ $unreadNotifications }}</div>
                    <div class="stat-trend {{ $unreadNotifications > 0 ? 'down' : '' }}">
                        <i class="fa {{ $unreadNotifications > 0 ? 'fa-exclamation-circle' : 'fa-check-circle' }}"></i>
                        {{ $unreadNotifications > 0 ? 'Requires attention' : 'All clear' }}
                    </div>
                </div>
            </div>

            <div class="stat-card-modern">
                <div class="stat-icon-wrapper">
                    <i class="fa fa-calendar-check"></i>
                </div>
                <div class="stat-content-modern">
                    <div class="stat-label-modern">Pending Dues</div>
                    <div class="stat-value-modern">$0</div>
                    <div class="stat-trend">
                        <i class="fa fa-check-circle"></i> No pending dues
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Visitors -->
        <div class="visitors-card-modern">
            <div class="section-header">
                <i class="fa fa-clock-o"></i>
                <div>
                    <h3>Recent Visitor Updates</h3>
                    <p>Latest visitor activity in your residence</p>
                </div>
            </div>

            <div class="visitors-list">
                @forelse($recentVisitors ?? [] as $visitor)
                    <div class="visitor-row">
                        <div class="visitor-avatar-modern">
                            {{ strtoupper(substr($visitor->name, 0, 1)) }}
                        </div>
                        <div class="visitor-details">
                            <div class="visitor-name-modern">{{ $visitor->name }}</div>
                            <div class="visitor-meta">
                                <span class="visitor-time-modern">
                                    <i class="fa fa-clock-o"></i>
                                    {{ $visitor->created_at->diffForHumans() ?? 'Just now' }}
                                </span>
                                <span class="visitor-time-modern">
                                    <i class="fa fa-map-marker"></i>
                                    Main Gate Entry
                                </span>
                            </div>
                        </div>
                        <span class="visitor-badge">Expected</span>
                    </div>
                @empty
                    <div class="empty-state-modern">
                        <i class="fa fa-user-friends"></i>
                        <p>No recent visitors</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Bottom Navigation -->
        <div class="bottom-nav-modern">
            <div class="nav-grid">
                <a href="#" class="nav-link-modern">
                    <i class="fa fa-users"></i>
                    <span>Social</span>
                </a>
                <a href="#" class="nav-link-modern">
                    <i class="fa fa-store"></i>
                    <span>Marketplace</span>
                </a>
                <a href="#" class="nav-link-modern">
                    <i class="fa fa-comments"></i>
                    <span>Community</span>
                </a>
                <a href="#" class="nav-link-modern">
                    <i class="fa fa-cogs"></i>
                    <span>Services</span>
                </a>
                <a href="#" class="nav-link-modern">
                    <i class="fa fa-microchip"></i>
                    <span>Devices</span>
                </a>
            </div>
        </div>

    </div>
</main>

@endsection
