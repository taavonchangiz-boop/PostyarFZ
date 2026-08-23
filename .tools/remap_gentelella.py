#!/usr/bin/env python3
"""
Postyar × Gentelella — Remap #2: Zarrin dark → Gentelella light
Presentation-only token substitution across views + JS.
Dark surface rgbas get alpha-scaled to faint light tints.
"""
import re, os

HEX_MAP = {
    # backgrounds/surfaces → Gentelella light
    '0D0B08':'F5F7FB','14110D':'F9FAFB','120F0B':'F5F7FB','171310':'F9FAFB',
    '1B1712':'FFFFFF','241F18':'F9FAFB','2E2820':'FFFFFF','241D10':'FFFFFF',
    '221D16':'F9FAFB','2A180C':'F9FAFB','241A0C':'F9FAFB','33270F':'F9FAFB',
    '1D2550':'FFFFFF','111B34':'FFFFFF','1A2332':'1A2332',  # sidebar dark نگه داشته می‌شود
    # borders → Gentelella
    '3B342A':'E6E7EB','6B6053':'D5D8DD','8A7F72':'AEB6C0','57493A':'C9CED6',
    '4A4237':'D5D8DD','332D24':'E6E7EB','241F18':'F9FAFB',
    # text → dark-on-light
    'FBF8F3':'1E2633','E9E2D6':'1E2633','D6CCC0':'626D7D','C9BFAF':'626D7D',
    'B0A695':'626D7D','7D7365':'7E8896','F7F3ED':'F9FAFB','DCD3C5':'626D7D',
    'E0D7CA':'626D7D','EDE6D9':'626D7D','F0E8DB':'626D7D','E4EBF5':'626D7D',
    'FFF6DE':'0F6E5D','F6E7C2':'128771','F2DCA0':'0F6E5D','F0D68A':'0F6E5D',
    # primary gold → Gentelella teal (text tokens → dark teal for AA)
    'E5B44E':'0F6E5D','D9A036':'169F85','EFC968':'128771','EEC25E':'1ABB9C',
    'BC8623':'169F85','96691C':'128771','EDBE55':'1ABB9C','E2AC43':'169F85',
    'F3C96B':'1ABB9C','D4A72C':'169F85','3CCDB2':'3CCDB2','5ED4BE':'5ED4BE',
    'FBF3DD':'E5F7F3','FBF3DD'.lower():'E5F7F3',
    # teal accent → azure
    '4AD6BE':'0B5ED7','2FBFA6':'0B5ED7',
    # green → Gentelella green
    '3DD68C':'2FB344','35C47E':'2FB344','2BB377':'28993B','8CEBB8':'1E7E34',
    'D8F5E6':'DFF6E7','7FE6AC':'28993B','0A2E1F':'FFFFFF','0F3D2C':'DFF6E7',
    'B0EDCF':'DFF6E7','185A3E':'28993B','239261':'28993B','2FA346':'28993B',
    # red/rose
    'F0645C':'D63939','F5837C':'D63939','DC4B44':'BC2F2F','F9A39D':'D63939',
    'C23A34':'BC2F2F','B23A34':'9B2626','99302B':'7C1E1E','FADCDA':'FBE0E0',
    # warning/orange → yellow family (dark text variants)
    'F98E3F':'B45309','FBAF6B':'B45309','E07A2F':'D98600','F07A35':'D98600',
    'FBB47E':'B45309','FCC48D':'7A4B00','FCCB9E':'7A4B00','B0611F':'8F5800',
    # purple family (copper→Gentelella purple)
    'C77E3C':'732088','D08A4A':'8E2BA8','E3AC81':'862D9E','A66428':'732088',
    # pink → Gentelella pink
    'E8654F':'D6336C','EF8A73':'D6336C','D14E3B':'C02A62','F5A48F':'D6336C',
    'FAC7BC':'FBE0E9','FDE3DD':'FBE0E9','FEF1EE':'FDF0F4',
    # blue steel
    '4A8FD0':'066FD1','3A76B8':'055CB4','2C5FA6':'055CB4','6AA9DE':'4299E1',
    '8FBFE8':'9DD1F5','EAF2FB':'EAF2FB','DCE9F5':'DCE9F5','D7E7F8':'DCE9F5',
    # misc
    'FCCB9E':'7A4B00','1F1502':'FFFFFF','FFF9EC':'F0FAF8','A79C8E':'7E8896',
    '9CCDC0':'0B5ED7','E8B04B':'E8B04B',  # admin link accent (ثبت دستی)
}
HEX_MAP = {k.upper(): v for k, v in HEX_MAP.items()}

