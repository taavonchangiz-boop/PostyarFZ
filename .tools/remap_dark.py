#!/usr/bin/env python3
"""
Postyar × Gentelella — Remap #3: Light → Dark (official Gentelella dark theme)
Applies professional dark palette to every inline token across views + JS.
"""
import re, os

HEX_MAP = {
    # زمینه‌ها/سطوح روشن → تیره
    'F5F7FB':'0F1623','F9FAFB':'141D2B','FFFFFF':'1A2332','EFF0F3':'26324A',
    'E6E7EB':'26324A','D5D8DD':'2E3B55','F7F3ED':'141D2B','F1F3F6':'141D2B',
    'DCE9F5':'1E2C42','EAF2FB':'1B2A44','D7E7F8':'1E2C42','E5F7F3':'12271F',
    'DFF6E7':'12271F','FBE0E9':'2A1720','FBE0E0':'2A1720','FDF0F4':'2A1720',
    'EDFBF1':'12271F','D9F6EF':'10261F','E8F8F6':'10261F','D2F1ED':'10261F',
    'F6F3FB':'1E182B','EDE7F7':'1E182B','D9CDF0':'221A38','C0AAE6':'8B5FB5',
    'F0FAF8':'10261F','9DD1F5':'1E2C42','8EC1F1':'1E2C42',
    # متن‌های تیره → روشن (روی زمینه تیره)
    '1E2633':'E6EBF2','626D7D':'B3BCCB','7E8896':'8A93A3','C0C7CF':'5A6473',
    '4A5462':'8A93A3','333E4E':'B3BCCB','AEB6C0':'5A6473',
    # رنگ‌های تأکیدی متنی — نسخه‌های روشن برای زمینه تیره
    '0F6E5D':'3CCDB2','128771':'3CCDB2','169F85':'3CCDB2',
    '0B5ED7':'74B9F2','066FD1':'74B9F2','055CB4':'5C9FE7','2C5FA6':'5C9FE7',
    '1E7E34':'51CF66','28993B':'51CF66','217D31':'51CF66',
    'B45309':'F5A93B','7A4B00':'FFC078','D98600':'F5A93B','8F5800':'FFC078',
    'D63939':'F0645C','BC2F2F':'F0645C','9B2626':'F27676','7C1E1E':'C9564F',
    '732088':'C069DD','8E2BA8':'C069DD','862D9E':'C069DD','471553':'3A1A4A',
    'C02A62':'E6688D','9E2250':'E6688D',
    # فیروزه‌ای اصلی — متن‌های روی زمینه تیره روشن‌تر
    'E5F7F3':'12271F',
}
HEX_MAP = {k.upper(): v for k, v in HEX_MAP.items()}

RGBA_MAP = {
    (245,247,251):(15,22,35),      # body-bg
    (249,250,251):(20,29,43),      # surface-2
    (255,255,255):(255,255,255),   # policy handler
    (30,38,51):(10,15,26),         # shadows → تیره‌تر
    (15,23,42):(0,0,0),            # سایه‌ها
    (233,226,214):(255,255,255),   # hairline روشن → سفید کم‌آلفا (policy)
    (6,4,2):(0,0,0),
    (2,6,23):(0,0,0),
}
# سفید پررنگ (bg:#fff) → سطح تیره؛ سفید کم‌آلفا (هایلایت) → سفید کم‌آلفا تیره‌پسند
WHITE_BG_KEYS = {(255,255,255)}

FILES = [
    'postyar-private/app/Views/dashboard.php',
    'postyar-private/app/Views/admin.php',
    'postyar-private/app/Views/home.php',
    'postyar-private/app/Views/help.php',
    'postyar-private/app/Views/privacy.php',
    'postyar-private/app/Views/errors.php',
    'postyar-private/app/Views/partials/referral-section.php',
    'postyar-private/app/Views/partials/wallet-section.php',
    'postyar-private/app/Views/partials/admin-referral-settings.php',
    'postyar-private/app/Views/partials/admin-sms-settings.php',
    'postyar-private/app/Views/partials/admin-provider-settings.php',
    'postyar-private/app/Views/partials/admin-email-settings.php',
    'public_html/assets/js/dashboard.js',
    'public_html/assets/js/admin.js',
    'public_html/assets/js/pwa-install.js',
]
BASE = '/home/z/my-project/postyar-work/'

hex6 = re.compile(r'#([0-9a-fA-F]{6})\b')
rgba = re.compile(r'rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*([0-9.]+)\s*)?\)')
# الگوهای پس‌زمینه سفید (فقط background:#fff — نه متن سفید روی رنگ)
bg_white = re.compile(r'(background(?:-color)?\s*:\s*)#FFFFFF\b', re.I)
bg_white_short = re.compile(r'(background(?:-color)?\s*:\s*)#fff\b(?!f)', re.I)

def map_hex(m):
    h = m.group(1).upper()
    return '#' + HEX_MAP.get(h, m.group(1))

def map_rgba(m):
    r, g, b = int(m.group(1)), int(m.group(2)), int(m.group(3))
    a = m.group(4)
    key = (r, g, b)
    if key == (255,255,255):
        if a is not None and float(a) <= 0.5:
            na = round(float(a) * 0.6, 3)  # هایلایت‌های سفید → ملایم‌تر روی تیره
            return f'rgba(255,255,255,{na})'
        return m.group(0)  # سفید پررنگ/بی‌آلفا دست‌نخورده (متن روی teal و ...)
    if key in RGBA_MAP:
        nr, ng, nb = RGBA_MAP[key]
        if a is not None:
            return f'rgba({nr},{ng},{nb},{a})'
        return f'rgb({nr},{ng},{nb})'
    return m.group(0)

total = 0
for rel in FILES:
    path = os.path.join(BASE, rel)
    if not os.path.exists(path):
        print('SKIP', rel); continue
    src = open(path, encoding='utf-8').read()
    out = src
    # ۱) background:#fff/#FFFFFF → سطح تیره (قبل از نگاشت عمومی تا وارد policy نشود)
    out = bg_white.sub(r'\g<1>#1A2332', out)
    out = bg_white_short.sub(r'\g<1>#1A2332', out)
    # ۲) بقیه hexها
    out, n1 = hex6.subn(map_hex, out)
    # ۳) rgbaها
    out, n2 = rgba.subn(map_rgba, out)
    if out != src:
        open(path, 'w', encoding='utf-8').write(out)
    print(f'{rel}: hex={n1} rgba={n2} changed={out!=src}')
    total += n1 + n2
print('TOTAL:', total)
