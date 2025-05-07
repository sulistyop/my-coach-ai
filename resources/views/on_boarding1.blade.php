@extends('layouts.app')

<style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .onboarding-container {
            height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .onboarding-step {
            height: 100%;
            width: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding-bottom: 100px;
            transition: opacity 0.5s ease;
            position: absolute;
            top: 0;
            left: 0;
        }
        
        .onboarding-step:not(.active) {
            opacity: 0;
            pointer-events: none;
        }
        
        .onboarding-content {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            padding: 35px 40px;
            margin: 0 auto;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            max-width: 550px;
            width: 85%;
        }
        
        .onboarding-content h1 {
            font-weight: 700;
            margin-bottom: 15px;
            color: #333;
            font-size: 2.2rem;
        }
        
        .onboarding-content p {
            font-size: 1.2rem;
            color: #555;
        }
        
        .onboarding-navigation {
            position: absolute;
            bottom: 30px;
            width: 100%;
            display: flex;
            justify-content: center;
        }
        
        .onboarding-indicators {
            display: flex;
            justify-content: center;
            margin-bottom: 25px;
        }
        
        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            margin: 0 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .indicator.active {
            background-color: #ffffff;
            transform: scale(1.2);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.8);
        }
        
        .btn {
            font-weight: 600;
            border-radius: 30px;
            padding: 12px 40px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: #3498db;
            border-color: #3498db;
        }
        
        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
        
        .btn-success {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }
        
        .btn-success:hover {
            background-color: #27ae60;
            border-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }
        
        /* Dark overlay for better text visibility */
        .onboarding-step::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0) 100%);
            z-index: 0;
        }
        
        .onboarding-content, .onboarding-navigation {
            position: relative;
            z-index: 1;
        }
        
        /* Responsive adjustments */
        @media (max-height: 700px) {
            .onboarding-step {
                padding-bottom: 60px;
            }
            
            .onboarding-content {
                padding: 25px 30px;
            }
            
            .onboarding-content h1 {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            
            .onboarding-content p {
                font-size: 1rem;
            }
            
            .onboarding-navigation {
                bottom: 20px;
            }
        }
        
        @media (max-width: 576px) {
            .onboarding-content {
                padding: 20px 25px;
                width: 90%;
            }
            
            .btn {
                padding: 10px 25px;
                font-size: 1rem;
            }
        }
    </style>

@section('content')

<div class="onboarding-container">
    <!-- Step 1 -->
    <div class="onboarding-step active" style="background-image: url('https://images.unsplash.com/photo-1517836357463-d25dfeac3438?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')">
        <div class="onboarding-content">
            <h1>Commit to Fitness</h1>
            <p class="mb-0">Begin your journey to a healthier and stronger version of yourself.</p>
        </div>
    </div>
    
    <!-- Step 2 -->
    <div class="onboarding-step" style="background-image: url('https://images.unsplash.com/photo-1502904550040-7534597429ae?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80')">
        <div class="onboarding-content">
            <h1>Track Your Progress</h1>
            <p class="mb-0">Monitor your workouts, set goals, and celebrate your achievements.</p>
        </div>
    </div>
    
    <!-- Step 3 -->
    <div class="onboarding-step" style="background-image: url('https://images.unsplash.com/photo-1549576490-b0b4831ef60a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')">
        <div class="onboarding-content">
            <h1>Transform Your Life</h1>
            <p class="mb-0">Join our community and make positive changes that last!</p>
        </div>
    </div>
    
    <div class="onboarding-navigation">
        <div class="container">
            <div class="onboarding-indicators">
                <div class="indicator active" data-step="1"></div>
                <div class="indicator" data-step="2"></div>
                <div class="indicator" data-step="3"></div>
            </div>
            
            <div class="d-flex justify-content-center">
                <button id="nextBtn" class="btn btn-primary px-5" onclick="nextStep()">Selanjutnya</button>
                <button id="startBtn" class="btn btn-success px-5 d-none" onclick="startApp()">Mulai</button>
            </div>
        </div>
    </div>
</div>


@endsection

<script>
    let currentStep = 1;
    const totalSteps = 3;
    
    function nextStep() {
        // Hide current step with smooth transition
        document.querySelector(`.onboarding-step:nth-child(${currentStep})`).classList.remove('active');
        document.querySelector(`.indicator:nth-child(${currentStep})`).classList.remove('active');
        
        // Move to next step
        currentStep++;
        
        // Show next step
        document.querySelector(`.onboarding-step:nth-child(${currentStep})`).classList.add('active');
        document.querySelector(`.indicator:nth-child(${currentStep})`).classList.add('active');
        
        // Update buttons for last step
        if (currentStep === totalSteps) {
            document.getElementById('nextBtn').classList.add('d-none');
            document.getElementById('startBtn').classList.remove('d-none');
        }
    }
    
    function startApp() {
        // Redirect to main app or perform any action to start the app
        window.location.href = "{{ route('home') }}";
    }

    // Add click functionality to indicators
    document.addEventListener('DOMContentLoaded', function() {
        const indicators = document.querySelectorAll('.indicator');
        indicators.forEach(indicator => {
            indicator.addEventListener('click', function() {
                const clickedStep = parseInt(this.getAttribute('data-step'));
                
                // Skip if already on this step
                if (clickedStep === currentStep) return;
                
                // Hide current step
                document.querySelector(`.onboarding-step:nth-child(${currentStep})`).classList.remove('active');
                document.querySelector(`.indicator:nth-child(${currentStep})`).classList.remove('active');
                
                // Update current step
                currentStep = clickedStep;
                
                // Show new step
                document.querySelector(`.onboarding-step:nth-child(${currentStep})`).classList.add('active');
                document.querySelector(`.indicator:nth-child(${currentStep})`).classList.add('active');
                
                // Update buttons based on step
                if (currentStep === totalSteps) {
                    document.getElementById('nextBtn').classList.add('d-none');
                    document.getElementById('startBtn').classList.remove('d-none');
                } else {
                    document.getElementById('nextBtn').classList.remove('d-none');
                    document.getElementById('startBtn').classList.add('d-none');
                }
            });
        });
    });
</script>