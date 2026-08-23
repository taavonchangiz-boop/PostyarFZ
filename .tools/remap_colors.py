#!/usr/bin/env python3
"""
Postyar «Zarrin» Redesign — Inline Color Remapper
Maps legacy indigo/slate palette colors to the new warm gold design system.
Presentation-only: replaces color literals; never touches PHP logic, IDs,
names, data attributes or JS behavior.
"""
import re, sys, os

# ---------- HEX mapping (case-insensitive) ----------
HEX_MAP = {
    # backgrounds / surfaces (slate/navy -> warm stone)
    '070b14':'0D0B08','0a0a0a':'0D0B08','090d1a':'120F0B','0a101d':'120F0B',
    '0b1120':'14110D','0b1020':'14110D','0c0c10':'14110D','0f172a':'171310',
    '0e1525':'1B1712','111116':'1B1712','1e293b':'241F18','131d31':'241F18',
    '121b2e':'241F18','18243a':'2E2820','202e47':'3B342A',
    '1e1b4b':'241A0C','311042':'2A180C','1d2550':'33270F','111b34':'241D10',
    # borders (slate -> stone)
    '334155':'3B342A','475569':'6B6053','64748b':'8A7F72',
    # text (slate -> warm text)
    '94a3b8':'B0A695','cbd5e1':'D6CCC0','e2e8f0':'E9E2D6','62718a':'7D7365',
    'f8fafc':'FBF8F3','fafafa':'F7F3ED',
    # primary indigo -> gold
    '6366f1':'D9A036','818cf8':'E5B44E','a5b4fc':'EFC968','4f46e5':'BC8623',
    '4338ca':'96691C','c7d2fe':'F2DCA0','929cff':'EEC25E','e0e7ff':'F6E7C2',
    'e6eaff':'F6E7C2','8b5cf6':'C77E3C','a855f7':'C77E3C','7c3aed':'A66428',
    '9333ea':'A66428',
    # cyan/sky -> teal
    '22d3ee':'4AD6BE','38bdf8':'4AD6BE','0ea5e9':'4AD6BE','06b6d4':'2FBFA6',
    # green -> emerald
    '10b981':'35C47E','34d399':'3DD68C','059669':'2BB377','047857':'239261',
    '86efac':'8CEBB8','d1fae5':'D8F5E6','6ee7b7':'7FE6AC','052e24':'0A2E1F',
    '064e3b':'0F3D2C','a7f3d0':'B0EDCF','166534':'185A3E',
    # red/rose
    'ef4444':'F0645C','fb7185':'F0645C','f87171':'F5837C','e11d48':'DC4B44',
    'fecdd3':'F9A39D','fca5a5':'F9A39D','dc2626':'DC4B44','b91c1c':'B23A34',
    '991b1b':'99302B','fee2e2':'FADCDA',
    # amber -> orange (warning)
    'f59e0b':'F98E3F','fbbf24':'FBAF6B','fcd34d':'FCC48D','d97706':'E07A2F',
    'fde68a':'FCCB9E','f97316':'F07A35','ea580c':'E07A2F','d4a72c':'D9A036',
    'fef3c7':'FBF3DD','78350f':'4E3015','b45309':'B0611F',
    # blue (non-brand usages -> muted steel; brand button keeps its own)
    '3b82f6':'4A8FD0','2563eb':'3A76B8','1d4ed8':'2F5F9B','60a5fa':'6AA9DE',
    '93c5fd':'8FBFE8','dbeafe':'DCE9F5','eff6ff':'EAF2FB','1e40af':'2C5FA6',
    '1e3a8a':'254E88','bfdbfe':'C4DCF0',
    # pink -> coral
    'ec4899':'E8654F','f472b6':'EF8A73','db2777':'D14E3B','be185d':'AE3C2C',
    'fbcfe8':'FAC7BC','f9a8d4':'F5A48F','fdf2f8':'FEF1EE',
    # purple -> copper
    'd946ef':'D08A4A','c084fc':'E3AC81','9f1239':'8B2F23',
}

# ---------- RGBA mapping (channel triplet -> new triplet) ----------
RGBA_MAP = {
    (99,102,241):(217,160,54),    # indigo-600 -> gold
    (129,140,248):(229,180,78),   # indigo-400 -> gold light
    (165,180,252):(239,201,104),  # indigo-300 -> gold lighter
    (79,70,229):(188,134,35),     # indigo-700 -> gold deep
    (67,56,202):(150,105,28),     # indigo-800
    (139,92,246):(199,126,60),    # violet -> copper
    (168,85,247):(199,126,60),    # purple -> copper
    (147,51,234):(166,100,40),
    (34,211,238):(74,214,190),    # cyan -> teal
    (56,189,248):(74,214,190),    # sky -> teal
    (14,165,233):(47,191,166),
    (16,185,129):(53,196,126),    # emerald -> emerald new
    (52,211,153):(61,214,140),
    (5,150,105):(43,179,119),
    (6,95,70):(36,146,97),
    (239,68,68):(240,100,92),     # red -> rose
    (251,113,133):(240,100,92),   # rose
    (248,113,113):(245,131,124),
    (220,38,38):(220,75,68),
    (245,158,11):(249,142,63),    # amber -> orange
    (251,191,36):(251,175,107),   # amber-400
    (217,119,6):(224,122,47),
    (249,115,22):(240,122,53),
    (59,130,246):(63,127,204),    # blue -> steel (brand)
    (37,99,235):(44,95,166),
    (232,121,249):(208,138,74),
    (15,23,42):(23,19,16),        # slate-900 -> espresso
    (30,41,59):(36,31,24),        # slate-800
    (51,65,85):(59,52,42),        # slate-700
    (100,116,139):(138,127,114),  # slate-500
    (148,163,184):(176,166,149),  # slate-400
    (203,213,225):(214,204,192),  # slate-300
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
]

BASE = '/home/z/my-project/postyar-work/'

hex_pattern = re.compile(r'#([0-9a-fA-F]{6})\b')
rgba_pattern = re.compile(r'rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)\s*(?:,\s*([0-9.]+)\s*)?\)')

def map_hex6(m):
    h = m.group(1).lower()
    return '#' + HEX_MAP.get(h, m.group(1))

def map_rgba(m):
    r, g, b = int(m.group(1)), int(m.group(2)), int(m.group(3))
    a = m.group(4)
    key = (r, g, b)
    if key in RGBA_MAP:
        nr, ng, nb = RGBA_MAP[key]
        if a is not None:
            return f'rgba({nr},{ng},{nb},{a})'
        return f'rgb({nr},{ng},{nb})'
    return m.group(0)

total_repl = 0
for rel in FILES:
    path = os.path.join(BASE, rel)
    if not os.path.exists(path):
        print(f'SKIP (missing): {rel}'); continue
    src = open(path, encoding='utf-8').read()
    out = src
    out, n1 = hex_pattern.subn(map_hex6, out)
    out, n2 = rgba_pattern.subn(map_rgba, out)
    changed = (out != src)
    if changed:
        open(path, 'w', encoding='utf-8').write(out)
    print(f'{rel}: hex={n1} rgba={n2} changed={changed}')
    total_repl += n1 + n2

print(f'TOTAL color tokens processed: {total_repl}')