# rgb triplet map: (r,g,b) → (r,g,b) — alpha policy applied separately
RGBA_MAP = {
    (217,160,54):(26,187,156),   # gold → teal (keep alpha)
    (229,180,78):(26,187,156),
    (239,201,104):(26,187,156),
    (188,134,35):(22,159,133),
    (150,105,28):(18,135,113),
    (237,190,85):(26,187,156),
    (74,214,190):(66,153,225),   # teal → azure
    (47,191,166):(66,153,225),
    (53,196,126):(47,179,68),    # green
    (61,214,140):(47,179,68),
    (43,179,119):(40,153,59),
    (240,100,92):(214,57,57),    # red
    (245,131,124):(214,57,57),
    (220,75,68):(188,47,47),
    (249,142,63):(245,159,0),    # orange → yellow
    (251,175,107):(245,159,0),
    (224,122,47):(217,134,0),
    (240,122,53):(217,134,0),
    (199,126,60):(174,62,201),   # copper → purple
    (232,101,79):(214,51,108),   # coral → pink
    (63,127,204):(6,111,209),    # steel blue
    (44,95,166):(5,92,180),
    (6,4,2):(15,23,42),          # shadows → keep dark (alpha kept)
    (2,6,23):(15,23,42),
    (0,0,0):(0,0,0),
    (255,255,255):(255,255,255), # handled by policy for low-alpha
    (31,21,2):(255,255,255),     # old gold-btn text → white text
    (13,11,8):(30,38,51),        # dark surfaces → policy scales alpha
    (20,17,13):(30,38,51),
    (23,19,16):(30,38,51),
    (27,23,18):(30,38,51),
    (36,31,24):(30,38,51),
    (46,40,32):(30,38,51),
    (59,52,42):(30,38,51),
    (87,73,58):(174,182,192),
    (110,100,87):(192,199,207),
    (24,20,15):(30,38,51),
    (18,14,11):(30,38,51),
    (17,14,11):(30,38,51),
    (34,29,22):(30,38,51),
    (52,42,26):(30,38,51),
    (23,18,11):(30,38,51),
}
# keys whose alpha gets scaled down (dark-surface tints → faint gray tints)
ALPHA_SCALE = {
    (13,11,8):0.07,(20,17,13):0.07,(23,19,16):0.07,(27,23,18):0.06,
    (36,31,24):0.06,(46,40,32):0.08,(59,52,42):0.08,(24,20,15):0.07,
    (18,14,11):0.07,(17,14,11):0.07,(34,29,22):0.06,(52,42,26):0.08,(23,18,11):0.08,
}
# white low-alpha (glass highlights) → faint dark hairlines
WHITE_ALPHA_MAX = 0.2
WHITE_SCALE = 0.5

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
    'public_html/assets/js/push.js',
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
    alpha = float(a) if a is not None else None
    if key == (255,255,255):
        # white overlays → hairline dark, only for low alphas
        if alpha is None or alpha > WHITE_ALPHA_MAX:
            return m.group(0)
        na = round(min(alpha * WHITE_SCALE + 0.02, 0.12), 3)
        return f'rgba(30,38,51,{na})'
    if key in ALPHA_SCALE and alpha is not None:
        na = round(min(alpha * ALPHA_SCALE[key] * 2, 0.10), 3)
        return f'rgba({nr},{ng},{nb},{na})'
    if alpha is not None:
        return f'rgba({nr},{ng},{nb},{alpha})'
    return f'rgb({nr},{ng},{nb})'

total = 0
for rel in FILES:
    path = os.path.join(BASE, rel)
    if not os.path.exists(path):
        print('SKIP', rel); continue
    src = open(path, encoding='utf-8').read()
    out, n1 = hex6.subn(map_hex, src)
    out, n2 = rgba.subn(map_rgba, out)
    if out != src:
        open(path, 'w', encoding='utf-8').write(out)
    print(f'{rel}: hex={n1} rgba={n2} changed={out!=src}')
    total += n1 + n2
print('TOTAL:', total)
