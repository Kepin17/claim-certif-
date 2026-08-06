<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat Anda Telah Diterbitkan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>

{{-- ═══ Award Type Config ═══ --}}
@php
    $configs = [
        'juara1' => [
            'gradientFrom'  => '#92610A',
            'gradientTo'    => '#C8860D',
            'accentLight'   => '#FDF4E3',
            'accentBorder'  => '#E8C57A',
            'accentText'    => '#7A4F08',
            'badgeBg'       => 'rgba(255,255,255,0.18)',
            'badgeLabel'    => 'JUARA 1',
            'medal'         => '🥇',
            'headline'      => 'Luar Biasa!',
            'heroSub'       => 'Selamat atas pencapaian luar biasa Anda — Anda meraih Juara 1!',
            'highlight'     => '#C8860D',
            'highlightText' => '#7A4F08',
            'rank'          => 'Juara 1',
        ],
        'juara2' => [
            'gradientFrom'  => '#5E6672',
            'gradientTo'    => '#8B96A5',
            'accentLight'   => '#F2F4F7',
            'accentBorder'  => '#B0BBC9',
            'accentText'    => '#3D4754',
            'badgeBg'       => 'rgba(255,255,255,0.18)',
            'badgeLabel'    => 'JUARA 2',
            'medal'         => '🥈',
            'headline'      => 'Selamat!',
            'heroSub'       => 'Penampilan Anda sangat membanggakan — Anda meraih Juara 2!',
            'highlight'     => '#8B96A5',
            'highlightText' => '#3D4754',
            'rank'          => 'Juara 2',
        ],
        'juara3' => [
            'gradientFrom'  => '#7B4B2A',
            'gradientTo'    => '#B07040',
            'accentLight'   => '#FBF0E8',
            'accentBorder'  => '#D4A07A',
            'accentText'    => '#6B3A1A',
            'badgeBg'       => 'rgba(255,255,255,0.18)',
            'badgeLabel'    => 'JUARA 3',
            'medal'         => '🥉',
            'headline'      => 'Selamat!',
            'heroSub'       => 'Kerja keras Anda terbayar — Anda meraih Juara 3!',
            'highlight'     => '#B07040',
            'highlightText' => '#6B3A1A',
            'rank'          => 'Juara 3',
        ],
        'peserta' => [
            'gradientFrom'  => '#1A54C4',
            'gradientTo'    => '#3478F6',
            'accentLight'   => '#EBF2FF',
            'accentBorder'  => 'rgba(52,120,246,0.25)',
            'accentText'    => '#1A54C4',
            'badgeBg'       => 'rgba(255,255,255,0.15)',
            'badgeLabel'    => 'SERTIFIKAT PESERTA',
            'medal'         => '🎓',
            'headline'      => 'Terima Kasih!',
            'heroSub'       => 'Sertifikat partisipasi Anda telah resmi diterbitkan.',
            'highlight'     => '#3478F6',
            'highlightText' => '#1A54C4',
            'rank'          => null,
        ],
    ];
    $c = $configs[$awardType ?? 'peserta'];
@endphp

<body style="margin:0;padding:0;background:#F2F3F5;font-family:'Inter',-apple-system,BlinkMacSystemFont,sans-serif;-webkit-font-smoothing:antialiased;">

