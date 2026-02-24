<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page not found</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f9fafc;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #1e293b;
            line-height: 1.5;
            padding: 1.5rem;
        }

        .status-code {
            font-size: 8rem;
            font-weight: 700;
            line-height: 1;
            color: #0f172a;
            letter-spacing: -0.02em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.15rem;
            margin-bottom: 0.25rem;
        }

        .status-code span {
            background: linear-gradient(145deg, #2563eb, #1e40af);
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        .message {
            font-size: 1.8rem;
            font-weight: 500;
            color: #0f172a;
            margin-bottom: 1rem;
            letter-spacing: -0.01em;
        }

        .description {
            font-size: 1.1rem;
            color: #475569;
            max-width: 450px;
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 2.5rem;
            border-left: 4px solid #e2e8f0;
            padding-left: 1.25rem;
            text-align: left;
        }

        .description strong {
            color: #1e293b;
            font-weight: 600;
            background: #f1f5f9;
            padding: 0.15rem 0.4rem;
            border-radius: 6px;
            font-size: 0.95em;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-top: 0.75rem;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.85rem 2rem;
            font-weight: 500;
            font-size: 1rem;
            border-radius: 60px;
            text-decoration: none;
            transition: all 0.2s;
            border: 1.5px solid transparent;
            cursor: pointer;
            background: white;
            color: #1e293b;
            border-color: #e2e8f0;
            box-shadow: 0 2px 6px rgba(0,0,0,0.02);
        }

        .btn-primary {
            background: #0f172a;
            color: white;
            border-color: #0f172a;
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.2);
        }

        .btn-primary:hover {
            background: #1e293b;
            border-color: #1e293b;
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -8px rgba(15, 23, 42, 0.3);
        }

        .btn-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
            transform: translateY(-2px);
        }

        .btn-primary svg {
            margin-right: 0.5rem;
            width: 18px;
            height: 18px;
            fill: currentColor;
        }

        .footer-note {
            margin-top: 3rem;
            font-size: 0.9rem;
            color: #94a3b8;
            border-top: 1px solid #ecf1f7;
            padding-top: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .footer-note a {
            color: #475569;
            text-decoration: none;
            border-bottom: 1px dotted #cbd5e1;
        }

        .footer-note a:hover {
            color: #0f172a;
            border-bottom: 1px solid #0f172a;
        }

        @media (max-width: 500px) {
            .status-code {
                font-size: 5.5rem;
            }
            .message {
                font-size: 1.5rem;
            }
            .description {
                font-size: 1rem;
                padding-left: 1rem;
            }
            .actions {
                flex-direction: column;
                width: 100%;
            }
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div role="main" aria-labelledby="404-title">
        <div class="status-code">
            <span>4</span><span>0</span><span>4</span>
        </div>

        <div class="message" id="404-title">Page not found</div>

        <div class="description">
            <span>🔍</span> Couldn't find <strong>this page</strong> — it might have moved, or the address was mistyped. Let's get you back on track.
        </div>

        <div class="actions">
            <a href="webadmin/dashboard" class="btn btn-primary">
                Go Back
            </a>
        </div>
</body>
</html>