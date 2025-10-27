<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Canceled - Intelboard</title>
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
        <div class="status-icon text-warning">
            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16">
                <path
                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
            </svg>
        </div>
        <h1 class="h3 fw-semibold">Payment Canceled</h1>
        <p class="text-muted">Your payment process was canceled. You have not been charged. If you wish to try again,
            you can return to the subscription page.</p>
        <a href="{{ route('subscriptions.checkout') }}" class="btn btn-primary mt-3">Try Again</a>
        <a href="{{ route('landing') }}" class="btn btn-secondary mt-3">Return to Homepage</a>
    </div>
</body>

</html>
