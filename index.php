<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GL DB</title>
    <?php
    // Check for local logo file in the images folder, otherwise use CDN
    $logo_file = 'img/Lastlogo1.png';
    $favicon_url = file_exists($logo_file) ? $logo_file : 'https://glpromptbuilder.com/lastlogo1.png';
    ?>
    <link rel="icon" type="image/png" href="<?php echo $favicon_url; ?>">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            /* Dark mode (default) */
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #EC4899;
            --secondary-hover: #DB2777;
            --accent: #8B5CF6;
            --accent-hover: #7C3AED;
            --bg-gradient-start: #111827;
            --bg-gradient-end: #1F2937;
            --text-light: #F9FAFB;
            --card-bg: rgba(255, 255, 255, 0.05);
            --card-border: rgba(255, 255, 255, 0.1);
            --input-bg: rgba(0, 0, 0, 0.2);
            --input-border: rgba(255, 255, 255, 0.1);
            --input-text: white;
            --header-border: rgba(255, 255, 255, 0.1);
            --table-header-bg: rgba(0, 0, 0, 0.2);
            --table-border: rgba(255, 255, 255, 0.05);
            --text-secondary: rgba(255, 255, 255, 0.8);
        }
        
        /* Light mode - تعليق */
        /* :root.light-mode {
            --primary: #4F46E5;
            --primary-hover: #4338CA;
            --secondary: #DB2777;
            --secondary-hover: #BE185D;
            --accent: #7C3AED;
            --accent-hover: #6D28D9;
            --bg-gradient-start: #F3F4F6;
            --bg-gradient-end: #E5E7EB;
            --text-light: #1F2937;
            --card-bg: rgba(255, 255, 255, 0.8);
            --card-border: rgba(0, 0, 0, 0.1);
            --input-bg: rgba(255, 255, 255, 0.9);
            --input-border: rgba(0, 0, 0, 0.1);
            --input-text: #1F2937;
            --header-border: rgba(0, 0, 0, 0.1);
            --table-header-bg: rgba(229, 231, 235, 0.8);
            --table-border: rgba(0, 0, 0, 0.05);
            --text-secondary: rgba(31, 41, 55, 0.8);
        } */
        
        body {
            background: linear-gradient(135deg, var(--bg-gradient-start), var(--bg-gradient-end));
            color: var(--text-light);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            position: relative;
            transition: background 0.5s ease, color 0.5s ease;
        }
        
        .app-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }
        
        .neural-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            opacity: 0.05;
            pointer-events: none;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(139, 92, 246, 0.3) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(236, 72, 153, 0.3) 1px, transparent 1px);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
            transition: opacity 0.5s ease;
        }
        
        .light-mode .neural-bg {
            /* تعليق */
            /* opacity: 0.07;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(79, 70, 229, 0.3) 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, rgba(219, 39, 119, 0.3) 1px, transparent 1px); */
        }
        
        .ai-decoration {
            position: absolute;
            z-index: -1;
            opacity: 0.1;
            pointer-events: none;
            transition: opacity 0.5s ease;
        }
        
        .light-mode .ai-decoration {
            /* تعليق */
            /* opacity: 0.05; */
        }
        
        .ai-decoration-1 {
            top: 10%;
            right: 5%;
            width: 300px;
            height: 300px;
            border: 1px solid var(--accent);
            border-radius: 50%;
            animation: pulse 8s infinite linear;
        }
        
        .ai-decoration-2 {
            bottom: 10%;
            left: 5%;
            width: 200px;
            height: 200px;
            border: 1px solid var(--secondary);
            border-radius: 50%;
            animation: pulse 6s infinite linear reverse;
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 0.05;
            }
            50% {
                transform: scale(1.1);
                opacity: 0.2;
            }
            100% {
                transform: scale(1);
                opacity: 0.05;
            }
        }
        
        .card {
            background: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            border: 1px solid var(--card-border);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 8px 42px rgba(139, 92, 246, 0.25);
            transform: translateY(-5px);
        }
        
        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            color: var(--secondary);
        }
        
        .card-title i {
            margin-right: 0.5rem;
            color: var(--accent);
        }
        
        .form-group {
            margin-bottom: 1rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            color: var(--text-secondary);
        }
        
        select, input, textarea {
            width: 100%;
            padding: 0.75rem;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 0.5rem;
            color: var(--input-text);
            transition: all 0.3s ease;
        }
        
        select:focus, input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25);
        }
        
        /* Dropdown styling fix */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffffff' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            padding-right: 2.5rem;
        }
        
        .light-mode select {
            /* تعليق */
            /* background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%231F2937' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E"); */
        }
        
        /* Fix dropdown options */
        select option {
            background-color: #111827;
            color: white;
            padding: 0.75rem;
        }
        
        .light-mode select option {
            /* تعليق */
            /* background-color: #F9FAFB;
            color: #1F2937; */
        }
        
        .button {
            display: inline-block;
            padding: 0.5rem 1rem;
            background-color: var(--primary);
            color: white;
            border: none;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Extra style adjustments for light mode */
        .light-mode .text-gray-900 {
            /* تعليق */
            /* color: #111827; */
        }
        
        .light-mode .text-gray-500 {
            /* تعليق */
            /* color: #6B7280; */
        }
        
        /* Mode toggle animation */
        .theme-toggle i {
            transition: transform 0.5s ease;
        }
        
        .theme-toggle:hover i {
            transform: rotate(15deg);
        }
        
        /* Small text in the app title */
        .light-mode .app-title .opacity-60 {
            /* تعليق */
            /* color: rgba(31, 41, 55, 0.7); */
        }
        
        .pill {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            background: rgba(139, 92, 246, 0.2);
            border-radius: 9999px;
            font-size: 0.75rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid rgba(139, 92, 246, 0.3);
            color: rgba(255, 255, 255, 0.9);
        }
        
        /* Dashboard builder specific styles */
        .dashboard-preview {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-top: 1rem;
            border: 1px dashed var(--input-border);
        }
        
        .dashboard-page {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid var(--card-border);
            position: relative;
        }
        
        .light-mode .dashboard-page {
            /* تعليق */
            /* background: rgba(0, 0, 0, 0.05); */
        }
        
        .delete-btn {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background: rgba(239, 68, 68, 0.2);
            color: #ef4444;
            border: none;
            border-radius: 9999px;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .delete-btn:hover {
            background: rgba(239, 68, 68, 0.4);
            transform: scale(1.1);
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 1.5rem;
            margin-bottom: 1.5rem;
            border-bottom: 1px solid var(--header-border);
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }
        
        .logo-container img {
            height: 40px;
            margin-right: 1rem;
        }
        
        .app-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-light);
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        
                
        @keyframes cyberpunkGlow {
            0% {
                box-shadow: 0 0 10px var(--accent), 0 0 20px var(--accent);
            }
            33% {
                box-shadow: 0 0 15px var(--secondary), 0 0 30px var(--secondary);
            }
            66% {
                box-shadow: 0 0 15px var(--primary), 0 0 30px var(--primary);
            }
            100% {
                box-shadow: 0 0 10px var(--accent), 0 0 20px var(--accent);
            }
        }
        
        /* Improved checkbox label styles */
        .form-checkbox + span {
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
        }
        
        .light-mode .form-checkbox + span {
            /* تعليق */
            /* color: rgba(31, 41, 55, 0.95);
            font-weight: 500; */
        }
        
        /* Feature label improvements */
        .feature-label {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500;
        }
        
        .light-mode .feature-label {
            /* تعليق */
            /* color: rgba(31, 41, 55, 0.95) !important; */
        }
        
        .light-mode .card-title i {
            /* تعليق */
            /* color: var(--accent); */
        }
        
        /* Modal styles */
        .modal-overlay {
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        /* Share Modal Styles - Removed as they're moved to generative.php */
        /* 
        #shareModal:not(.hidden) .modal-overlay {
            opacity: 1;
            pointer-events: auto;
        }
        
        #shareModal:not(.hidden) .inline-block {
            animation: fade-in 0.3s ease forwards, slide-up 0.3s ease forwards;
        }
        
        #shareModal.hidden .inline-block {
            opacity: 0;
            transform: translateY(20px);
        }
        */
        
        @keyframes modalAppear {
            from {
                opacity: 0;
                transform: translate(0, 20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
        }
        
        #shareModal.hidden .inline-block {
            animation: modalDisappear 0.2s ease-in forwards;
        }
        
        @keyframes modalDisappear {
            from {
                opacity: 1;
                transform: translate(0, 0) scale(1);
            }
            to {
                opacity: 0;
                transform: translate(0, 20px) scale(0.95);
            }
        }
        
        /* Disable scrolling when modal is open */
        body.overflow-hidden {
            overflow: hidden;
        }
        
                
        @keyframes pulse-border {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(99, 102, 241, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }
        
        #dropZone.drag-over {
            animation: pulse-border 1.5s infinite;
        }
        
                
        @keyframes success-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }
        
        /* Keyboard shortcut hint */
        .keyboard-hint {
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            opacity: 0;
            transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        
        .keyboard-hint.opacity-100 {
            transform: translateY(0);
        }
        
        kbd {
            display: inline-block;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        }
        
        /* Animation for file icons */
        .fa-bounce {
            animation: bounce 0.6s ease infinite;
        }
        
        @keyframes bounce {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-3px);
            }
        }
        
        /* Shortcuts button */
        #keyboardShortcutsContainer button {
            transition: all 0.3s ease;
        }
        
        #keyboardShortcutsContainer button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.25);
        }
        
        .error-highlight {
            border: 1px solid #ef4444 !important;
            background-color: rgba(254, 226, 226, 0.5) !important;
        }
        
        @keyframes errorShake {
            0% {
                transform: translateX(0);
            }
            20% {
                transform: translateX(-5px);
            }
            40% {
                transform: translateX(5px);
            }
            100% {
                transform: translateX(0);
            }
        }
        
        .border-red-500 {
            animation: errorShake 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="ai-decoration ai-decoration-1"></div>
    <div class="ai-decoration ai-decoration-2"></div>
    <div class="neural-bg"></div>
    
    <div class="app-container">
        <div class="header">
            <div class="header-left">
                <div class="logo-container">
                    <?php
                    $logo_src = file_exists($logo_file) ? $logo_file : 'https://glpromptbuilder.com/lastlogo1.png';
                    ?>
                    <img src="<?php echo $logo_src; ?>" alt="Logo" class="logo">
                    <div class="app-title">
                        Dashboard Builder <span class="opacity-60">v1.0</span>
                    </div>
                </div>
            </div>
            <div class="header-right">
                <a href="default.php" class="button btn-secondary">
                    <i class="fas fa-home"></i> Home
                </a>
            </div>
        </div>
        
        <?php
        // Initialize variables
        $formSubmitted = false;
        
        // Check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Instead of processing here, redirect to generative.php
            header('Location: generative.php');
            exit;
        }
        ?>
        
        <!-- Form to gather dashboard variables -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-sliders-h"></i>
                Dashboard Configuration
            </div>
            
            <form method="POST" action="generative.php" class="space-y-6" id="promptForm" onsubmit="return validateForm()">
                <!-- Templates Section -->
                <div class="form-group border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-800 bg-opacity-30 config-section">
                    <h3 class="text-base font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-bolt mr-2 text-yellow-500"></i>
                        Quick Templates
                    </h3>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="admin">
                            <i class="fas fa-columns text-indigo-600 dark:text-indigo-400 mr-1"></i> Admin
                        </button>
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="analytics">
                            <i class="fas fa-chart-line text-blue-600 dark:text-blue-400 mr-1"></i> Analytics
                        </button>
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="ecommerce">
                            <i class="fas fa-shopping-cart text-purple-600 dark:text-purple-400 mr-1"></i> E-Commerce
                        </button>
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="project_mgmt">
                            <i class="fas fa-tasks text-green-600 dark:text-green-400 mr-1"></i> Project Management
                        </button>
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="maintenance">
                            <i class="fas fa-tools text-orange-600 dark:text-orange-400 mr-1"></i> Maintenance & Stats
                        </button>
                        <button type="button" class="template-btn px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" data-template="ml_project">
                            <i class="fas fa-brain text-purple-600 dark:text-purple-400 mr-1"></i> ML Project Dashboard
                        </button>
                    </div>
                    
                    <!-- Configuration Management -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                        <div>
                            <input type="text" id="configName" placeholder="Name your configuration" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        </div>
                        <div>
                            <select id="savedConfigs" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="">Select a saved configuration...</option>
                            </select>
                        </div>
                        <div class="flex space-x-2">
                            <button type="button" id="saveConfig" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-save mr-2"></i> Save
                            </button>
                            <button type="button" id="loadConfig" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" disabled>
                                <i class="fas fa-folder-open mr-2"></i> Load
                            </button>
                            <button type="button" id="deleteConfig" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" disabled>
                                <i class="fas fa-trash-alt mr-2"></i> Delete
                            </button>
                            <button type="button" id="resetConfig" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                <i class="fas fa-sync-alt mr-2"></i> Reset
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Basic Dashboard Information -->
                <div class="form-group">
                    <label for="dashboard_name">Dashboard Name:</label>
                    <input type="text" name="dashboard_name" id="dashboard_name" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="Enter dashboard name" required>
                </div>
                
                <!-- Direct script for template buttons and reset button -->
                <script>
                    // Direct implementation for template buttons
                    document.addEventListener('DOMContentLoaded', function() {
                        // Setup reset button directly
                        const resetBtn = document.getElementById('resetConfig');
                        if (resetBtn) {
                            resetBtn.addEventListener('click', function() {
                                if (confirm('Are you sure you want to reset all fields? All entered data will be lost.')) {
                                    document.getElementById('promptForm').reset();
                                    document.getElementById('dashboard_name').value = '';
                                    
                                    // Reset select fields to defaults
                                    const defaultSelects = {
                                        'dashboard_type': 'admin',
                                        'framework_type': 'bootstrap',
                                        'nav_type': 'sidebar',
                                        'layout_type': 'fixed',
                                        'color_scheme': 'blue'
                                    };
                                    
                                    // Apply template settings
                                    for (let id in defaultSelects) {
                                        const select = document.getElementById(id);
                                        if (select) select.value = defaultSelects[id];
                                    }
                                    
                                    // Reset pages to single default page
                                    const pagesContainer = document.getElementById('pages_container');
                                    if (pagesContainer) {
                                        const pages = pagesContainer.querySelectorAll('.dashboard-page');
                                        // Remove all but first page
                                        for (let i = pages.length - 1; i > 0; i--) {
                                            pages[i].remove();
                                        }
                                        
                                        // Reset first page
                                        if (pages.length > 0) {
                                            const nameInput = pages[0].querySelector('[name="page_names[]"]');
                                            const iconInput = pages[0].querySelector('[name="page_icons[]"]');
                                            const contentSelect = pages[0].querySelector('[name="page_contents[]"]');
                                            
                                            if (nameInput) nameInput.value = 'Dashboard Home';
                                            if (iconInput) iconInput.value = 'fa-home';
                                            if (contentSelect) contentSelect.value = 'summary';
                                        }
                                    }
                                    
                                    // Show success message
                                }
                            });
                        }
                        
                        // Setup template buttons directly
                        const templateButtons = document.querySelectorAll('.template-btn');
                        templateButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const templateType = this.getAttribute('data-template');
                                console.log('Template clicked:', templateType);
                                
                                // Simple template definitions
                                const templates = {
                                    'admin': {
                                        name: 'Administrative Dashboard',
                                        type: 'admin',
                                        framework: 'bootstrap',
                                        nav_type: 'sidebar',
                                        layout_type: 'fixed',
                                        color_scheme: 'blue'
                                    },
                                    'analytics': {
                                        name: 'Analytics Dashboard',
                                        type: 'analytics',
                                        framework: 'react',
                                        nav_type: 'horizontal', 
                                        layout_type: 'fluid',
                                        color_scheme: 'indigo'
                                    },
                                    'ecommerce': {
                                        name: 'E-Commerce Dashboard',
                                        type: 'ecommerce',
                                        framework: 'tailwind',
                                        nav_type: 'combined',
                                        layout_type: 'fluid',
                                        color_scheme: 'purple'
                                    },
                                    'project_mgmt': {
                                        name: 'Project Management Dashboard',
                                        type: 'project',
                                        framework: 'vue',
                                        nav_type: 'sidebar',
                                        layout_type: 'fluid',
                                        color_scheme: 'green'
                                    },
                                    'maintenance': {
                                        name: 'Maintenance Dashboard',
                                        type: 'custom',
                                        framework: 'bootstrap',
                                        nav_type: 'sidebar',
                                        layout_type: 'cards',
                                        color_scheme: 'blue'
                                    },
                                    'ml_project': {
                                        name: 'ML Project Dashboard',
                                        type: 'analytical',
                                        framework: 'react',
                                        nav_type: 'sidebar',
                                        layout_type: 'flexible',
                                        color_scheme: 'technical'
                                    }
                                };
                                
                                // Apply template if exists
                                const template = templates[templateType];
                                if (template) {
                                    document.getElementById('dashboard_name').value = template.name;
                                    
                                    // Apply template settings
                                    const inputs = {
                                        'dashboard_type': template.type,
                                        'framework_type': template.framework,
                                        'nav_type': template.nav_type,
                                        'layout_type': template.layout_type,
                                        'color_scheme': template.color_scheme
                                    };
                                    
                                    // Apply values to form
                                    for (let id in inputs) {
                                        const select = document.getElementById(id);
                                        if (select) select.value = inputs[id];
                                    }
                                    
                                    // Reset pages to single default page
                                    const pagesContainer = document.getElementById('pages_container');
                                    if (pagesContainer) {
                                        const pages = pagesContainer.querySelectorAll('.dashboard-page');
                                        // Remove all but first page
                                        for (let i = pages.length - 1; i > 0; i--) {
                                            pages[i].remove();
                                        }
                                        
                                        // Reset first page
                                        if (pages.length > 0) {
                                            const nameInput = pages[0].querySelector('[name="page_names[]"]');
                                            const iconInput = pages[0].querySelector('[name="page_icons[]"]');
                                            const contentSelect = pages[0].querySelector('[name="page_contents[]"]');
                                            
                                            if (nameInput) nameInput.value = 'Dashboard Home';
                                            if (iconInput) iconInput.value = 'fa-home';
                                            if (contentSelect) contentSelect.value = 'summary';
                                        }
                                    }
                                    
                                    // Show success message
                                }
                            });
                        });
                    });
                </script>
                
                <div class="form-group">
                    <label for="dashboard_type">Dashboard Type:</label>
                    <select name="dashboard_type" id="dashboard_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="admin">Admin Dashboard</option>
                        <option value="analytics">Analytics Dashboard</option>
                        <option value="ecommerce">E-Commerce Dashboard</option>
                        <option value="crm">CRM Dashboard</option>
                        <option value="project">Project Management Dashboard</option>
                        <option value="finance">Financial Dashboard</option>
                        <option value="custom">Custom Dashboard</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="framework_type">Framework:</label>
                    <select name="framework_type" id="framework_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="bootstrap">Bootstrap</option>
                        <option value="tailwind">Tailwind CSS</option>
                        <option value="material">Material UI</option>
                        <option value="chakra">Chakra UI</option>
                        <option value="react">React</option>
                        <option value="vue">Vue.js</option>
                        <option value="angular">Angular</option>
                        <option value="vanillajs">Vanilla JS</option>
                    </select>
                </div>
                
                <!-- Layout and Design Options -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="nav_type">Navigation Type:</label>
                        <select name="nav_type" id="nav_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="sidebar">Sidebar Menu</option>
                            <option value="horizontal">Horizontal Menu</option>
                            <option value="combined">Combined (Sidebar + Horizontal)</option>
                            <option value="mega">Mega Menu</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="layout_type">Layout Style:</label>
                        <select name="layout_type" id="layout_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                            <option value="fixed">Fixed Layout</option>
                            <option value="fluid">Fluid Layout</option>
                            <option value="boxed">Boxed Layout</option>
                            <option value="cards">Card-Based Layout</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="color_scheme">Color Scheme:</label>
                    <select name="color_scheme" id="color_scheme" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="blue">Blue (Professional)</option>
                        <option value="indigo">Indigo (Modern)</option>
                        <option value="purple">Purple (Creative)</option>
                        <option value="green">Green (Natural)</option>
                        <option value="red">Red (Bold)</option>
                        <option value="custom">Custom Color Scheme</option>
                    </select>
                </div>
                
                <!-- Feature Toggles -->
                <div class="form-group mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-database mr-2 text-blue-500"></i>
                        Dashboard Features
                    </h3>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="responsive_design" class="form-checkbox h-5 w-5 text-indigo-600" checked>
                            <span class="ml-2 feature-label">Responsive Design</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="dark_mode_support" class="form-checkbox h-5 w-5 text-indigo-600" checked>
                            <span class="ml-2 feature-label">Dark Mode Support</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="animation_effects" class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 feature-label">Animation Effects</span>
                        </label>
                    </div>
                </div>
                
                <!-- Dashboard Interactions & Behaviors -->
                <div class="form-group mt-6 border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-800 bg-opacity-30">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-hand-pointer mr-2 text-blue-500"></i>
                        Dashboard Interactions & Behaviors
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Define how users will interact with the dashboard</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-group">
                            <label for="interaction_type">Primary Interaction Type:</label>
                            <select name="interaction_type" id="interaction_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="click-based">Click-Based Navigation</option>
                                <option value="drag-drop">Drag and Drop Interface</option>
                                <option value="hover-based">Hover-Based Interactions</option>
                                <option value="mixed">Mixed Interaction Types</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="update_frequency">Data Update Frequency:</label>
                            <select name="update_frequency" id="update_frequency" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="manual">Manual Refresh Only</option>
                                <option value="periodic">Periodic Refresh (Interval Based)</option>
                                <option value="realtime">Real-Time Updates</option>
                                <option value="hybrid">Hybrid (Automatic + Manual)</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_filters" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Include Data Filters</span>
                            </label>
                            <select name="filter_type" id="filter_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="basic">Basic Filters</option>
                                <option value="advanced">Advanced Filters</option>
                                <option value="searchbar">Search Bar Only</option>
                                <option value="combined">Combined (Search + Filters)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_export" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Data Export Options</span>
                            </label>
                            <select name="export_formats" id="export_formats" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="csv">CSV Only</option>
                                <option value="excel">Excel Only</option>
                                <option value="pdf">PDF Only</option>
                                <option value="multiple">Multiple Formats</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Advanced Dashboard Behaviors -->
                <div class="form-group mt-3 border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-800 bg-opacity-30">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-sliders-h mr-2 text-purple-500"></i>
                        Advanced Behaviors & Customization
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Configure advanced dashboard behaviors and user customization options</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="customizable_layout" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">User Customizable Layout</span>
                            </label>
                            <select name="customization_level" id="customization_level" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="none">No Customization</option>
                                <option value="basic">Basic (Rearrange Widgets)</option>
                                <option value="moderate">Moderate (Rearrange + Resize)</option>
                                <option value="advanced">Advanced (Full Customization)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="save_user_preferences" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Save User Preferences</span>
                            </label>
                            <select name="preference_storage" id="preference_storage" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="local">Local Storage</option>
                                <option value="cookies">Cookies</option>
                                <option value="server">Server-Side Storage</option>
                                <option value="mixed">Mixed Storage</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_notifications" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Include Notifications System</span>
                            </label>
                            <select name="notification_type" id="notification_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="toast">Toast Notifications</option>
                                <option value="popup">Pop-up Modals</option>
                                <option value="inline">Inline Notifications</option>
                                <option value="bell">Notification Bell</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_alerts" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Include Data Alerts</span>
                            </label>
                            <select name="alert_trigger" id="alert_trigger" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="threshold">Threshold-Based Alerts</option>
                                <option value="change">Data Change Alerts</option>
                                <option value="schedule">Scheduled Alerts</option>
                                <option value="anomaly">Anomaly Detection</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- Data Sources & Integration -->
                <div class="form-group mt-3 border border-gray-200 dark:border-gray-700 rounded-md p-4 bg-gray-50 dark:bg-gray-800 bg-opacity-30">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-database mr-2 text-green-500"></i>
                        Data Sources & Integration
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Define how the dashboard will connect to and integrate with data sources</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-group">
                            <label for="data_source_type">Primary Data Source:</label>
                            <select name="data_source_type" id="data_source_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="api">REST API</option>
                                <option value="graphql">GraphQL API</option>
                                <option value="database">Direct Database Connection</option>
                                <option value="static">Static Data (JSON/CSV)</option>
                                <option value="websocket">WebSocket (Streaming)</option>
                                <option value="mixed">Multiple Sources</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="authentication_type">Data Source Authentication:</label>
                            <select name="authentication_type" id="authentication_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="none">No Authentication</option>
                                <option value="apikey">API Key</option>
                                <option value="oauth">OAuth 2.0</option>
                                <option value="jwt">JWT Tokens</option>
                                <option value="basic">Basic Auth</option>
                                <option value="custom">Custom Authentication</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_caching" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Enable Data Caching</span>
                            </label>
                            <select name="caching_strategy" id="caching_strategy" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="session">Session-Based Cache</option>
                                <option value="memory">In-Memory Cache</option>
                                <option value="localstorage">LocalStorage Cache</option>
                                <option value="server">Server-Side Cache</option>
                                <option value="hybrid">Hybrid Caching</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="flex items-center mb-2">
                                <input type="checkbox" name="include_offline" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Offline Support</span>
                            </label>
                            <select name="offline_behavior" id="offline_behavior" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="none">No Offline Support</option>
                                <option value="readonly">Read-Only Offline Mode</option>
                                <option value="readwrite">Read-Write with Sync</option>
                                <option value="limited">Limited Functionality</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <label class="flex items-center mb-2">
                            <input type="checkbox" name="include_error_handling" class="form-checkbox h-5 w-5 text-indigo-600">
                            <span class="ml-2 feature-label">Advanced Error Handling</span>
                        </label>
                        <div class="flex flex-wrap gap-3 mt-2">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="error_retry" class="form-checkbox h-4 w-4 text-indigo-600">
                                <span class="ml-2 text-sm">Auto-Retry</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="error_fallback" class="form-checkbox h-4 w-4 text-indigo-600">
                                <span class="ml-2 text-sm">Fallback Data</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="error_user_feedback" class="form-checkbox h-4 w-4 text-indigo-600">
                                <span class="ml-2 text-sm">User Feedback</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="error_logging" class="form-checkbox h-4 w-4 text-indigo-600">
                                <span class="ml-2 text-sm">Detailed Logging</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <!-- Dashboard Pages Section -->
                <div class="form-group mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-file-alt mr-2 text-green-500"></i>
                        Dashboard Pages
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Add pages that will be included in your dashboard</p>
                    
                    <div id="pages_container" class="space-y-4">
                        <!-- Template for a dashboard page -->
                        <div class="dashboard-page">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div class="form-group">
                                    <label>Page Name:</label>
                                    <input type="text" name="page_names[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="e.g. Dashboard Home">
                                </div>
                                <div class="form-group">
                                    <label>Icon (FontAwesome):</label>
                                    <input type="text" name="page_icons[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="e.g. fa-home">
                                </div>
                                <div class="form-group">
                                    <label>Page Content & Function:</label>
                                    <select name="page_contents[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                        <option value="summary">Summary/Overview</option>
                                        <option value="charts">Charts & Graphs</option>
                                        <option value="tables">Data Tables</option>
                                        <option value="forms">Forms</option>
                                        <option value="settings">Settings</option>
                                        <option value="mixed">Mixed Content</option>
                                        <option value="home">Home Page</option>
                                        <option value="dashboard">Dashboard</option>
                                        <option value="login">Login Page</option>
                                        <option value="register">Register Page</option>
                                        <option value="profile">Profile Page</option>
                                        <option value="analytics">Analytics Page</option>
                                        <option value="reports">Reports Page</option>
                                        <option value="users">Users Management</option>
                                        <option value="products">Products Page</option>
                                        <option value="notifications">Notifications</option>
                                        <option value="messages">Messages</option>
                                        <option value="calendar">Calendar</option>
                                        <option value="about">About Us</option>
                                        <option value="contact">Contact Us</option>
                                        <option value="privacy">Privacy Policy</option>
                                        <option value="terms">Terms & Conditions</option>
                                        <option value="faq">FAQ</option>
                                        <option value="404">404 Page</option>
                                        <option value="500">500 Page</option>
                                        <option value="403">403 Page</option>
                                        <option value="401">401 Page</option>
                                        <option value="400">400 Page</option>
                                        <option value="301">301 Page</option>
                                        <option value="302">302 Page</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" class="delete-btn">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" id="addPageBtn" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium hover:bg-indigo-50 dark:hover:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <i class="fas fa-plus mr-2"></i> Add Page
                        </button>
                    </div>
                </div>
                
                <!-- Component Selections -->
                <div class="form-group mt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-puzzle-piece mr-2 text-purple-500"></i>
                        Dashboard Components
                    </h3>
                    <p class="text-sm text-gray-500 mb-4">Select components to include in your dashboard</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-group">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="include_charts" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Charts & Graphs</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-7">Include interactive data visualization charts</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="include_tables" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Data Tables</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-7">Include sortable and filterable data tables</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="include_cards" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Info Cards</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-7">Include metric cards for key information</p>
                        </div>
                        
                        <div class="form-group">
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="include_stats" class="form-checkbox h-5 w-5 text-indigo-600">
                                <span class="ml-2 feature-label">Statistics & Summary</span>
                            </label>
                            <p class="text-xs text-gray-500 mt-1 ml-7">Include statistical summary panels</p>
                        </div>
                    </div>
                </div>
                
                <!-- Extension Header/Footer -->
                <div class="form-group border-t pt-4 mt-4">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                        <i class="fas fa-code mr-2 text-yellow-500"></i>
                        Additional Specifications
                    </h3>
                    
                    <div class="form-group">
                        <label for="extension_header">Additional Requirements (Prepend):</label>
                        <textarea name="extension_header" id="extension_header" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-24" placeholder="Additional text to add at the beginning of the prompt"></textarea>
                        <p class="mt-1 text-sm text-gray-500">This text will be added before the main prompt content.</p>
                    </div>
                    
                    <div class="form-group">
                        <label for="extension_footer">Additional Requirements (Append):</label>
                        <textarea name="extension_footer" id="extension_footer" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-24" placeholder="Additional text to add at the end of the prompt"></textarea>
                        <p class="mt-1 text-sm text-gray-500">This text will be added after the main prompt content.</p>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="mt-6 flex flex-wrap gap-3">
                    <button type="button" id="showPromptAreaBtn" class="button btn-primary" onclick="showPromptArea(); return false;">
                        <i class="fas fa-magic"></i> Generate Prompt
                    </button>
                </div>
            </form>
        </div>
        
        <!-- AI Prompt Area (initially hidden) -->
        <div id="aiPromptArea" class="card mt-6" style="display: none;">
            <div class="card-title">
                <i class="fas fa-robot"></i>
                <span>AI Prompt Input</span>
            </div>
            <div class="mt-4 relative">
                <textarea id="aiPromptText" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md h-64" placeholder="Enter your AI prompt here..."></textarea>
                <button type="button" id="copyPromptBtn" class="absolute top-2 right-2 bg-gray-700 hover:bg-gray-800 text-white p-2 rounded opacity-70 hover:opacity-100 transition-opacity" title="Copy to clipboard" onclick="copyPromptText()">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
            <div class="mt-4 flex justify-between">
                <button type="button" id="backToDashboardBtn" class="button" onclick="showDashboard()">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </button>
                <button type="button" id="submitAiPromptBtn" class="button btn-secondary">
                    <i class="fas fa-paper-plane"></i> Send to AI
                </button>
            </div>
        </div>
        
        <?php if ($formSubmitted): ?>
        <!-- Display Final Prompt -->
        <div class="card">
            <div class="card-title">
                <i class="fas fa-file-alt"></i>
                <span>Your Dashboard Design</span>
            </div>
            <div class="mt-4">
                <p class="text-gray-700 dark:text-gray-300">
                    Your dashboard design has been generated. Please check the results on the next page.
                </p>
            </div>
            
            <!-- Back to Form Button -->
            <div class="mt-6">
                <a href="dashboardbuilder.php" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Dashboard Builder
                </a>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Scripts -->
        <script>
            // Copy prompt text to clipboard
            function copyPromptText() {
                const textarea = document.getElementById('aiPromptText');
                if (textarea) {
                    textarea.select();
                    document.execCommand('copy');
                    
                    // Visual feedback
                    const copyBtn = document.getElementById('copyPromptBtn');
                    if (copyBtn) {
                        copyBtn.innerHTML = '<i class="fas fa-check"></i>';
                        copyBtn.classList.add('bg-green-600');
                        
                        setTimeout(() => {
                            copyBtn.innerHTML = '<i class="fas fa-copy"></i>';
                            copyBtn.classList.remove('bg-green-600');
                        }, 1500);
                    }
                }
            }
            
            // Global functions for toggling between dashboard and prompt area
            function showPromptArea() {
                console.log('showPromptArea function called');
                const dashboardForm = document.querySelector('.card form').closest('.card');
                const aiPromptArea = document.getElementById('aiPromptArea');
                
                console.log('dashboardForm element:', dashboardForm);
                console.log('aiPromptArea element:', aiPromptArea);
                
                if (dashboardForm) dashboardForm.style.display = 'none';
                if (aiPromptArea) {
                    aiPromptArea.style.display = 'block';
                    const promptTextArea = document.getElementById('aiPromptText');
                    console.log('promptTextArea element:', promptTextArea);
                    
                    if (promptTextArea) {
                        try {
                            // Generate the complete prompt with all stages combined
                            const generatedPrompt = generateStageSevenPrompt();
                            console.log('About to set complete prompt, generated text length:', generatedPrompt.length);
                            promptTextArea.value = generatedPrompt;
                            console.log('Complete prompt set successfully, textarea value length:', promptTextArea.value.length);
                            promptTextArea.focus();
                        } catch (error) {
                            console.error('Error generating or setting prompt:', error);
                        }
                    } else {
                        console.error('promptTextArea element not found');
                    }
                    
                    aiPromptArea.scrollIntoView({ behavior: 'smooth' });
                } else {
                    console.error('aiPromptArea element not found');
                }
            }
            
            // Function to generate prompt for Stage 1: Basic Info & Design
            function generateStageOnePrompt() {
                console.log('generateStageOnePrompt function called');
                
                // Get form values
                const dashboardName = document.getElementById('dashboard_name').value || '[Dashboard Name]';
                const dashboardType = document.getElementById('dashboard_type').options[document.getElementById('dashboard_type').selectedIndex].text || '[Dashboard Type]';
                const frameworkType = document.getElementById('framework_type').options[document.getElementById('framework_type').selectedIndex].text || '[Framework]';
                const navType = document.getElementById('nav_type').options[document.getElementById('nav_type').selectedIndex].text || '[Navigation Type]';
                const layoutType = document.getElementById('layout_type').options[document.getElementById('layout_type').selectedIndex].text || '[Layout Style]';
                const colorScheme = document.getElementById('color_scheme').options[document.getElementById('color_scheme').selectedIndex].text || '[Color Scheme]';
                
                console.log('Form values retrieved:', { dashboardName, dashboardType, frameworkType, navType, layoutType, colorScheme });
                
                // Check checkbox values
                const responsiveDesign = document.querySelector('input[name="responsive_design"]')?.checked || false;
                const darkModeSupport = document.querySelector('input[name="dark_mode_support"]')?.checked || false;
                const animationEffects = document.querySelector('input[name="animation_effects"]')?.checked || false;
                
                console.log('Checkbox values:', { responsiveDesign, darkModeSupport, animationEffects });
                
                // Build features text
                let featuresText = '';
                if (responsiveDesign) {
                    featuresText += '- Responsive design that works on all screen sizes\n';
                }
                if (darkModeSupport) {
                    featuresText += '- Full dark mode support with toggle functionality\n';
                }
                if (animationEffects) {
                    featuresText += '- Advanced animation effects to enhance user experience\n';
                }
                if (!featuresText) {
                    featuresText = '- No additional features specified';
                }
                
                // Construct the prompt
                const prompt = `Please create a dashboard named "${dashboardName}". This dashboard should be a "${dashboardType}" type using "${frameworkType}" framework.

For the design, please use a "${navType}" navigation style with a "${layoutType}" layout. The primary color scheme for the dashboard should be "${colorScheme}".

The core features required include:
${featuresText}

Please provide the initial design for the basic interface based on this information, explaining how the navigation and content elements will be organized according to the specified type and framework.`;
                
                console.log('Generated prompt:', prompt);
                return prompt;
            }
            
            function showDashboard() {
                console.log('showDashboard function called');
                const dashboardForm = document.querySelector('.card form').closest('.card');
                const aiPromptArea = document.getElementById('aiPromptArea');
                
                if (aiPromptArea) aiPromptArea.style.display = 'none';
                if (dashboardForm) {
                    dashboardForm.style.display = 'block';
                    dashboardForm.scrollIntoView({ behavior: 'smooth' });
                }
            }
            
            // Function to generate prompt for Stage 2: Interactions & Behaviors
            function generateStageTwoPrompt() {
                console.log('generateStageTwoPrompt function called');
                
                // Get form values for interactions
                const interactionType = document.getElementById('interaction_type')?.options[document.getElementById('interaction_type')?.selectedIndex]?.text || '[Interaction Type]';
                const updateFrequency = document.getElementById('update_frequency')?.options[document.getElementById('update_frequency')?.selectedIndex]?.text || '[Update Frequency]';
                
                // Check filter values
                const includeFilters = document.querySelector('input[name="include_filters"]')?.checked || false;
                const filterType = includeFilters ? 
                    document.getElementById('filter_type')?.options[document.getElementById('filter_type')?.selectedIndex]?.text || '[Filter Type]' : 
                    'None';
                
                // Check export values
                const includeExport = document.querySelector('input[name="include_export"]')?.checked || false;
                const exportFormats = includeExport ? 
                    document.getElementById('export_formats')?.options[document.getElementById('export_formats')?.selectedIndex]?.text || '[Export Formats]' : 
                    'None';
                
                console.log('Interaction values:', { interactionType, updateFrequency, includeFilters, filterType, includeExport, exportFormats });
                
                // Construct the prompt
                const prompt = `For the dashboard interactions and behaviors:

1. Primary Interaction Type: "${interactionType}"
   This will determine how users primarily interact with the dashboard elements.

2. Data Update Frequency: "${updateFrequency}"
   This defines how frequently the dashboard data will refresh.

${includeFilters ? `3. Data Filters: Enabled
   Filter Type: "${filterType}"
   The dashboard should include data filtering capabilities.` : `3. Data Filters: Disabled
   The dashboard will not include data filtering capabilities.`}

${includeExport ? `4. Data Export Options: Enabled
   Export Formats: "${exportFormats}"
   Users should be able to export dashboard data.` : `4. Data Export Options: Disabled
   The dashboard will not include data export functionality.`}

Please implement these interaction patterns to create an intuitive and user-friendly experience, ensuring that the dashboard's behavior aligns with these specifications.`;
                
                console.log('Generated Stage 2 prompt:', prompt);
                return prompt;
            }
            
            // Function to generate prompt for Stage 3: Advanced Behaviors & Customization
            function generateStageThreePrompt() {
                console.log('generateStageThreePrompt function called');
                
                // Get customizable layout values
                const customizableLayout = document.querySelector('input[name="customizable_layout"]')?.checked || false;
                const customizationLevel = customizableLayout ? 
                    document.getElementById('customization_level')?.options[document.getElementById('customization_level')?.selectedIndex]?.text || '[Customization Level]' : 
                    'None';
                
                // Get user preferences storage values
                const saveUserPreferences = document.querySelector('input[name="save_user_preferences"]')?.checked || false;
                const preferenceStorage = saveUserPreferences ? 
                    document.getElementById('preference_storage')?.options[document.getElementById('preference_storage')?.selectedIndex]?.text || '[Preference Storage]' : 
                    'None';
                
                // Get notification system values
                const includeNotifications = document.querySelector('input[name="include_notifications"]')?.checked || false;
                const notificationType = includeNotifications ? 
                    document.getElementById('notification_type')?.options[document.getElementById('notification_type')?.selectedIndex]?.text || '[Notification Type]' : 
                    'None';
                
                // Get data alerts values
                const includeAlerts = document.querySelector('input[name="include_alerts"]')?.checked || false;
                const alertTrigger = includeAlerts ? 
                    document.getElementById('alert_trigger')?.options[document.getElementById('alert_trigger')?.selectedIndex]?.text || '[Alert Trigger]' : 
                    'None';
                
                console.log('Advanced behaviors values:', { 
                    customizableLayout, customizationLevel, 
                    saveUserPreferences, preferenceStorage, 
                    includeNotifications, notificationType, 
                    includeAlerts, alertTrigger 
                });
                
                // Construct the prompt
                const prompt = `For the advanced dashboard behaviors and customization options:

1. User Customizable Layout: ${customizableLayout ? 'Enabled' : 'Disabled'}
${customizableLayout ? `   Customization Level: "${customizationLevel}"
   Users will be able to customize the dashboard layout according to this level of flexibility.` : '   The dashboard will have a fixed layout that cannot be customized by users.'}

2. User Preferences Storage: ${saveUserPreferences ? 'Enabled' : 'Disabled'}
${saveUserPreferences ? `   Storage Method: "${preferenceStorage}"
   The system will save user preferences using this storage method, allowing for a personalized experience across sessions.` : '   User preferences will not be saved between sessions.'}

3. Notification System: ${includeNotifications ? 'Enabled' : 'Disabled'}
${includeNotifications ? `   Notification Type: "${notificationType}"
   The dashboard will include a notification system to alert users of important events or changes.` : '   The dashboard will not include a notification system.'}

4. Data Alerts: ${includeAlerts ? 'Enabled' : 'Disabled'}
${includeAlerts ? `   Alert Trigger Type: "${alertTrigger}"
   The system will monitor data and trigger alerts based on this alert mechanism.` : '   The dashboard will not include data-driven alerts.'}

Please implement these advanced behaviors to enhance the dashboard's functionality and user experience, ensuring that the customization options and notification systems work seamlessly within the overall design.`;
                
                console.log('Generated Stage 3 prompt:', prompt);
                return prompt;
            }
            
            // Function to generate prompt for Stage 4: Data Sources & Integration
            function generateStageFourPrompt() {
                console.log('generateStageFourPrompt function called');
                
                // Get data source type values
                const dataSourceType = document.getElementById('data_source_type')?.options[document.getElementById('data_source_type')?.selectedIndex]?.text || '[Data Source Type]';
                const authenticationType = document.getElementById('authentication_type')?.options[document.getElementById('authentication_type')?.selectedIndex]?.text || '[Authentication Type]';
                
                // Get caching values
                const includeCaching = document.querySelector('input[name="include_caching"]')?.checked || false;
                const cachingStrategy = includeCaching ? 
                    document.getElementById('caching_strategy')?.options[document.getElementById('caching_strategy')?.selectedIndex]?.text || '[Caching Strategy]' : 
                    'None';
                
                // Get offline support values
                const includeOffline = document.querySelector('input[name="include_offline"]')?.checked || false;
                const offlineBehavior = includeOffline ? 
                    document.getElementById('offline_behavior')?.options[document.getElementById('offline_behavior')?.selectedIndex]?.text || '[Offline Behavior]' : 
                    'None';
                
                // Get error handling values
                const includeErrorHandling = document.querySelector('input[name="include_error_handling"]')?.checked || false;
                const errorRetry = document.querySelector('input[name="error_retry"]')?.checked || false;
                const errorFallback = document.querySelector('input[name="error_fallback"]')?.checked || false;
                const errorUserFeedback = document.querySelector('input[name="error_user_feedback"]')?.checked || false;
                const errorLogging = document.querySelector('input[name="error_logging"]')?.checked || false;
                
                console.log('Data sources values:', { 
                    dataSourceType, authenticationType, 
                    includeCaching, cachingStrategy, 
                    includeOffline, offlineBehavior, 
                    includeErrorHandling, errorRetry, errorFallback, errorUserFeedback, errorLogging 
                });
                
                // Build error handling text
                let errorHandlingText = '';
                if (includeErrorHandling) {
                    errorHandlingText += '   Error handling features will include:\n';
                    if (errorRetry) errorHandlingText += '   - Automatic retry mechanisms for failed requests\n';
                    if (errorFallback) errorHandlingText += '   - Fallback data options when primary sources fail\n';
                    if (errorUserFeedback) errorHandlingText += '   - User-friendly error messages and feedback\n';
                    if (errorLogging) errorHandlingText += '   - Detailed error logging for troubleshooting\n';
                    
                    if (!errorRetry && !errorFallback && !errorUserFeedback && !errorLogging) {
                        errorHandlingText += '   - Basic error handling (no specific features selected)\n';
                    }
                }
                
                // Construct the prompt
                const prompt = `For the dashboard data sources and integration:

1. Primary Data Source: "${dataSourceType}"
   This defines how the dashboard will source its data.

2. Authentication Method: "${authenticationType}"
   This specifies how the dashboard will authenticate with data sources.

3. Data Caching: ${includeCaching ? 'Enabled' : 'Disabled'}
${includeCaching ? `   Caching Strategy: "${cachingStrategy}"
   The dashboard will implement caching to optimize performance and reduce data source load.` : '   The dashboard will not implement caching and will always fetch fresh data.'}

4. Offline Support: ${includeOffline ? 'Enabled' : 'Disabled'}
${includeOffline ? `   Offline Mode Behavior: "${offlineBehavior}"
   The dashboard will provide functionality when offline according to this behavior pattern.` : '   The dashboard will require an active connection to function.'}

5. Error Handling: ${includeErrorHandling ? 'Advanced' : 'Basic'}
${includeErrorHandling ? errorHandlingText : '   The dashboard will implement basic error handling only.'}

Please implement these data source and integration patterns to ensure reliable data flow, appropriate authentication, and robust error handling. The dashboard should manage data in a way that maximizes performance and reliability according to these specifications.`;
                
                console.log('Generated Stage 4 prompt:', prompt);
                return prompt;
            }
            
            // Function to generate prompt for Stage 5: Dashboard Pages
            function generateStageFivePrompt() {
                console.log('generateStageFivePrompt function called');
                
                // Get page information from the form
                const pageContainer = document.getElementById('pages_container');
                const pages = pageContainer ? pageContainer.querySelectorAll('.dashboard-page') : [];
                
                console.log('Found ' + pages.length + ' dashboard pages');
                
                // Build pages text
                let pagesText = '';
                
                if (pages.length > 0) {
                    // Loop through each page and extract its data
                    pages.forEach((page, index) => {
                        const pageName = page.querySelector('[name="page_names[]"]')?.value || `[Page ${index + 1}]`;
                        const pageIcon = page.querySelector('[name="page_icons[]"]')?.value || '[No Icon]';
                        const pageContentSelect = page.querySelector('[name="page_contents[]"]');
                        const pageContent = pageContentSelect ? 
                            pageContentSelect.options[pageContentSelect.selectedIndex]?.text || '[Page Content]' : 
                            '[Page Content]';
                        
                        pagesText += `Page ${index + 1}: "${pageName}"\n`;
                        pagesText += `   Icon: ${pageIcon}\n`;
                        pagesText += `   Content Type: ${pageContent}\n\n`;
                    });
                } else {
                    pagesText = "No dashboard pages have been specified. A default dashboard home page should be created.\n";
                }
                
                // Construct the prompt
                const prompt = `For the dashboard navigation and page structure:

The dashboard should include the following pages:

${pagesText}
Each page should have appropriate navigation elements, content layout, and functionality according to its designated content type. The pages should be accessible from the navigation system specified earlier (${document.getElementById('nav_type')?.options[document.getElementById('nav_type')?.selectedIndex]?.text || 'Navigation Type'}).

The navigation should clearly indicate the current active page and provide intuitive ways to move between pages. Icons should be implemented using the appropriate icon library (Font Awesome recommended).

Each page's content should be organized according to its purpose, with appropriate components, layouts, and functionality for its designated content type. Pages should maintain consistent design language while serving their specific purposes.`;
                
                console.log('Generated Stage 5 prompt:', prompt);
                return prompt;
            }
            
            // Function to generate prompt for Stage 6: Dashboard Components
            function generateStageSixPrompt() {
                console.log('generateStageSixPrompt function called');
                
                // Check component checkboxes
                const includeCharts = document.querySelector('input[name="include_charts"]')?.checked || false;
                const includeTables = document.querySelector('input[name="include_tables"]')?.checked || false;
                const includeCards = document.querySelector('input[name="include_cards"]')?.checked || false;
                const includeStats = document.querySelector('input[name="include_stats"]')?.checked || false;
                
                console.log('Component values:', { includeCharts, includeTables, includeCards, includeStats });
                
                // Build components text
                let componentsText = '';
                let componentNumber = 1;
                
                if (includeCharts) {
                    componentsText += `${componentNumber}. Charts & Graphs\n`;
                    componentsText += "   The dashboard should include interactive data visualization charts to represent key metrics and data points. These visualizations should be responsive and user-friendly, providing clear insights into the data.\n\n";
                    componentNumber++;
                }
                
                if (includeTables) {
                    componentsText += `${componentNumber}. Data Tables\n`;
                    componentsText += "   The dashboard should incorporate data tables for displaying detailed information. These tables should support sorting, filtering, and pagination functionality to enable users to efficiently navigate and analyze the displayed data.\n\n";
                    componentNumber++;
                }
                
                if (includeCards) {
                    componentsText += `${componentNumber}. Info Cards\n`;
                    componentsText += "   The dashboard should feature information cards to highlight key metrics and important statistics. These cards should be visually distinct, present information clearly, and potentially include trend indicators or comparisons to previous periods.\n\n";
                    componentNumber++;
                }
                
                if (includeStats) {
                    componentsText += `${componentNumber}. Statistics & Summary Panels\n`;
                    componentsText += "   The dashboard should contain statistical summary panels that provide aggregated data and insights. These components should effectively communicate performance metrics, trends, and other critical information at a glance.\n\n";
                    componentNumber++;
                }
                
                if (!componentsText) {
                    componentsText = "No specific dashboard components have been selected. The dashboard should include basic components necessary for its function based on the dashboard type and content requirements.\n";
                }
                
                // Construct the prompt
                const prompt = `For the dashboard components and visualization elements:

The dashboard should incorporate the following key components:

${componentsText}
These components should be implemented using the appropriate libraries and tools compatible with the selected framework (${document.getElementById('framework_type')?.options[document.getElementById('framework_type')?.selectedIndex]?.text || 'Framework'}). The design should maintain visual consistency with the overall dashboard style and color scheme (${document.getElementById('color_scheme')?.options[document.getElementById('color_scheme')?.selectedIndex]?.text || 'Color Scheme'}).

All components should be responsive, accessible, and optimized for performance. The organization and placement of these elements should follow best practices for dashboard design, ensuring a logical information hierarchy and intuitive user experience.

For interactive elements, ensure that the interactions align with the specified interaction pattern (${document.getElementById('interaction_type')?.options[document.getElementById('interaction_type')?.selectedIndex]?.text || 'Interaction Type'}) and provide appropriate feedback to the user.`;
                
                console.log('Generated Stage 6 prompt:', prompt);
                return prompt;
            }
            
            // Function to generate prompt for Stage 7: Additional Specifications
            function generateStageSevenPrompt() {
                console.log('generateStageSevenPrompt function called');
                
                // Get additional specifications from form
                const extensionHeader = document.getElementById('extension_header')?.value || '';
                const extensionFooter = document.getElementById('extension_footer')?.value || '';
                
                console.log('Additional specifications:', { 
                    headerLength: extensionHeader.length,
                    footerLength: extensionFooter.length
                });
                
                // Combine all previous stages
                let fullPrompt = '';
                
                // Add extension header if provided
                if (extensionHeader.trim()) {
                    fullPrompt += extensionHeader.trim() + '\n\n';
                }
                
                // Add basic info
                fullPrompt += generateStageOnePrompt() + '\n\n';
                
                // Add interactions and behaviors
                fullPrompt += generateStageTwoPrompt() + '\n\n';
                
                // Add advanced behaviors
                fullPrompt += generateStageThreePrompt() + '\n\n';
                
                // Add data sources
                fullPrompt += generateStageFourPrompt() + '\n\n';
                
                // Add pages
                fullPrompt += generateStageFivePrompt() + '\n\n';
                
                // Add components
                fullPrompt += generateStageSixPrompt() + '\n\n';
                
                // Add extension footer if provided
                if (extensionFooter.trim()) {
                    fullPrompt += extensionFooter.trim() + '\n\n';
                }
                
                // Add final instructions
                fullPrompt += `Please implement this dashboard according to all the specifications above. Ensure that all aspects work together cohesively, with consistent design language, interaction patterns, and data flow throughout the application.

The dashboard should be well-commented, follow best practices for the chosen framework, and be optimized for performance, accessibility, and user experience.`;
                
                console.log('Generated complete prompt, length:', fullPrompt.length);
                return fullPrompt;
            }
            
            // Navigation functions for multi-stage prompt building
            function goToNextStage() {
                console.log('Going to next stage, current stage:', window.currentStage);
                
                if (window.currentStage < 7) {
                    window.currentStage++;
                    updateStageUI();
                    
                    // Generate prompt based on new stage
                    const promptTextArea = document.getElementById('aiPromptText');
                    if (promptTextArea) {
                        try {
                            let generatedPrompt = '';
                            
                            // Generate appropriate prompt based on stage
                            switch (window.currentStage) {
                                case 1:
                                    generatedPrompt = generateStageOnePrompt();
                                    break;
                                case 2:
                                    generatedPrompt = generateStageTwoPrompt();
                                    break;
                                case 3:
                                    generatedPrompt = generateStageThreePrompt();
                                    break;
                                case 4:
                                    generatedPrompt = generateStageFourPrompt();
                                    break;
                                case 5:
                                    generatedPrompt = generateStageFivePrompt();
                                    break;
                                case 6:
                                    generatedPrompt = generateStageSixPrompt();
                                    break;
                                case 7:
                                    generatedPrompt = generateStageSevenPrompt();
                                    break;
                                default:
                                    generatedPrompt = "This stage is not yet implemented.";
                                    break;
                            }
                            
                            promptTextArea.value = generatedPrompt;
                            promptTextArea.focus();
                        } catch (error) {
                            console.error('Error generating prompt for stage', window.currentStage, error);
                        }
                    }
                }
            }
            
            function goToPreviousStage() {
                console.log('Going to previous stage, current stage:', window.currentStage);
                
                if (window.currentStage > 1) {
                    window.currentStage--;
                    updateStageUI();
                    
                    // Generate prompt based on new stage
                    const promptTextArea = document.getElementById('aiPromptText');
                    if (promptTextArea) {
                        try {
                            let generatedPrompt = '';
                            
                            // Generate appropriate prompt based on stage
                            switch (window.currentStage) {
                                case 1:
                                    generatedPrompt = generateStageOnePrompt();
                                    break;
                                case 2:
                                    generatedPrompt = generateStageTwoPrompt();
                                    break;
                                case 3:
                                    generatedPrompt = generateStageThreePrompt();
                                    break;
                                case 4:
                                    generatedPrompt = generateStageFourPrompt();
                                    break;
                                case 5:
                                    generatedPrompt = generateStageFivePrompt();
                                    break;
                                case 6:
                                    generatedPrompt = generateStageSixPrompt();
                                    break;
                                case 7:
                                    generatedPrompt = generateStageSevenPrompt();
                                    break;
                                default:
                                    generatedPrompt = "This stage is not yet implemented.";
                                    break;
                            }
                            
                            promptTextArea.value = generatedPrompt;
                            promptTextArea.focus();
                        } catch (error) {
                            console.error('Error generating prompt for stage', window.currentStage, error);
                        }
                    }
                }
            }
            
            // Update UI based on current stage
            function updateStageUI() {
                // Update stage number display
                const currentStageElement = document.getElementById('currentStage');
                if (currentStageElement) {
                    currentStageElement.textContent = window.currentStage;
                }
                
                // Update stage description
                const stageDescription = document.getElementById('stageDescription');
                if (stageDescription) {
                    switch (window.currentStage) {
                        case 1:
                            stageDescription.textContent = 'Basic Info & Design';
                            break;
                        case 2:
                            stageDescription.textContent = 'Interactions & Behaviors';
                            break;
                        case 3:
                            stageDescription.textContent = 'Advanced Behaviors & Customization';
                            break;
                        case 4:
                            stageDescription.textContent = 'Data Sources & Integration';
                            break;
                        case 5:
                            stageDescription.textContent = 'Dashboard Pages';
                            break;
                        case 6:
                            stageDescription.textContent = 'Dashboard Components';
                            break;
                        case 7:
                            stageDescription.textContent = 'Additional Specifications';
                            break;
                        default:
                            stageDescription.textContent = 'Unknown Stage';
                    }
                }
                
                // Update stage indicators
                for (let i = 1; i <= 7; i++) {
                    const indicator = document.getElementById(`stage${i}Indicator`);
                    if (indicator) {
                        if (i === window.currentStage) {
                            indicator.classList.remove('bg-gray-300');
                            indicator.classList.add('bg-indigo-600');
                        } else if (i < window.currentStage) {
                            indicator.classList.remove('bg-gray-300');
                            indicator.classList.add('bg-green-500');
                        } else {
                            indicator.classList.remove('bg-indigo-600', 'bg-green-500');
                            indicator.classList.add('bg-gray-300');
                        }
                    }
                }
                
                // Update navigation buttons
                const prevButton = document.getElementById('prevStageBtn');
                const nextButton = document.getElementById('nextStageBtn');
                
                if (prevButton) {
                    prevButton.disabled = window.currentStage === 1;
                }
                
                if (nextButton) {
                    nextButton.disabled = window.currentStage === 7;
                }
            }
            
            // Initialize when document is ready
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Document loaded, initializing dashboard builder...');
                
                // Set up current stage tracking
                window.currentStage = 1;
                
                // Test accessing key elements
                console.log('Reset button exists:', !!document.getElementById('resetConfig'));
                console.log('Template buttons exist:', document.querySelectorAll('.template-btn').length > 0);
                
                // Check if our new elements exist
                console.log('Show Prompt Area Button exists:', !!document.getElementById('showPromptAreaBtn'));
                console.log('Back to Dashboard Button exists:', !!document.getElementById('backToDashboardBtn'));
                console.log('AI Prompt Area exists:', !!document.getElementById('aiPromptArea'));
                
                // Setup form configuration management
                setupFormConfigManagement();
                
                // Setup page management
                setupPageManagement();
                
                // Setup reset button functionality
                setupResetButton();
                
                // Setup sharing functionality
                // Removed setupSocialSharing call
                
                // Setup template buttons
                setupTemplateButtons();
                
                // Setup live preview
                // Removed setupPreview call
                
                // Create particles effect
                createParticles();
                
                // Add error styles
                addErrorStyles();
                
                // Setup auto save for form progress
                setupAutoSave();
                
                // Direct implementation for prompt area toggling
                const showPromptAreaBtn = document.getElementById('showPromptAreaBtn');
                const backToDashboardBtn = document.getElementById('backToDashboardBtn');
                const aiPromptArea = document.getElementById('aiPromptArea');
                const dashboardForm = document.querySelector('.card form').closest('.card');
                
                if (showPromptAreaBtn) {
                    console.log('Adding event listener to Show Prompt Area button');
                    showPromptAreaBtn.addEventListener('click', function() {
                        console.log('Show Prompt Area button clicked');
                        if (dashboardForm) dashboardForm.style.display = 'none';
                        if (aiPromptArea) {
                            aiPromptArea.style.display = 'block';
                            const promptTextArea = document.getElementById('aiPromptText');
                            console.log('promptTextArea element in click handler:', promptTextArea);
                            
                            if (promptTextArea) {
                                try {
                                    // Generate the complete prompt with all stages combined
                                    const generatedPrompt = generateStageSevenPrompt();
                                    console.log('About to set complete prompt in click handler, generated text length:', generatedPrompt.length);
                                    promptTextArea.value = generatedPrompt;
                                    console.log('Complete prompt set successfully in click handler, textarea value length:', promptTextArea.value.length);
                                    promptTextArea.focus();
                                } catch (error) {
                                    console.error('Error generating or setting prompt in click handler:', error);
                                }
                            } else {
                                console.error('promptTextArea element not found in click handler');
                            }
                            
                            aiPromptArea.scrollIntoView({ behavior: 'smooth' });
                        } else {
                            console.error('aiPromptArea element not found in click handler');
                        }
                    });
                } else {
                    console.error('showPromptAreaBtn element not found');
                }
                
                if (backToDashboardBtn) {
                    console.log('Adding event listener to Back to Dashboard button');
                    backToDashboardBtn.addEventListener('click', function() {
                        console.log('Back to Dashboard button clicked');
                        if (aiPromptArea) aiPromptArea.style.display = 'none';
                        if (dashboardForm) {
                            dashboardForm.style.display = 'block';
                            dashboardForm.scrollIntoView({ behavior: 'smooth' });
                        }
                    });
                }
                
                // Log initialization completion
                console.log('Dashboard builder initialization completed');
                
                // Add direct initialization for critical functions as a fallback
                setTimeout(function() {
                    console.log('Running delayed initialization for critical functions');
                    setupTemplateButtons();
                    setupResetButton();
                }, 1000);
            });
            
            // Theme toggle function - Removed and moved to generative.php
            // function setupDarkMode() {
            //     const themeToggle = document.getElementById('themeToggle');
            //     const themeIcon = document.querySelector('#themeToggle i');
            //     const htmlRoot = document.documentElement;
            //     const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            //     
            //     if (!themeToggle || !themeIcon) return;
            //     
            //     // Apply saved theme or system preference
            //     const savedTheme = localStorage.getItem('dashboardbuilder-theme');
            //     
            //     if (savedTheme === 'light' || (!savedTheme && !prefersDark)) {
            //         htmlRoot.classList.add('light-mode');
            //         themeIcon.classList.remove('fa-moon');
            //         themeIcon.classList.add('fa-sun');
            //     }
            //     
            //     // Toggle theme on button click
            //     themeToggle.addEventListener('click', function() {
            //         htmlRoot.classList.toggle('light-mode');
            //         
            //         if (htmlRoot.classList.contains('light-mode')) {
            //             localStorage.setItem('dashboardbuilder-theme', 'light');
            //             themeIcon.classList.remove('fa-moon');
            //             themeIcon.classList.add('fa-sun');
            //         } else {
            //             localStorage.setItem('dashboardbuilder-theme', 'dark');
            //             themeIcon.classList.remove('fa-sun');
            //             themeIcon.classList.add('fa-moon');
            //         }
            //     });
            // }
            
            // Setup dashboard page management
            function setupPageManagement() {
                const container = document.getElementById('pages_container');
                const addPageBtn = document.getElementById('addPageBtn');
                
                if (!container || !addPageBtn) return;
                
                // Add new page
                addPageBtn.addEventListener('click', function() {
                    const pages = container.querySelectorAll('.dashboard-page');
                    if (pages.length > 0) {
                        const newPage = pages[0].cloneNode(true);
                        
                        // Clear input values
                        newPage.querySelectorAll('input, select').forEach(input => {
                            if (input.type === 'text') {
                                input.value = '';
                            } else if (input.type === 'select-one') {
                                input.selectedIndex = 0;
                            }
                        });
                        
                        // Add delete functionality
                        const deleteBtn = newPage.querySelector('.delete-btn');
                        if (deleteBtn) {
                            deleteBtn.addEventListener('click', function() {
                                if (container.querySelectorAll('.dashboard-page').length > 1) {
                                    newPage.remove();
                                } else {
                                    alert('يجب إضافة صفحة واحدة على الأقل');
                                }
                            });
                        }
                        
                        container.appendChild(newPage);
                    }
                });
                
                // Add delete functionality to existing delete buttons
                const deleteButtons = container.querySelectorAll('.delete-btn');
                deleteButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const pages = container.querySelectorAll('.dashboard-page');
                        if (pages.length > 1) {
                            button.closest('.dashboard-page').remove();
                        } else {
                            alert('يجب إضافة صفحة واحدة على الأقل');
                        }
                    });
                });
            }
            
            // Setup form configuration management
            function setupFormConfigManagement() {
                const saveConfigBtn = document.getElementById('saveConfig');
                const configNameInput = document.getElementById('configName');
                const savedConfigsSelect = document.getElementById('savedConfigs');
                const loadConfigBtn = document.getElementById('loadConfig');
                const deleteConfigBtn = document.getElementById('deleteConfig');
                
                if (!saveConfigBtn || !configNameInput || !savedConfigsSelect || !loadConfigBtn || !deleteConfigBtn) return;
                
                // Load saved configurations into dropdown
                loadSavedConfigurations();
                
                // Save configuration
                saveConfigBtn.addEventListener('click', function() {
                    const configName = configNameInput.value.trim();
                    if (!configName) {
                        alert('Please enter a configuration name');
                        return;
                    }
                    
                    // Get current form values
                    const formValues = getFormValues();
                    
                    // Get existing configurations
                    let savedConfigs = JSON.parse(localStorage.getItem('dashboardConfigs') || '{}');
                    
                    // Add or update configuration
                    savedConfigs[configName] = formValues;
                    
                    // Save to localStorage
                    localStorage.setItem('dashboardConfigs', JSON.stringify(savedConfigs));
                    
                    // Update dropdown
                    loadSavedConfigurations();
                    
                    // Show notification
                    alert('تم حفظ التكوين بنجاح');
                });
                
                // Enable/disable load and delete buttons based on selection
                savedConfigsSelect.addEventListener('change', function() {
                    const isConfigSelected = !!savedConfigsSelect.value;
                    loadConfigBtn.disabled = !isConfigSelected;
                    deleteConfigBtn.disabled = !isConfigSelected;
                    
                    if (isConfigSelected) {
                        configNameInput.value = savedConfigsSelect.value;
                    }
                });
                
                // Load configuration
                loadConfigBtn.addEventListener('click', function() {
                    const configName = savedConfigsSelect.value;
                    if (!configName) return;
                    
                    loadConfiguration(configName);
                });
                
                // Delete configuration
                deleteConfigBtn.addEventListener('click', function() {
                    const configName = savedConfigsSelect.value;
                    if (!configName) return;
                    
                    // Get existing configurations
                    let savedConfigs = JSON.parse(localStorage.getItem('dashboardConfigs') || '{}');
                    
                    // Remove the selected configuration
                    delete savedConfigs[configName];
                    
                    // Save to localStorage
                    localStorage.setItem('dashboardConfigs', JSON.stringify(savedConfigs));
                    
                    // Update dropdown
                    loadSavedConfigurations();
                    
                    // Clear input
                    configNameInput.value = '';
                    
                    // Disable buttons
                    loadConfigBtn.disabled = true;
                    deleteConfigBtn.disabled = true;
                    
                    // Show notification
                    alert('تم حذف التكوين بنجاح');
                });
            }
            
            // Load saved configurations into dropdown
            function loadSavedConfigurations() {
                const savedConfigsSelect = document.getElementById('savedConfigs');
                if (!savedConfigsSelect) return;
                
                // Get saved configurations
                const savedConfigs = JSON.parse(localStorage.getItem('dashboardConfigs') || '{}');
                
                // Clear dropdown options except the first one
                while (savedConfigsSelect.options.length > 1) {
                    savedConfigsSelect.remove(1);
                }
                
                // Add configurations to dropdown
                for (const configName in savedConfigs) {
                    const option = document.createElement('option');
                    option.value = configName;
                    option.textContent = configName;
                    savedConfigsSelect.appendChild(option);
                }
            }
            
            // Get form values
            function getFormValues() {
                const form = document.getElementById('promptForm');
                if (!form) return {};
                
                const formData = new FormData(form);
                const values = {};
                
                // Convert FormData to object
                for (const [key, value] of formData.entries()) {
                    // Handle array inputs (e.g., page_names[])
                    if (key.endsWith('[]')) {
                        const arrayKey = key.slice(0, -2);
                        if (!values[arrayKey]) {
                            values[arrayKey] = [];
                        }
                        values[arrayKey].push(value);
                    } else {
                        values[key] = value;
                    }
                }
                
                // Handle checkboxes
                const checkboxes = form.querySelectorAll('input[type="checkbox"]');
                checkboxes.forEach(checkbox => {
                    values[checkbox.name] = checkbox.checked;
                });
                
                return values;
            }
            
            // Load configuration
            function loadConfiguration(name) {
                // Get stored configurations
                const savedConfigs = JSON.parse(localStorage.getItem('dashboardConfigs') || '{}');
                const config = savedConfigs[name];
                
                if (!config) {
                    alert('Configuration not found');
                    return;
                }
                
                const form = document.getElementById('promptForm');
                if (!form) return;
                
                // Reset form to defaults first
                //form.reset();
                
                // Set form values from configuration
                for (const key in config) {
                    // Skip array type inputs, we'll handle them separately
                    if (Array.isArray(config[key])) continue;
                    
                    const input = form.querySelector(`[name="${key}"]`);
                    if (input) {
                        if (input.type === 'checkbox') {
                            input.checked = config[key];
                        } else {
                            input.value = config[key];
                        }
                    }
                }
                
                // Handle page arrays
                const pageContainer = document.getElementById('pages_container');
                if (pageContainer && config.page_names && Array.isArray(config.page_names)) {
                    // Clear existing pages except the first one
                    const pages = pageContainer.querySelectorAll('.dashboard-page');
                    // Remove all but first page
                    for (let i = pages.length - 1; i > 0; i--) {
                        pages[i].remove();
                    }
                    
                    // Set values for the first page
                    if (pages.length > 0 && config.page_names.length > 0) {
                        const firstPage = pages[0];
                        const nameInput = firstPage.querySelector('[name="page_names[]"]');
                        const iconInput = firstPage.querySelector('[name="page_icons[]"]');
                        const contentSelect = firstPage.querySelector('[name="page_contents[]"]');
                        
                        if (nameInput) nameInput.value = config.page_names[0] || '';
                        if (iconInput && config.page_icons) iconInput.value = config.page_icons[0] || '';
                        if (contentSelect && config.page_contents) contentSelect.value = config.page_contents[0] || 'summary';
                    }
                    
                    // Add additional pages
                    for (let i = 1; i < config.page_names.length; i++) {
                        // Clone the first page template
                        if (pages.length > 0) {
                            const newPage = pages[0].cloneNode(true);
                            
                            // Set values
                            const nameInput = newPage.querySelector('[name="page_names[]"]');
                            const iconInput = newPage.querySelector('[name="page_icons[]"]');
                            const contentSelect = newPage.querySelector('[name="page_contents[]"]');
                            
                            if (nameInput) nameInput.value = config.page_names[i] || '';
                            if (iconInput && config.page_icons) iconInput.value = config.page_icons[i] || '';
                            if (contentSelect && config.page_contents) contentSelect.value = config.page_contents[i] || 'summary';
                            
                            // Add delete button functionality
                            const deleteBtn = newPage.querySelector('.delete-btn');
                            if (deleteBtn) {
                                deleteBtn.addEventListener('click', function() {
                                    if (pageContainer.querySelectorAll('.dashboard-page').length > 1) {
                                        newPage.remove();
                                    } else {
                                        alert('يجب إضافة صفحة واحدة على الأقل');
                                    }
                                });
                            }
                            
                            pageContainer.appendChild(newPage);
                        }
                    }
                }
                
                // Update any dependent fields or UI elements
                updateFormDependencies();
                
                // Show notification
                alert('تم تحميل التكوين بنجاح');
            }
            
            /**
             * Show notification
             */
            // Removed showNotification function
            
            // Setup social sharing
            // Removed setupSocialSharing function
            
            // Setup template buttons functionality
            function setupTemplateButtons() {
                console.log('Setting up template buttons');
                const templateButtons = document.querySelectorAll('.template-btn');
                if (!templateButtons.length) {
                    console.log('No template buttons found');
                    return;
                }
                
                console.log('Found', templateButtons.length, 'template buttons');
                templateButtons.forEach(button => {
                    // Remove any existing event listeners first
                    const newButton = button.cloneNode(true);
                    button.parentNode.replaceChild(newButton, button);
                    
                    // Add new event listener
                    newButton.addEventListener('click', function() {
                        const templateType = this.getAttribute('data-template');
                        console.log('Template button clicked:', templateType);
                        applyTemplate(templateType);
                    });
                });
            }
            
            // Apply template based on selected type
            function applyTemplate(templateType) {
                console.log('Applying template:', templateType);
                // Define templates
                const templates = {
                    'admin': {
                        name: 'Administrative Dashboard',
                        type: 'admin',
                        framework: 'bootstrap',
                        nav_type: 'sidebar',
                        layout_type: 'fixed',
                        color_scheme: 'blue'
                    },
                    'analytics': {
                        name: 'Analytics Dashboard',
                        type: 'analytics',
                        framework: 'react',
                        nav_type: 'horizontal', 
                        layout_type: 'fluid',
                        color_scheme: 'indigo'
                    },
                    'ecommerce': {
                        name: 'E-Commerce Dashboard',
                        type: 'ecommerce',
                        framework: 'tailwind',
                        nav_type: 'combined',
                        layout_type: 'fluid',
                        color_scheme: 'purple'
                    },
                    'project_mgmt': {
                        name: 'Project Management Dashboard',
                        type: 'project',
                        framework: 'vue',
                        nav_type: 'sidebar',
                        layout_type: 'fluid',
                        color_scheme: 'green'
                    },
                    'maintenance': {
                        name: 'Maintenance Dashboard',
                        type: 'custom',
                        framework: 'bootstrap',
                        nav_type: 'sidebar',
                        layout_type: 'cards',
                        color_scheme: 'blue'
                    },
                    'ml_project': {
                        name: 'ML Project Dashboard',
                        type: 'analytical',
                        framework: 'react',
                        nav_type: 'sidebar',
                        layout_type: 'flexible',
                        color_scheme: 'technical'
                    }
                };
                
                // Get template configuration
                const template = templates[templateType];
                if (!template) {
                    alert('Template not found');
                    return;
                }
                
                // Apply template to form
                const form = document.getElementById('promptForm');
                if (!form) return;
                
                // Set basic values
                document.getElementById('dashboard_name').value = template.name;
                
                // Apply template settings
                const inputs = {
                    'dashboard_type': template.type,
                    'framework_type': template.framework,
                    'nav_type': template.nav_type,
                    'layout_type': template.layout_type,
                    'color_scheme': template.color_scheme
                };
                
                // Apply values to form
                for (let id in inputs) {
                    const el = document.getElementById(id);
                    if (el) el.value = inputs[id];
                }
                
                // Reset pages to single default page
                const pagesContainer = document.getElementById('pages_container');
                if (pagesContainer) {
                    const pages = pagesContainer.querySelectorAll('.dashboard-page');
                    // Remove all but first page
                    for (let i = pages.length - 1; i > 0; i--) {
                        pages[i].remove();
                    }
                    
                    // Reset first page
                    if (pages.length > 0) {
                        const nameInput = pages[0].querySelector('[name="page_names[]"]');
                        const iconInput = pages[0].querySelector('[name="page_icons[]"]');
                        const contentSelect = pages[0].querySelector('[name="page_contents[]"]');
                        
                        if (nameInput) nameInput.value = 'Dashboard Home';
                        if (iconInput) iconInput.value = 'fa-home';
                        if (contentSelect) contentSelect.value = 'summary';
                    }
                }
                
                // Show success message
            }
            
            // Create a new page element if needed
            function createPageElement() {
                const pageDiv = document.createElement('div');
                pageDiv.className = 'dashboard-page';
                
                pageDiv.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group">
                            <label>Page Name:</label>
                            <input type="text" name="page_names[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="e.g. Dashboard Home">
                        </div>
                        <div class="form-group">
                            <label>Icon (FontAwesome):</label>
                            <input type="text" name="page_icons[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" placeholder="e.g. fa-home">
                        </div>
                        <div class="form-group">
                            <label>Page Content & Function:</label>
                            <select name="page_contents[]" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                                <option value="summary">Summary/Overview</option>
                                <option value="charts">Charts & Graphs</option>
                                <option value="tables">Data Tables</option>
                                <option value="forms">Forms</option>
                                <option value="settings">Settings</option>
                                <option value="mixed">Mixed Content</option>
                                <option value="home">Home Page</option>
                                <option value="dashboard">Dashboard</option>
                                <option value="login">Login Page</option>
                                <option value="register">Register Page</option>
                                <option value="profile">Profile Page</option>
                                <option value="analytics">Analytics Page</option>
                                <option value="reports">Reports Page</option>
                                <option value="users">Users Management</option>
                                <option value="products">Products Page</option>
                                <option value="notifications">Notifications</option>
                                <option value="messages">Messages</option>
                                <option value="calendar">Calendar</option>
                                <option value="about">About Us</option>
                                <option value="contact">Contact Us</option>
                                <option value="privacy">Privacy Policy</option>
                                <option value="terms">Terms & Conditions</option>
                                <option value="faq">FAQ</option>
                                <option value="404">404 Page</option>
                                <option value="500">500 Page</option>
                                <option value="403">403 Page</option>
                                <option value="401">401 Page</option>
                                <option value="400">400 Page</option>
                                <option value="301">301 Page</option>
                                <option value="302">302 Page</option>
                            </select>
                        </div>
                    </div>
                    <button type="button" class="delete-btn">
                        <i class="fas fa-times"></i>
                    </button>
                `;
                
                return pageDiv;
            }
            
            // Setup import/export functionality
            function setupImportExport() {
                // هذه الدالة تم إزالتها بالكامل
            }
            
            // Enhance import/export UX with visual feedback and shortcuts
            function enhanceImportExportUX() {
                // هذه الدالة تم إزالتها بالكامل
            }
            
            // Show keyboard shortcut hint pop-up
            function showKeyboardShortcutHint(action, shortcut) {
                const hintContainer = document.createElement('div');
                hintContainer.className = 'fixed bottom-4 left-4 bg-gray-800 text-white px-4 py-2 rounded-md opacity-0 transition-opacity duration-300 z-50 flex items-center keyboard-hint';
                hintContainer.innerHTML = `
                    <i class="fas fa-keyboard mr-2"></i>
                    <span>${action}: <kbd class="px-2 py-1 bg-gray-700 rounded text-xs font-mono">${shortcut}</kbd></span>
                `;
                
                document.body.appendChild(hintContainer);
                
                // Fade in
                setTimeout(() => {
                    hintContainer.classList.add('opacity-100');
                }, 10);
                
                // Fade out and remove
                setTimeout(() => {
                    hintContainer.classList.remove('opacity-100');
                    setTimeout(() => hintContainer.remove(), 300);
                }, 2000);
            }
            
            // Add config info tooltips
            function addConfigInfoTooltips() {
                // Add tooltip to export button
                const exportConfigBtn = document.getElementById('exportConfig');
                if (exportConfigBtn) {
                    exportConfigBtn.setAttribute('title', 'Export configuration as JSON file (Ctrl+Shift+E)');
                }
                
                // Add tooltip to import button
                const importConfigBtn = document.getElementById('importConfig');
                if (importConfigBtn) {
                    importConfigBtn.setAttribute('title', 'Import configuration from JSON file (Ctrl+Shift+I)');
                }
            }
            
            // Add keyboard shortcut hints
            function addKeyboardShortcutHints() {
                // Create container for keyboard shortcuts if it doesn't exist
                if (!document.getElementById('keyboardShortcutsContainer')) {
                    const container = document.createElement('div');
                    container.id = 'keyboardShortcutsContainer';
                    container.className = 'fixed bottom-4 right-4 z-40';
                    
                    const toggleBtn = document.createElement('button');
                    toggleBtn.className = 'bg-gray-800 dark:bg-gray-700 text-white p-2 rounded-full shadow-lg hover:bg-gray-700 dark:hover:bg-gray-600 transition-colors';
                    toggleBtn.innerHTML = '<i class="fas fa-keyboard"></i>';
                    toggleBtn.setAttribute('title', 'Keyboard Shortcuts');
                    
                    toggleBtn.addEventListener('click', function() {
                        showKeyboardShortcutsModal();
                    });
                    
                    container.appendChild(toggleBtn);
                    document.body.appendChild(container);
                }
            }
            
            // Show keyboard shortcuts modal
            function showKeyboardShortcutsModal() {
                // Create modal if it doesn't exist
                if (!document.getElementById('keyboardShortcutsModal')) {
                    const modal = document.createElement('div');
                    modal.id = 'keyboardShortcutsModal';
                    modal.className = 'fixed inset-0 z-50 overflow-y-auto hidden';
                    modal.setAttribute('aria-labelledby', 'keyboard-shortcuts-title');
                    modal.setAttribute('role', 'dialog');
                    modal.setAttribute('aria-modal', 'true');
                    
                    modal.innerHTML = `
                        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                            <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity modal-overlay" aria-hidden="true"></div>
                            
                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                            
                            <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                                <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                    <div class="sm:flex sm:items-start">
                                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 dark:bg-blue-900 sm:mx-0 sm:h-10 sm:w-10">
                                            <i class="fas fa-keyboard text-blue-600 dark:text-blue-400"></i>
                                        </div>
                                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="keyboard-shortcuts-title">
                                                Keyboard Shortcuts
                                            </h3>
                                            <div class="mt-4 border-t border-gray-200 dark:border-gray-700 pt-4">
                                                <div class="space-y-3">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm text-gray-700 dark:text-gray-300">Export Configuration</span>
                                                        <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">Ctrl+Shift+E</kbd>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm text-gray-700 dark:text-gray-300">Import Configuration</span>
                                                        <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">Ctrl+Shift+I</kbd>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm text-gray-700 dark:text-gray-300">Save Configuration</span>
                                                        <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">Ctrl+S</kbd>
                                                    </div>
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-sm text-gray-700 dark:text-gray-300">Toggle Theme</span>
                                                        <kbd class="px-2 py-1 bg-gray-100 dark:bg-gray-700 rounded text-xs font-mono">Shift+T</kbd>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                    <button type="button" class="closeShortcutsModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Close
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                    
                    document.body.appendChild(modal);
                    
                    // Add event listener to close button
                    const closeBtn = modal.querySelector('.closeShortcutsModal');
                    if (closeBtn) {
                        closeBtn.addEventListener('click', function() {
                            modal.classList.add('hidden');
                        });
                    }
                    
                    // Close on overlay click
                    const modalOverlay = modal.querySelector('.modal-overlay');
                    if (modalOverlay) {
                        modalOverlay.addEventListener('click', function() {
                            modal.classList.add('hidden');
                        });
                    }
                    
                    // Close on escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                            modal.classList.add('hidden');
                        }
                    });
                }
                
                // Show the modal
                const modal = document.getElementById('keyboardShortcutsModal');
                if (modal) {
                    modal.classList.remove('hidden');
                }
            }
            
            // Add backup reminders
            function addBackupReminders() {
                // Check if there are saved configurations
                const savedConfigs = JSON.parse(localStorage.getItem('dashboardConfigs') || '{}');
                const configCount = Object.keys(savedConfigs).length;
                
                // If user has more than 3 configurations and no reminder has been shown in the last 7 days
                const lastReminder = localStorage.getItem('lastBackupReminder');
                const currentTime = new Date().getTime();
                const sevenDays = 7 * 24 * 60 * 60 * 1000;
                
                if (configCount >= 3 && (!lastReminder || (currentTime - parseInt(lastReminder)) > sevenDays)) {
                    // Show backup reminder after a delay
                    setTimeout(() => {
                        showBackupReminder(configCount);
                        // Update last reminder time
                        localStorage.setItem('lastBackupReminder', currentTime.toString());
                    }, 5000);
                }
            }
            
            // Show backup reminder notification
            function showBackupReminder(configCount) {
                const message = `You have ${configCount} saved configurations. Consider exporting them as backup files.`;
                alert(message);
                
                // Add click handler to quick export button
                setTimeout(() => {
                    const quickExportBtn = document.getElementById('quickExportBtn');
                    if (quickExportBtn) {
                        quickExportBtn.addEventListener('click', function() {
                            // Find and click the export button
                            const exportConfigBtn = document.getElementById('exportConfig');
                            if (exportConfigBtn) {
                                exportConfigBtn.click();
                            }
                        });
                        
                        quickExportBtn.setAttribute('title', 'Export Configurations');
                    }
                }, 100);
            }
            
            // Setup auto-save functionality for form progress
            function setupAutoSave() {
                const form = document.getElementById('promptForm');
                if (!form) return;
                
                // Set up an interval to save form data every 30 seconds
                const autoSaveInterval = setInterval(() => {
                    saveFormProgress();
                }, 30000);
                
                // Also save when the user makes changes (debounced)
                let debounceTimer;
                form.addEventListener('input', () => {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        saveFormProgress();
                    }, 2000);
                });
                
                // Save when user is about to leave the page
                window.addEventListener('beforeunload', () => {
                    saveFormProgress();
                });
                
                // Try to restore saved form data when the page loads
                restoreFormProgress();
            }
            
            // Save current form progress to localStorage
            function saveFormProgress() {
                const form = document.getElementById('promptForm');
                if (!form) return;
                
                const formValues = getFormValues();
                formValues.timestamp = new Date().toISOString();
                
                try {
                    localStorage.setItem('dashboard-form-autosave', JSON.stringify(formValues));
                    // Optional: show a subtle auto-save indicator
                    showAutoSaveIndicator();
                } catch (error) {
                    console.warn('Could not save form progress', error);
                }
            }
            
            // Restore form progress from localStorage
            function restoreFormProgress() {
                const savedData = localStorage.getItem('dashboard-form-autosave');
                if (!savedData) return;
                
                try {
                    const formValues = JSON.parse(savedData);
                    const timestamp = new Date(formValues.timestamp);
                    const now = new Date();
                    const hoursDiff = (now - timestamp) / (1000 * 60 * 60);
                    
                    // Only restore if the saved data is recent (less than 24 hours old)
                    if (hoursDiff < 24) {
                        // Ask user if they want to restore previous data
                        const confirmRestore = confirm('تم العثور على بيانات محفوظة سابقًا. هل ترغب في استعادتها؟');
                        if (confirmRestore) {
                            fillFormWithSharedConfiguration(formValues);
                            alert('تم استعادة البيانات بنجاح');
                        } else {
                            // If user declines, remove the saved data
                            localStorage.removeItem('dashboard-form-autosave');
                        }
                    } else {
                        // If data is old, remove it
                        localStorage.removeItem('dashboard-form-autosave');
                    }
                } catch (error) {
                    console.warn('Error restoring form data', error);
                    localStorage.removeItem('dashboard-form-autosave');
                }
            }
            
            // Show a subtle auto-save indicator
            function showAutoSaveIndicator() {
                // Check if the indicator already exists
                let indicator = document.getElementById('autosave-indicator');
                
                if (!indicator) {
                    // Create the indicator
                    indicator = document.createElement('div');
                    indicator.id = 'autosave-indicator';
                    indicator.className = 'fixed bottom-4 right-4 bg-green-100 text-green-800 text-xs px-2 py-1 rounded-md opacity-0 transition-opacity duration-300';
                    indicator.textContent = 'تم الحفظ تلقائيًا';
                    document.body.appendChild(indicator);
                }
                
                // Show the indicator
                setTimeout(() => {
                    indicator.classList.add('opacity-100');
                    
                    // Hide after 2 seconds
                    setTimeout(() => {
                        indicator.classList.remove('opacity-100');
                    }, 2000);
                }, 100);
            }
            
            // Fallback copy function for older browsers - Removed and moved to generative.php
            // function fallbackCopyTextToClipboard(text) {
            //     const textarea = document.createElement('textarea');
            //     textarea.value = text;
            //     textarea.style.position = 'fixed';
            //     textarea.style.opacity = 0;
            //     document.body.appendChild(textarea);
            //     textarea.select();
            //     
            //     try {
            //         const successful = document.execCommand('copy');
            //         if (successful) {
            //             alert('تم نسخ الرابط بنجاح!');
            //         } else {
            //             alert('فشل نسخ الرابط');
            //         }
            //     } catch (err) {
            //         console.error('خطأ في نسخ النص:', err);
            //         alert('فشل نسخ الرابط');
            //     }
            //     
            //     document.body.removeChild(textarea);
            // }
        </script>
        
            </body>
</html>
