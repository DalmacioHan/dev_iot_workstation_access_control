<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Verification Code</title>
</head>
<body style="margin:0;padding:0;background:#f6f7fb;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:560px;background:#ffffff;border-radius:16px;border:1px solid #e5e7eb;overflow:hidden;">
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 12px;font-size:14px;letter-spacing:.08em;text-transform:uppercase;color:#6b7280;">Password Change Verification</p>
                            <h1 style="margin:0 0 16px;font-size:24px;line-height:1.2;color:#111827;">Your verification code</h1>
                            <p style="margin:0 0 24px;font-size:15px;line-height:1.7;color:#374151;">Use the code below to confirm your password change. It expires after this request is completed.</p>

                            <div style="margin:0 0 24px;padding:18px 20px;background:#eff6ff;border:1px solid #bfdbfe;border-radius:12px;text-align:center;">
                                <span style="display:block;font-size:32px;letter-spacing:10px;font-weight:700;color:#1d4ed8;">{{ $code }}</span>
                            </div>

                            <p style="margin:0;font-size:14px;line-height:1.7;color:#6b7280;">If you did not request this change, you can safely ignore this email.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>