<table width="100%" cellpadding="0" cellspacing="0" border="0" style="padding:40px 16px;background:#F2F3F5;">
<tr>
<td align="center">

    <!-- Outer Container -->
    <table width="580" cellpadding="0" cellspacing="0" border="0" style="width:100%;max-width:580px;">

        <!-- Brand Header -->
        <tr>
            <td align="center" style="padding-bottom:20px;">
                <span style="font-size:11px;font-weight:600;letter-spacing:0.12em;text-transform:uppercase;color:#8E8E93;">
                    KEVIENSTUDIO.MY.ID · CERTIFICATE SYSTEM
                </span>
            </td>
        </tr>

        <!-- Main Card -->
        <tr>
            <td style="background:#FFFFFF;border-radius:24px;overflow:hidden;box-shadow:0 8px 32px rgba(0,0,0,0.10),0 2px 6px rgba(0,0,0,0.05);">

                <!-- ═══ HERO BANNER ═══ -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="background:linear-gradient(135deg,{{ $c['gradientFrom'] }} 0%,{{ $c['gradientTo'] }} 100%);padding:44px 40px 40px;text-align:center;">

                            <!-- Badge -->
                            <div style="display:inline-block;background:{{ $c['badgeBg'] }};border:1px solid rgba(255,255,255,0.25);border-radius:50px;padding:6px 16px;margin-bottom:22px;">
                                <span style="font-size:10px;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:#FFFFFF;">
                                    {{ $c['badgeLabel'] }}
                                </span>
                            </div>

                            <!-- Medal Emoji -->
                            <div style="font-size:54px;line-height:1;margin-bottom:16px;">{{ $c['medal'] }}</div>

                            <!-- Headline -->
                            <h1 style="font-family:'Inter',sans-serif;font-size:30px;font-weight:800;color:#FFFFFF;margin:0 0 10px;line-height:1.15;letter-spacing:-0.5px;">
                                {{ $c['headline'] }}
                            </h1>

                            <!-- Sub -->
                            <p style="margin:0;font-size:14px;line-height:1.65;color:rgba(255,255,255,0.88);max-width:400px;margin:0 auto;">
                                {{ $c['heroSub'] }}
                            </p>

                        </td>
                    </tr>
                </table>

                <!-- ═══ BODY ═══ -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="padding:36px 40px 32px;">

                            <!-- Greeting -->
                            <p style="margin:0 0 8px;font-size:15px;font-weight:600;color:#1C1C1E;line-height:1.5;">
                                Kepada yang terhormat, {{ $name }},
                            </p>
                            <p style="margin:0 0 28px;font-size:14px;line-height:1.75;color:#636366;">
                                @if($awardType === 'peserta')
                                    Kami dengan bangga menyampaikan bahwa sertifikat partisipasi Anda atas keikutsertaan dalam kegiatan di bawah ini telah berhasil diterbitkan. Sertifikat dalam format PDF telah kami lampirkan pada email ini.
                                @else
                                    Kami dengan bangga menyampaikan bahwa Anda berhasil meraih <strong style="color:{{ $c['highlight'] }};">{{ $c['rank'] }}</strong> dalam kegiatan berikut. Sertifikat penghargaan Anda dalam format PDF telah kami lampirkan pada email ini.
                                @endif
                            </p>

                            <!-- ─── Award Rank Card (only for juara) ─── -->
                            @if($awardType !== 'peserta')
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background:{{ $c['accentLight'] }};border:1.5px solid {{ $c['accentBorder'] }};border-radius:16px;margin-bottom:20px;">
                                <tr>
                                    <td style="padding:18px 22px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="52" valign="middle">
                                                    <div style="font-size:36px;line-height:1;">{{ $c['medal'] }}</div>
                                                </td>
                                                <td valign="middle" style="padding-left:14px;">
                                                    <p style="margin:0 0 3px;font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:{{ $c['highlightText'] }};opacity:0.7;">
                                                        Penghargaan
                                                    </p>
                                                    <p style="margin:0;font-size:20px;font-weight:800;color:{{ $c['highlightText'] }};letter-spacing:-0.3px;">
                                                        {{ $c['rank'] }}
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- ─── Event & Certificate Details ─── -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background:#F7F7F8;border-radius:16px;margin-bottom:20px;overflow:hidden;">

                                <!-- Event Row -->
                                <tr>
                                    <td style="padding:16px 22px;">
                                        <p style="margin:0 0 4px;font-size:10px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#8E8E93;">
                                            Event / Kegiatan
                                        </p>
                                        <p style="margin:0;font-size:15px;font-weight:600;color:#1C1C1E;line-height:1.4;">
                                            {{ $event }}
                                        </p>
                                    </td>
                                </tr>

                                <!-- Divider -->
                                <tr><td style="padding:0 22px;"><div style="height:1px;background:#E5E5EA;"></div></td></tr>

                                <!-- Certificate Number -->
                                <tr>
                                    <td style="padding:16px 22px;">
                                        <p style="margin:0 0 4px;font-size:10px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#8E8E93;">
                                            Nomor Sertifikat
                                        </p>
                                        <p style="margin:0;font-size:15px;font-weight:700;color:#1C1C1E;font-family:monospace;letter-spacing:0.05em;">
                                            {{ $certificateNumber }}
                                        </p>
                                    </td>
                                </tr>

                                @if(!empty($certificateType))
                                <!-- Divider -->
                                <tr><td style="padding:0 22px;"><div style="height:1px;background:#E5E5EA;"></div></td></tr>
                                <!-- Type -->
                                <tr>
                                    <td style="padding:16px 22px;">
                                        <p style="margin:0 0 4px;font-size:10px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#8E8E93;">
                                            Kategori
                                        </p>
                                        <p style="margin:0;font-size:15px;font-weight:600;color:#1C1C1E;">
                                            {{ $certificateType }}
                                        </p>
                                    </td>
                                </tr>
                                @endif

                            </table>

                            <!-- ─── Custom Message from Admin ─── -->
                            @if(!empty($customMessage))
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background:#FFFBEB;border:1.5px solid #FCD34D;border-radius:14px;margin-bottom:20px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="30" valign="top" style="padding-top:2px;">
                                                    <span style="font-size:18px;">✉️</span>
                                                </td>
                                                <td valign="top" style="padding-left:12px;">
                                                    <p style="margin:0 0 5px;font-size:11px;font-weight:700;letter-spacing:0.07em;text-transform:uppercase;color:#92400E;">
                                                        Pesan dari Panitia
                                                    </p>
                                                    <p style="margin:0;font-size:14px;line-height:1.7;color:#78350F;white-space:pre-line;">{{ $customMessage }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            @endif

                            <!-- ─── PDF Attachment Notice ─── -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0"
                                   style="background:{{ $c['accentLight'] }};border:1px solid {{ $c['accentBorder'] }};border-radius:14px;margin-bottom:28px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td width="42" valign="middle">
                                                    <div style="width:38px;height:38px;background:{{ $c['highlight'] }};border-radius:10px;text-align:center;line-height:38px;">
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="vertical-align:middle;margin-top:10px;">
                                                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/>
                                                        </svg>
                                                    </div>
                                                </td>
                                                <td valign="middle" style="padding-left:14px;">
                                                    <p style="margin:0 0 3px;font-size:14px;font-weight:700;color:{{ $c['accentText'] }};">
                                                        Sertifikat terlampir pada email ini
                                                    </p>
                                                    <p style="margin:0;font-size:12px;line-height:1.55;color:{{ $c['highlight'] }};">
                                                        Buka lampiran PDF untuk melihat, menyimpan, atau mencetak sertifikat Anda.
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- ─── Divider ─── -->
                            <div style="height:1px;background:#E5E5EA;margin-bottom:20px;"></div>

                            <!-- ─── Footer Note ─── -->
                            <p style="margin:0;font-size:13px;line-height:1.65;color:#8E8E93;">
                                Jika Anda mengalami kendala atau memiliki pertanyaan terkait sertifikat ini, jangan ragu untuk menghubungi tim kami.
                                Sertifikat ini dapat diverifikasi keasliannya secara online.
                            </p>

                        </td>
                    </tr>
                </table>

                <!-- ═══ FOOTER ═══ -->
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td style="background:#F7F7F8;border-top:1px solid #E5E5EA;padding:18px 40px;text-align:center;">
                            <p style="margin:0;font-size:11px;line-height:1.75;color:#AEAEB2;">
                                Email ini dikirim secara otomatis oleh sistem sertifikasi.<br>
                                © {{ date('Y') }} kevienstudio.my.id · All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>