<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .form-container h2 {
            text-align: center;
        }
        .form-container .message, .form-container .error {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 4px;
            color: #fff;
        }
        .form-container .message {
            background-color: #4CAF50;
        }
        .form-container .error {
            background-color: #F44336;
        }
        .form-container form input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container form button {
            width: 100%;
            padding: 10px;
            background-color: #007BFF;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container form button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <form action="/reset_password" method="POST">
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <input type="text" id="otp" name="otp" placeholder="Enter the OTP" required>
            <input type="password" name="password" placeholder="Enter your new password" required>
            <button type="submit">Reset Password</button>
        </form>
    </div>

    <script>
        // Lấy giá trị email và OTP từ URL
        const urlParams = new URLSearchParams(window.location.search);
        const email = urlParams.get('email');
        const otp = urlParams.get('otp');

        // Nếu email có trong URL, tự động điền vào trường input email
        if (email) {
            document.getElementById('email').value = email;
        }

        // Nếu OTP có trong URL, tự động điền vào trường input OTP
        if (otp) {
            document.getElementById('otp').value = otp;
        }
    </script>
</body>
</html>
