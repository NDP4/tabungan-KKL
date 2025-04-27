<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        /* Base */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #2d3748;
            margin: 0;
            padding: 0;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f7fafc;
            padding: 30px 0;
        }
        .email-content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            width: 80px;
            height: auto;
            margin-bottom: 20px;
        }
        h1 {
            color: #1a365d;
            font-size: 24px;
            font-weight: bold;
            margin: 0 0 20px;
        }
        p {
            margin: 0 0 20px;
            color: #4a5568;
        }
        .button {
            display: inline-block;
            background-color: #4299e1;
            color: #ffffff !important;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .button:hover {
            background-color: #3182ce;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #edf2f7;
            text-align: center;
            font-size: 14px;
            color: #718096;
        }
        .url-note {
            margin-top: 20px;
            padding: 15px;
            background-color: #f7fafc;
            border-radius: 6px;
            font-size: 14px;
            color: #718096;
            word-break: break-all;
        }
        .info-box {
            background-color: #ebf8ff;
            border-left: 4px solid #4299e1;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .amount {
            font-size: 18px;
            font-weight: 600;
            color: #2c5282;
        }
        .progress-container {
            background-color: #edf2f7;
            border-radius: 9999px;
            padding: 3px;
            margin: 15px 0;
        }
        .progress-bar {
            background-color: #4299e1;
            height: 8px;
            border-radius: 9999px;
            transition: width 0.3s ease;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-content">
            <div class="header">
                @if(settings('site_logo'))
                    <img src="{{ config('app.storage_url') . '/' . settings('site_logo') }}" alt="{{ settings('site_name') }}" class="logo">
                @endif
                <h1>@yield('title')</h1>
            </div>

            @yield('content')

            <div class="footer">
                <p>Salam,<br>{{ settings('site_name', 'Panitia KKL') }}</p>
            </div>
        </div>
    </div>
</body>
</html>
