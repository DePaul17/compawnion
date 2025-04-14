<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        /* Email Container */
        .email-container {
            max-width: 600px;
            width: 100%;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .email-header {
            background-color: #01bd56; /* Changement de couleur */
            padding: 20px;
            text-align: center;
            color: #ffffff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Email Body */
        .email-body {
            margin: 20px 0;
            line-height: 1.6;
            color: #333333;
            text-align: center;
        }
        .email-body p {
            margin: 10px 0;
        }
        .email-body strong {
            color: #333;
        }

        /* Button */
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #01bd56;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        /* Footer */
        .email-footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #dddddd;
        }

        /* Responsive Design */
        @media only screen and (max-width: 600px) {
            .email-header h1 {
                font-size: 20px;
            }

            .email-container {
                padding: 15px;
                margin: 10px;
            }

            .btn {
                padding: 10px;
                font-size: 16px;
            }

            .email-body p, .email-body strong {
                font-size: 16px;
            }
        }

        @media only screen and (max-width: 400px) {
            .email-header h1 {
                font-size: 18px;
            }

            .btn {
                width: 100%;
                padding: 12px;
                font-size: 14px;
            }

            .email-body {
                text-align: center;
            }

            .email-container {
                margin: 10px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Contact • compawnion</h1>
        </div>

        <!-- Body -->
        <div class="email-body">
            <p>Bonjour,</p>
            <p>Vous avez reçu un nouveau mail :</p>

            <p><strong>Nom complet :</strong> {{ $full_name }}</p>
            <p><strong>E-mail :</strong> {{ $email }}</p>
            <p><strong>Sujet :</strong> {{ $subject }}</p>
            <p><strong>Message :</strong></p>
            <p>{{ $content }}</p>

            <a href="mailto:{{ $email }}" class="btn">Répondre</a>
        </div>

        <!-- Footer -->
        <div class="email-footer">
            <p>© 2025 Compawnion. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
