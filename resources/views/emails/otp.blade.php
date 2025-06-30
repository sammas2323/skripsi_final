<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
      <td align="center" style="padding: 30px 0;">
        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 8px; padding: 30px; box-shadow: 0 0 10px rgba(0,0,0,0.05);">
          <tr>
            <td align="center" style="padding-bottom: 20px;">
              <h2 style="font-size: 24px; color: #333333; margin: 0;">Kode Verifikasi Anda</h2>
            </td>
          </tr>
          <tr>
            <td style="font-size: 16px; color: #555555; text-align: center; padding-bottom: 20px;">
              Gunakan kode di bawah ini untuk memverifikasi akun Anda.
            </td>
          </tr>
          <tr>
            <td align="center" style="padding: 20px 0;">
              <div style="display: inline-block; background-color: #2563eb; color: #ffffff; padding: 15px 30px; font-size: 24px; font-weight: bold; letter-spacing: 4px; border-radius: 6px;">
                {{ $otp }}
              </div>
            </td>
          </tr>
          <tr>
            <td style="font-size: 14px; color: #888888; text-align: center; padding-top: 20px;">
              Jangan berikan kode ini kepada siapa pun.
            </td>
          </tr>
          <tr>
            <td style="padding-top: 30px; text-align: center; font-size: 12px; color: #aaaaaa;">
              © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>