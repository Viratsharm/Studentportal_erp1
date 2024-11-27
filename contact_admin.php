<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Admin</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle, #1e1e2f, #0d0d14);
            color: #f5d372;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background-color: #212136;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
            width: 100%;
            max-width: 600px;
        }

        h1 {
            font-size: 30px;
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            background-color: #343a40;
            color: #f5d372;
        }

        textarea {
            height: 150px;
            resize: vertical;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #e04544;
        }

        .message {
            font-size: 16px;
            color: #f5d372;
            text-align: center;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Contact Admin</h1>
        <form action="process_contact.php" method="POST">
            <label for="student_name">Your Name:</label>
            <input type="text" id="student_name" name="student_name" required placeholder="Enter your full name">

            <label for="student_email">Your Email:</label>
            <input type="email" id="student_email" name="student_email" required placeholder="Enter your email address">

            <label for="subject">Subject:</label>
            <input type="text" id="subject" name="subject" required placeholder="Enter the subject of your message">

            <label for="message">Message:</label>
            <textarea id="message" name="message" required placeholder="Write your message here"></textarea>

            <button type="submit">Send Message</button>
        </form>

        <div class="message">
            <!-- Success/Error message will be shown here after form submission -->
            <?php
                if (isset($_GET['success'])) {
                    echo "<p>Message sent successfully!</p>";
                }
                if (isset($_GET['error'])) {
                    echo "<p>There was an error sending your message. Please try again.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
