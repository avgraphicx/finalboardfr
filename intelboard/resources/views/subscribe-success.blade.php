<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscription Successful - Intelboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Space Grotesk', sans-serif;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .status-card {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 1rem;
            padding: 3rem;
            background: #fff;
            box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            max-width: 500px;
            text-align: center;
        }

        .status-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <div class="status-card">
        <div class="status-icon text-success">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
            </svg>
        </div>
        <h1 class="h3 fw-semibold">Payment Successful!</h1>
        <p class="text-muted">Thank you for your subscription. Your payment was processed successfully. You will receive
            a confirmation email shortly.</p>
        <a href="{{ route('landing') }}" class="btn btn-primary mt-3">Return to Homepage</a>
    </div>
</body>

</html>
