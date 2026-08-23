#!/usr/bin/env python3
"""Remap #4: Gentelella navy/teal inline tokens → Onyx & Champagne"""
import re, os

HEX_MAP = {
    # navy → onyx
    '0F1623':'0C0A08','1A2332':'171310','141D2B':'1E1A14','26324A':'2B241B','2E3B55':'3A3025',
    '0B584A':'0C0A08','12271F':'0C0A08','10261F':'0C0A08','1E182B':'191410','221A38':'1E1810',
    '1B2A44':'241D14','1E2C42':'241D14',
    # text navy → ivory
    'E6EBF2':'F5EFE3','B3BCCB':'DCD3C4','8A93A3':'A99E8E','5A6473':'7A7062','D3DAE4':'E9E2D3',
    # teal accents → champagne
    '1ABB9C':'D6AC63','3CCDB2':'E9C77E','169F85':'C1903F','128771':'B08A3E','5ECFA8':'E9C77E',
    # status → luxe variants
    '51CF66':'82D9A2','2FB344':'55C47E','28993B':'3FAE68','F0645C':'E4686F','F27676':'F08C92',
    'F5A93B':'F5BC82','EFA45B':'EFA45B','74B9F2':'AEC4DC','9FB4CE':'AEC4DC',
    'C069DD':'C0A8E8','BEA6E0':'C0A8E8','E6688D':'E4758B','F5BC82':'F5BC82','F08C92':'F08C92',
    # tooltip ivory→gold handled in CSS; fallback
    'FFF3D6':'FFF3D6','FFF6E3':'FFF6E3',
}
HEX_MAP = {k.upper(): v for k, v in HEX_MAP.items()}

RGBA_MAP = {
    (15,22,35):(12,10,8),
    (26,35,50):(23,19,16),
    (20,29,43):(30,26,20),
    (26,187,156):(214,172,99),
    (60,205,178):(233,199,126),
    (22,159,133):(193,144,63),
    (18,15,11):(18,15,11),   # already onyx — keep
    (12,10,8):(12,10,8),
    (66,153,225):(159,180,206),
    (47,179,68):(85,196,126),
    (81,207,102):(130,217,162),
    (240,100,92):(228,104,111),
    (245,159,0):(239,164,91),
    (214,57,57):(228,104,111),
    (192,105,221):(192,168,232),
    (230,104,141):(228,117,139),
}

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

def map_hex(m):
    h = m.group(1).upper()
    return '#' + HEX_MAP.get(h, m.group(1))

def map_rgba(m):
    r, g, b = int(m.group(1)), int(m.group(2)), int(m.group(3))
    a = m.group(4)
    key = (r, g, b)
    if key not in RGBA_MAP:
        return m.group(0)
    nr, ng, nb = RGBA_MAP[key]
    if a is not None:
        return f'rgba({nr},{ng},{nb},{a})'
    return f'rgb({nr},{ng},{nb})'

total = 0
for rel in FILES:
    path = os.path.join(BASE, rel)
    if not os.path.exists(path):
        continue
    src = open(path, encoding='utf-8').read()
    out, n1 = hex6.subn(map_hex, src)
    out, n2 = rgba.subn(map_rgba, out)
    if out != src:
        open(path, 'w', encoding='utf-8').write(out)
    print(f'{rel}: hex={n1} rgba={n2} changed={out!=src}')
    total += n1 + n2
print('TOTAL:', total)
