<!DOCTYPE html>
<html>
<head>
    <style>
        .footer {
            padding: 5px 10px;
            font-size: 8pt;
            text-align: right;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="footer">
        <table width="100%">
            <tr>
                <td style="text-align: left;">
                    {{ config('app.name') }}
                </td>
                <td style="text-align: right;">
                    Halaman [page] dari [topage]
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
