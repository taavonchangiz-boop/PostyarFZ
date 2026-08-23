#!/usr/bin/env python3
# لندینگ: برگر سه‌بعدی + CTAهای طلایی (رنگ‌های post-remap3)
p = 'postyar-private/app/Views/home.php'
src = open(p, encoding='utf-8').read()

old_btn = '''<button id="mobileToggle" class="lg:hidden p-2 rounded-xl" style="color:#8A93A3;border:1px solid #26324A;" aria-label="منوی موبایل">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>'''
assert old_btn in src, 'mobileToggle button'
new_btn = '''<button id="mobileToggle" class="gt-burger lg:hidden" aria-label="منوی موبایل" aria-expanded="false">
                        <span class="gt-burger-box"><span class="gt-burger-layer"></span><span class="gt-burger-layer"></span><span class="gt-burger-layer"></span></span>
                    </button>'''
src = src.replace(old_btn, new_btn)

anchor = '<script src="<?php echo \\WHCM\\Core\\Bootstrap::getAssetsUrl(); ?>/js/home.js"></script>'.replace('\\\\', '\\')
assert anchor in src, 'home.js anchor'
observer = anchor + '''
    <script>
    (function(){
        var btn = document.getElementById('mobileToggle');
        var menu = document.getElementById('mobileMenu');
        if (!btn || !menu) return;
        var sync = function(){ var open = !menu.classList.contains('hidden'); btn.classList.toggle('is-open', open); btn.setAttribute('aria-expanded', open ? 'true' : 'false'); };
        try { new MutationObserver(sync).observe(menu, { attributes:true, attributeFilter:['class'] }); } catch(e){}
        sync();
    })();
    </script>'''
src = src.replace(anchor, observer, 1)

reps = [
  ('style="background:linear-gradient(135deg,#1ABB9C,#3CCDB2);box-shadow:0 4px 12px rgba(26,187,156,.25);"',
   'style="background:linear-gradient(135deg,#EAC87F,#B08A3E);box-shadow:0 4px 12px rgba(214,172,99,.3);"'),
  ('style="color:#B3BCCB;" onmouseover="this.style.color=\'#1ABB9C\'" onmouseout="this.style.color=\'#B3BCCB\'"',
   'style="color:#C9BFAD;" onmouseover="this.style.color=\'#E9C77E\'" onmouseout="this.style.color=\'#C9BFAD\'"'),
  ("style=\"background:#1ABB9C;color:#fff;box-shadow:0 6px 16px rgba(26,187,156,.3);\"\n                        onmouseover=\"this.style.background='#169F85'\"\n                        onmouseout=\"this.style.background='#1ABB9C'\">",
   "style=\"background:linear-gradient(135deg,#EAC87F,#C1903F);color:#201807;box-shadow:0 6px 18px rgba(214,172,99,.28),inset 0 1px 0 rgba(255,255,255,.3);\"\n                        onmouseover=\"this.style.filter='brightness(1.07)'\"\n                        onmouseout=\"this.style.filter='none'\">"),
  ("style=\"border-color:#D5D8DD;background:#1A2332;color:#8A93A3;box-shadow:rgba(30,38,51,.04) 0 2px 4px 0;\"\n                        onmouseover=\"this.style.background='#141D2B';this.style.color='#E6EBF2'\"\n                        onmouseout=\"this.style.background='#1A2332';this.style.color='#8A93A3'\">",
   "style=\"border-color:rgba(240,234,222,.16);background:#171310;color:#DCD3C4;box-shadow:0 2px 8px rgba(0,0,0,.4),inset 0 1px 0 rgba(240,234,222,.05);\"\n                        onmouseover=\"this.style.borderColor='rgba(214,172,99,.45)';this.style.color='#F5EFE3'\"\n                        onmouseout=\"this.style.borderColor='rgba(240,234,222,.16)';this.style.color='#DCD3C4'\">"),
  ("style=\"background:#1ABB9C;color:#fff;\" onmouseover=\"this.style.background='#3CCDB2'\" onmouseout=\"this.style.background='#1ABB9C'\"",
   "style=\"background:linear-gradient(135deg,#EAC87F,#C1903F);color:#201807;box-shadow:0 8px 26px rgba(214,172,99,.26),inset 0 1px 0 rgba(255,255,255,.3);\" onmouseover=\"this.style.filter='brightness(1.07)'\" onmouseout=\"this.style.filter='none'\""),
  ("style=\"background:#1ABB9C;color:#fff;box-shadow:0 10px 30px rgba(26,187,156,.35);\" onmouseover=\"this.style.background='#3CCDB2'\" onmouseout=\"this.style.background='#1ABB9C'\"",
   "style=\"background:linear-gradient(135deg,#EAC87F,#C1903F);color:#201807;box-shadow:0 10px 34px rgba(214,172,99,.32),inset 0 1px 0 rgba(255,255,255,.3);\" onmouseover=\"this.style.filter='brightness(1.07)'\" onmouseout=\"this.style.filter='none'\""),
  ('style="border-color:#D5D8DD;background:#1A2332;color:#8A93A3;"', 'style="border-color:rgba(214,172,99,.35);background:rgba(214,172,99,.1);color:#E9C77E;"'),
  ('style="background:#1ABB9C;box-shadow:0 6px 16px rgba(26,187,156,.3);"', 'style="background:linear-gradient(135deg,#EAC87F,#C1903F);color:#201807;box-shadow:0 6px 18px rgba(214,172,99,.3);"'),
]
n = 0
for a, b in reps:
    c = src.count(a)
    if c:
        src = src.replace(a, b); n += 1
    else:
        print('skip:', a[:65].replace('\n', '⏎'))
open(p, 'w', encoding='utf-8').write(src)
print(f'applied {n}/{len(reps)}')
