<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>خطا | <?php echo htmlspecialchars($code); ?></title>
    <link rel="stylesheet" href="<?php echo \WHCM\Core\Bootstrap::getAssetsUrl(); ?>/css/components.css">
    <style>
        *{box-sizing:border-box}body{font-family:Vazirmatn,Tahoma,sans-serif;background:radial-gradient(760px 440px at 100% 0,rgba(217,160,54,.14),transparent 62%),radial-gradient(620px 420px at 0 100%,rgba(240,100,92,.06),transparent 64%),#0D0B08;color:#FBF8F3;margin:0;min-height:100svh;display:grid;place-items:center;padding:clamp(16px,4vw,42px);overflow-x:hidden}.container{position:relative;isolation:isolate;text-align:center;background:linear-gradient(160deg,rgba(46,40,32,.96),rgba(17,14,11,.98));padding:clamp(28px,5vw,56px);border-radius:28px;box-shadow:0 30px 90px rgba(6,4,2,.4),inset 0 1px 0 rgba(255,248,230,.04);max-width:560px;width:min(100%,560px);border:1px solid rgba(229,180,78,.2);overflow:hidden}.container:before{content:"";position:absolute;inset:0 0 auto;height:3px;background:linear-gradient(90deg,#F0645C,#E5B44E,#4AD6BE);z-index:-1}.container:after{content:"";position:absolute;width:220px;height:220px;border-radius:50%;background:rgba(217,160,54,.1);filter:blur(6px);top:-120px;right:-90px;z-index:-1}h1{font-size:clamp(5rem,18vw,9rem);margin:0;color:#F6E7C2;line-height:.9;letter-spacing:-.07em;text-shadow:0 16px 48px rgba(217,160,54,.22)}h2{font-size:clamp(1.25rem,4vw,1.75rem);margin:1.35rem 0 .7rem;color:#FBF8F3;line-height:1.6}p{font-size:.94rem;color:#B0A695;line-height:2;margin:0 auto 2rem;max-width:430px}.btn{min-height:48px;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:linear-gradient(135deg,#EDBE55,#D9A036);color:#1F1502;text-decoration:none;padding:.78rem 1.35rem;border-radius:14px;font-weight:800;font-size:.9rem;box-shadow:0 14px 32px rgba(217,160,54,.24);transition:transform .18s cubic-bezier(.22,.8,.24,1),box-shadow .18s,filter .18s}.btn:hover{transform:translateY(-2px);filter:brightness(1.06);box-shadow:0 20px 42px rgba(217,160,54,.34)}.btn:active{transform:scale(.985)}@media(max-width:480px){.container{border-radius:22px;padding:30px 20px}h1{font-size:5.6rem}p{font-size:.88rem}.btn{width:100%}}@media(orientation:landscape) and (max-height:700px){body{padding:14px}.container{padding:24px 30px;max-width:720px}h1{font-size:5rem;margin-bottom:.5rem}h2{margin:.5rem 0}.btn{min-height:44px}}
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($code); ?></h1>
        <h2>اوه! مسیر مورد نظر در دسترس نیست</h2>
        <p><?php echo htmlspecialchars($message ?: 'متأسفانه صفحه‌ای که به دنبال آن بودید پیدا نشد یا در پردازش درخواست مشکلی به وجود آمده است.'); ?></p>
        <a href="/" class="btn">بازگشت به صفحه اصلی <span aria-hidden="true">←</span></a>
    </div>
</body>
</html>