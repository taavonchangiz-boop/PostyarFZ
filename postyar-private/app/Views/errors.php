<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>خطا | <?php echo htmlspecialchars($code); ?></title>
    <link rel="stylesheet" href="<?php echo \WHCM\Core\Bootstrap::getAssetsUrl(); ?>/css/components.css">
    <style>
        *{box-sizing:border-box}body{font-family:Vazirmatn,Tahoma,sans-serif;background:radial-gradient(ellipse 60% 50% at 85% 0,rgba(214,172,99,.08),transparent),radial-gradient(ellipse 50% 40% at 0% 100%,rgba(159,180,206,.05),transparent),#0C0A08;color:#F5EFE3;margin:0;min-height:100svh;display:grid;place-items:center;padding:clamp(16px,4vw,42px);overflow-x:hidden}.container{position:relative;isolation:isolate;text-align:center;background:#171310;padding:clamp(28px,5vw,56px);border-radius:12px;box-shadow:rgba(10,15,26,.04) 0 2px 4px 0,0 12px 40px rgba(0,0,0,.08);max-width:560px;width:min(100%,560px);border:1px solid #2B241B}.container:before{content:"";position:absolute;inset:0 0 auto;height:3px;background:linear-gradient(90deg,#D6AC63,#4299E1,#AE3EC9);z-index:-1}h1{font-size:clamp(4.5rem,18vw,8rem);margin:0;color:rgba(214,172,99,.9);line-height:.95;letter-spacing:-.06em;font-weight:900}h2{font-size:clamp(1.2rem,4vw,1.7rem);margin:1.3rem 0 .7rem;color:#F5EFE3;line-height:1.6}p{font-size:.92rem;color:#A99E8E;line-height:2;margin:0 auto 1.9rem;max-width:430px}.btn{min-height:46px;display:inline-flex;align-items:center;justify-content:center;gap:.5rem;background:#D6AC63;color:#fff;text-decoration:none;padding:.75rem 1.3rem;border-radius:6px;font-weight:800;font-size:.9rem;box-shadow:0 6px 16px rgba(214,172,99,.3);transition:all .18s cubic-bezier(.2,0,0,1)}.btn:hover{transform:translateY(-2px);background:#E9C77E;box-shadow:0 10px 26px rgba(214,172,99,.4)}.btn:active{transform:scale(.985)}@media(max-width:480px){.container{border-radius:10px;padding:30px 20px}h1{font-size:5rem}p{font-size:.87rem}.btn{width:100%}}@media(orientation:landscape) and (max-height:700px){body{padding:14px}.container{padding:24px 30px;max-width:720px}h1{font-size:4.6rem;margin-bottom:.5rem}h2{margin:.5rem 0}.btn{min-height:44px}}
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