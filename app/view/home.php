<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= htmlspecialchars($title) ?></title>
    <style>
        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #0f172a;
            color: #e5e7eb;
        }

        .container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            background: #020617;
            border-radius: 8px;
            padding: 32px;
            max-width: 420px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4);
        }

        h1 {
            margin: 0 0 12px 0;
            font-size: 28px;
            color: #38bdf8;
        }

        p {
            margin: 0 0 16px 0;
            line-height: 1.5;
            color: #cbd5f5;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            background: #1e293b;
            border-radius: 20px;
            font-size: 12px;
            color: #93c5fd;
            margin-bottom: 16px;
        }

        .footer {
            margin-top: 24px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <span class="badge">Khumba Framework</span>
        <h1><?= htmlspecialchars($message) ?></h1>
        <p>
            Framework PHP ringan, struktur sederhana,
            kompatibel untuk sistem lama dan baru.
        </p>

        <div class="footer">
            Phase 1 · Foundation Ready
        </div>
    </div>
</div>

</body>
</html>
