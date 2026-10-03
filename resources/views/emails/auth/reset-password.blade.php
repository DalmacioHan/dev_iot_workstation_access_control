
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        http-equiv="X-UA-Compatible"
        content="IE=edge"
    >

    <title>Reset Your Password</title>

</head>


<body
    style="
        margin:0;
        padding:0;
        background-color:#f8fafc;
        font-family:Arial, Helvetica, sans-serif;
        color:#0f172a;
    "
>

<table
    width="100%"
    cellpadding="0"
    cellspacing="0"
    border="0"
    style="background-color:#f8fafc;"
>

    <tr>

        <td
            align="center"
            style="padding:40px 16px;"
        >

            {{-- =====================================================
                MAIN CONTAINER
            ====================================================== --}}
            <table
                width="100%"
                cellpadding="0"
                cellspacing="0"
                border="0"
                style="
                    max-width:600px;
                    background:#ffffff;
                    border:1px solid #e2e8f0;
                    border-radius:20px;
                    overflow:hidden;
                "
            >

                {{-- =================================================
                    HEADER
                ================================================== --}}
                <tr>

                    <td
                        style="
                            background:#2563eb;
                            padding:32px 30px;
                            text-align:center;
                        "
                    >

                        {{-- =================================================
                            LOCK LOGO
                        ================================================== --}}
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            align="center"
                        >

                            <tr>

                                <td
                                    width="64"
                                    height="64"
                                    align="center"
                                    valign="middle"
                                    style="
                                        width:64px;
                                        height:64px;
                                        background:#ffffff;
                                        border-radius:16px;
                                    "
                                >

                                    {{-- Lock --}}
                                    <table
                                        cellpadding="0"
                                        cellspacing="0"
                                        border="0"
                                        align="center"
                                    >

                                        {{-- Shackle --}}
                                        <tr>

                                            <td
                                                align="center"
                                                style="
                                                    height:17px;
                                                    font-size:0;
                                                "
                                            >

                                                <div
                                                    style="
                                                        width:22px;
                                                        height:17px;
                                                        border:3px solid #2563eb;
                                                        border-bottom:0;
                                                        border-radius:14px 14px 0 0;
                                                        box-sizing:border-box;
                                                    "
                                                ></div>

                                            </td>

                                        </tr>


                                        {{-- Lock Body --}}
                                        <tr>

                                            <td
                                                align="center"
                                                style="
                                                    font-size:0;
                                                "
                                            >

                                                <div
                                                    style="
                                                        width:32px;
                                                        height:25px;
                                                        background:#2563eb;
                                                        border-radius:5px;
                                                        position:relative;
                                                    "
                                                >

                                                    {{-- Keyhole --}}
                                                    <div
                                                        style="
                                                            position:absolute;
                                                            top:7px;
                                                            left:13px;
                                                            width:6px;
                                                            height:6px;
                                                            background:#ffffff;
                                                            border-radius:50%;
                                                        "
                                                    ></div>

                                                    <div
                                                        style="
                                                            position:absolute;
                                                            top:12px;
                                                            left:15px;
                                                            width:2px;
                                                            height:7px;
                                                            background:#ffffff;
                                                            border-radius:2px;
                                                        "
                                                    ></div>

                                                </div>

                                            </td>

                                        </tr>

                                    </table>

                                </td>

                            </tr>

                        </table>


                        <h1
                            style="
                                margin:20px 0 0;
                                color:#ffffff;
                                font-size:25px;
                                line-height:34px;
                                font-weight:700;
                            "
                        >
                            {{ config('app.name') }}
                        </h1>


                        <p
                            style="
                                margin:7px 0 0;
                                color:#dbeafe;
                                font-size:14px;
                                line-height:22px;
                            "
                        >
                            Secure account management
                        </p>

                    </td>

                </tr>


                {{-- =================================================
                    CONTENT
                ================================================== --}}
                <tr>

                    <td
                        style="
                            padding:40px 36px;
                        "
                    >

                        <p
                            style="
                                margin:0 0 8px;
                                color:#64748b;
                                font-size:14px;
                            "
                        >
                            Hello {{ $user->name ?? 'there' }},
                        </p>


                        <h2
                            style="
                                margin:0 0 16px;
                                color:#0f172a;
                                font-size:24px;
                                line-height:32px;
                                font-weight:700;
                            "
                        >
                            Reset your password
                        </h2>


                        <p
                            style="
                                margin:0 0 20px;
                                color:#475569;
                                font-size:15px;
                                line-height:26px;
                            "
                        >
                            We received a request to reset the password
                            associated with your account.
                        </p>


                        <p
                            style="
                                margin:0 0 28px;
                                color:#475569;
                                font-size:15px;
                                line-height:26px;
                            "
                        >
                            Click the button below to create a new password
                            and regain access to your account.
                        </p>


                        {{-- =================================================
                            RESET BUTTON
                        ================================================== --}}
                        <table
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            width="100%"
                        >

                            <tr>

                                <td align="center">

                                    <a
                                        href="{{ $resetUrl }}"
                                        style="
                                            display:inline-block;
                                            background:#2563eb;
                                            color:#ffffff;
                                            text-decoration:none;
                                            font-size:15px;
                                            font-weight:700;
                                            padding:15px 28px;
                                            border-radius:10px;
                                        "
                                    >
                                        Reset My Password
                                    </a>

                                </td>

                            </tr>

                        </table>


                        {{-- =================================================
                            EXPIRATION NOTICE
                        ================================================== --}}
                        <table
                            width="100%"
                            cellpadding="0"
                            cellspacing="0"
                            border="0"
                            style="
                                margin-top:30px;
                                background:#eff6ff;
                                border:1px solid #dbeafe;
                                border-radius:12px;
                            "
                        >

                            <tr>

                                <td
                                    style="
                                        padding:16px;
                                        color:#1e40af;
                                        font-size:13px;
                                        line-height:21px;
                                    "
                                >

                                    <strong>
                                        Security notice
                                    </strong>

                                    <br>

                                    This password reset link will expire in
                                    {{ $expireMinutes }} minutes.

                                </td>

                            </tr>

                        </table>


                        {{-- =================================================
                            SECURITY WARNING
                        ================================================== --}}
                        <div
                            style="
                                margin-top:28px;
                                padding-top:24px;
                                border-top:1px solid #e2e8f0;
                            "
                        >

                            <p
                                style="
                                    margin:0 0 10px;
                                    color:#334155;
                                    font-size:13px;
                                    font-weight:700;
                                "
                            >
                                Didn't request a password reset?
                            </p>


                            <p
                                style="
                                    margin:0;
                                    color:#64748b;
                                    font-size:13px;
                                    line-height:21px;
                                "
                            >
                                You can safely ignore this email. Your password
                                will remain unchanged and no action is required.
                            </p>

                        </div>


                        {{-- =================================================
                            FALLBACK URL
                        ================================================== --}}
                        <div
                            style="
                                margin-top:28px;
                            "
                        >

                            <p
                                style="
                                    margin:0 0 8px;
                                    color:#64748b;
                                    font-size:12px;
                                    line-height:18px;
                                "
                            >
                                If the button above does not work, copy and
                                paste this URL into your browser:
                            </p>


                            <p
                                style="
                                    margin:0;
                                    word-break:break-all;
                                    color:#2563eb;
                                    font-size:12px;
                                    line-height:20px;
                                "
                            >
                                {{ $resetUrl }}
                            </p>

                        </div>

                    </td>

                </tr>


                {{-- =================================================
                    FOOTER
                ================================================== --}}
                <tr>

                    <td
                        style="
                            padding:24px 30px;
                            background:#f8fafc;
                            border-top:1px solid #e2e8f0;
                            text-align:center;
                        "
                    >

                        <p
                            style="
                                margin:0;
                                color:#64748b;
                                font-size:12px;
                                line-height:20px;
                            "
                        >
                            © {{ date('Y') }}
                            {{ config('app.name') }}.
                            All rights reserved.
                        </p>


                        <p
                            style="
                                margin:5px 0 0;
                                color:#94a3b8;
                                font-size:11px;
                            "
                        >
                            This is an automated security email.
                            Please do not reply.
                        </p>

                    </td>

                </tr>

            </table>


            {{-- =====================================================
                OUTSIDE FOOTER
            ====================================================== --}}
            <p
                style="
                    margin:20px 0 0;
                    color:#94a3b8;
                    font-size:11px;
                    text-align:center;
                "
            >
                Secure account recovery
            </p>

        </td>

    </tr>

</table>

</body>

</html>

