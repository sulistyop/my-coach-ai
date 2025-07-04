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
        
        .btn-container {
            margin-top: 15px;
        }
        
        .onboarding-indicators {
            display: flex;
            justify-content: center;
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
            <h1>Komitmen pada Kebugaran</h1>
            <p class="mb-0">Mulailah perjalanan Anda menuju versi diri yang lebih sehat dan kuat.</p>
        </div>
        <div class="onboarding-navigation">
            <div class="container">
                <div class="onboarding-indicators">
                    <div class="indicator active" data-step="1"></div>
                    <div class="indicator" data-step="2"></div>
                    <div class="indicator" data-step="3"></div>
                </div>
                <div class="btn-container d-flex justify-content-center">
                    <button id="nextBtn" class="btn btn-primary px-5" onclick="nextStep()">Selanjutnya</button>
                    <button id="startBtn" class="btn btn-success px-5 d-none" onclick="startApp()">Mulai</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Step 2 -->
    <div class="onboarding-step" style="background-image: url('https://images.unsplash.com/photo-1502904550040-7534597429ae?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80')">
        <div class="onboarding-content">
            <h1>Lacak Kemajuan Anda</h1>
            <p class="mb-0">Pantau latihan Anda, tetapkan tujuan, dan rayakan pencapaian Anda.</p>
        </div>
        <div class="onboarding-navigation">
            <div class="container">
                <div class="onboarding-indicators">
                    <div class="indicator active" data-step="1"></div>
                    <div class="indicator" data-step="2"></div>
                    <div class="indicator" data-step="3"></div>
                </div>
                <div class="btn-container d-flex justify-content-center">
                    <button id="nextBtn" class="btn btn-primary px-5" onclick="nextStep()">Selanjutnya</button>
                    <button id="startBtn" class="btn btn-success px-5 d-none" onclick="startApp()">Mulai</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Step 3 -->
    <div class="onboarding-step" style="background-image: url('https://images.unsplash.com/photo-1549576490-b0b4831ef60a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80')">
        <div class="onboarding-content">
            <h1>Ubah Hidup Anda</h1>
            <p class="mb-0">Bergabunglah dengan komunitas kami dan buat perubahan positif yang bertahan lama!</p>
        </div>
        <div class="onboarding-navigation">
            <div class="container">
                <div class="onboarding-indicators">
                    <div class="indicator active" data-step="1"></div>
                    <div class="indicator" data-step="2"></div>
                    <div class="indicator" data-step="3"></div>
                </div>
                <div class="btn-container d-flex justify-content-center">
                    <button id="nextBtn" class="btn btn-primary px-5" onclick="nextStep()">Selanjutnya</button>
                    <button id="startBtn" class="btn btn-success px-5 d-none" onclick="startApp()">Mulai</button>
                </div>
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
        document.querySelectorAll('.onboarding-step')[currentStep-1].classList.remove('active');
        
        // Update indicators
        document.querySelectorAll('.indicator').forEach(ind => ind.classList.remove('active'));
        
        // Move to next step
        if (currentStep < totalSteps) {
            currentStep++;
        } else {
            // If at last step, cycle back to first step for demo purposes
            currentStep = 1;
        }
        
        // Show new step
        document.querySelectorAll('.onboarding-step')[currentStep-1].classList.add('active');
        document.querySelectorAll('.indicator')[currentStep-1].classList.add('active');
        
        // Update buttons based on step
        updateButtons();
    }
    
    function updateButtons() {
        // Hide all "Start" buttons and show all "Next" buttons first
        document.querySelectorAll('#startBtn').forEach(btn => btn.classList.add('d-none'));
        document.querySelectorAll('#nextBtn').forEach(btn => btn.classList.remove('d-none'));
        
        // If on last step, show "Start" button and hide "Next" button
        if (currentStep === totalSteps) {
            document.querySelectorAll('.onboarding-step')[currentStep-1].querySelector('#nextBtn').classList.add('d-none');
            document.querySelectorAll('.onboarding-step')[currentStep-1].querySelector('#startBtn').classList.remove('d-none');
        }
    }
    
    function startApp() {
        // Redirect to main app or perform any action to start the app
        window.location.href = "{{ route('home') }}";
    }

    // Add click functionality to indicators
    document.addEventListener('DOMContentLoaded', function() {
        const indicators = document.querySelectorAll('.indicator');
        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function() {
                // Hide current step
                document.querySelectorAll('.onboarding-step')[currentStep-1].classList.remove('active');
                
                // Update indicators
                document.querySelectorAll('.indicator').forEach(ind => ind.classList.remove('active'));
                
                // Update current step
                currentStep = index + 1;
                
                // Show new step
                document.querySelectorAll('.onboarding-step')[currentStep-1].classList.add('active');
                document.querySelectorAll('.indicator')[currentStep-1].classList.add('active');
                
                // Update buttons
                updateButtons();
            });
        });
    });
</script>