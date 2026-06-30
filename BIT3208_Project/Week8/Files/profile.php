<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Profile - Week 8</title>
    <style>
        /* 🎨 CSS VISUAL RESET */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* 📱 1. MOBILE-FIRST BASE STYLES (Default / Screens under 768px wide) */
        body {
            background-color: #f4f5f7;
            color: #2e2c38;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .profile-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 800px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            
            /* Core Flexbox Activation */
            display: flex;
            flex-direction: column; /* Stack components vertically on mobile screens */
            align-items: center;
            gap: 25px;
            text-align: center;
        }

        .image-container {
            width: 150px;
            height: 150px;
            flex-shrink: 0;
        }

        .image-container img {
            width: 100%;      
            max-width: 100%;  
            height: 100%;     
            object-fit: cover; 
            border-radius: 50%; 
            border: 4px solid #bd2bf2;
        }

        /* --- CONTENT WRAPPER --- */
        .content-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .name {
            font-size: 1.8em;
            color: #111111;
            font-weight: 700;
        }

        .about-title, .contact-title {
            font-size: 1.1em;
            color: #bd2bf2;
            font-weight: 600;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .about-text {
            color: #635e80;
            line-height: 1.6;
            font-size: 0.95em;
        }

        /* --- CONTACT INFORMATION --- */
        .contact-info {
            display: flex;
            flex-direction: column; /* Vertical stacking on phone views */
            gap: 10px;
            background-color: #fafafa;
            padding: 15px;
            border-radius: 12px;
            text-align: left;
        }

        .contact-item {
            font-size: 0.9em;
            color: #2e2c38;
        }

        .contact-item strong {
            color: #111111;
        }


        /* 🖥️ 2. DESKTOP MEDIA QUERY BREAKPOINT (Screens 768px wide and up) */
        @media (min-width: 768px) {
            .profile-card {
                flex-direction: row; /* Switch layout completely to side-by-side on desktop */
                text-align: left;
                padding: 45px;
                gap: 40px;
            }

            .image-container {
                width: 200px; /* Scale up image container size smoothly on larger displays */
                height: 200px;
            }

            .content-section {
                text-align: left;
            }

            .contact-info {
                flex-direction: row; /* Spread contacts out into columns/rows across desktop card */
                flex-wrap: wrap;
                gap: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="profile-card">
        
        <div class="image-container">
            <img src="gta5.png" alt="Profile Picture">
        </div>

        <div class="content-section">
            <div>
                <h2 class="name">Ivan Amani</h2>
            </div>

            <div>
                <h4 class="about-title">About Me</h4>
                <p class="about-text">
                    I am a MKU student purseuing a degree in Bachelor Of science in Business Information Technology. I am passionate about technology, coding, and problem-solving. I enjoy learning new programming languages and frameworks, and I am always looking for opportunities to apply my skills in real-world projects.
                 </p>
            </div>

            <div>
                <h4 class="contact-title">CONTACT INFORMATION</h4>
                <div class="contact-info">
                    <div class="contact-item">
                        <strong>📧 Email:</strong> ivanamani93@gmail.com
                    </div>
                    <div class="contact-item">
                        <strong>📞 Phone:</strong> +254115513919
                    </div>
                    <div class="contact-item">
                        <strong>📍 Location:</strong> Juja, Kiambu, Kenya
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>
</html>