<?php
// $referralCode, $referralLink, $stats, $history, $points, $enabled
// These variables must be set before including this partial.
if (!isset($enabled)) $enabled = true;
$tf = \WHCM\Domain\TextFormat::class;
?>
<div class="card">
    <h2>🎯 سیستم زیرمجموعه‌گیری</h2>
    <p style="color:var(--text-muted); font-size:0.85rem; line-height:1.7; margin-bottom:1.5rem;">
        با دعوت دوستان خود از لینک زیرمجموعه‌گیری، امتیاز و پاداش کسب کنید!
    </p>

    <?php if (!$enabled): ?>
        <div style="background:rgba(240,100,92,0.15); border:1px solid rgba(240,100,92,0.3); border-radius:12px; padding:1rem; color:#F9A39D; text-align:center; margin-bottom:1.5rem;">
            ⚠ سیستم زیرمجموعه‌گیری در حال حاضر غیرفعال است.
        </div>
    <?php endif; ?>

    <!-- کد و لینک معرف -->
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1.5rem;">
        <div class="form-group">
            <label style="color:#B0A695; font-size:0.85rem;">کد معرف شما:</label>
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <input type="text" id="ref-code" value="<?php echo htmlspecialchars($referralCode); ?>" readonly
                    style="flex:1; background:#241F18; color:#4AD6BE; font-weight:900; font-size:1.05rem; border:1px solid #BC8623; border-radius:10px; padding:0.65rem; text-align:center; direction:ltr;">
                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('ref-code').value).then(function(){ document.getElementById('copy-ref-toast').style.display='block'; setTimeout(function(){ document.getElementById('copy-ref-toast').style.display='none'; }, 2000); })" 
                    style="background:#BC8623; color:white; border:none; border-radius:10px; padding:0.65rem 1rem; cursor:pointer; font-weight:700; white-space:nowrap;">📋 کپی</button>
            </div>
        </div>
        <div class="form-group">
            <label style="color:#B0A695; font-size:0.85rem;">لینک دعوت:</label>
            <div style="display:flex; align-items:center; gap:0.5rem;">
                <input type="text" id="ref-link" value="<?php echo htmlspecialchars($referralLink); ?>" readonly
                    style="flex:1; background:#241F18; color:#3DD68C; font-size:0.85rem; border:1px solid #2BB377; border-radius:10px; padding:0.65rem; direction:ltr; overflow:hidden; text-overflow:ellipsis;">
                <button type="button" onclick="navigator.clipboard.writeText(document.getElementById('ref-link').value).then(function(){ document.getElementById('copy-ref-toast').style.display='block'; setTimeout(function(){ document.getElementById('copy-ref-toast').style.display='none'; }, 2000); })" 
                    style="background:#2BB377; color:white; border:none; border-radius:10px; padding:0.65rem 1rem; cursor:pointer; font-weight:700; white-space:nowrap;">🔗 کپی</button>
            </div>
        </div>
    </div>

    <div id="copy-ref-toast" style="display:none; position:fixed; bottom:2rem; left:50%; transform:translateX(-50%); background:#35C47E; color:white; padding:0.75rem 1.5rem; border-radius:12px; font-weight:700; z-index:9999; box-shadow:0 8px 25px rgba(0,0,0,0.4);">
        با موفقیت کپی شد! 📋
    </div>

    <!-- آمار زیرمجموعه‌ها -->
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin-bottom:1.5rem;">
        <div style="background:linear-gradient(135deg, rgba(217,160,54,0.2) 0%, rgba(217,160,54,0.05) 100%); border:1px solid rgba(217,160,54,0.3); border-radius:12px; padding:1rem; text-align:center;">
            <div style="font-size:1.8rem; font-weight:900; color:#E5B44E;"><?php echo $tf::fa_num($stats['total']); ?></div>
            <div style="font-size:0.8rem; color:#B0A695; margin-top:0.25rem;">کل زیرمجموعه‌ها</div>
        </div>
        <div style="background:linear-gradient(135deg, rgba(53,196,126,0.2) 0%, rgba(53,196,126,0.05) 100%); border:1px solid rgba(53,196,126,0.3); border-radius:12px; padding:1rem; text-align:center;">
            <div style="font-size:1.8rem; font-weight:900; color:#3DD68C;"><?php echo $tf::fa_num($stats['rewarded']); ?></div>
            <div style="font-size:0.8rem; color:#B0A695; margin-top:0.25rem;">پاداش‌داده‌شده</div>
        </div>
        <div style="background:linear-gradient(135deg, rgba(251,175,107,0.2) 0%, rgba(251,175,107,0.05) 100%); border:1px solid rgba(251,175,107,0.3); border-radius:12px; padding:1rem; text-align:center;">
            <div style="font-size:1.8rem; font-weight:900; color:#FBAF6B;"><?php echo $tf::fa_num($stats['pending']); ?></div>
            <div style="font-size:0.8rem; color:#B0A695; margin-top:0.25rem;">در انتظار خرید</div>
        </div>
    </div>

    <!-- امتیازات و تبدیل -->
    <div style="background:#241F18; border:1px dashed #BC8623; border-radius:12px; padding:1rem; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div>
            <span style="color:#B0A695; font-size:0.85rem;">امتیازات فعلی شما:</span>
            <span style="font-size:1.3rem; font-weight:900; color:#FBAF6B; margin-right:0.5rem;"><?php echo $tf::fa_num($points); ?></span>
            <span style="color:#8A7F72; font-size:0.8rem;">امتیاز (هر ۱۰ امتیاز = ۱۰ تومان)</span>
        </div>
        <form action="<?php echo \WHCM\Core\Bootstrap::getRouteUrl('/dashboard/convert-points'); ?>" method="POST" style="display:flex; align-items:center; gap:0.5rem;">
            <?php echo \WHCM\Core\Csrf::field(); ?>
            <input type="number" name="points" min="1" max="<?php echo (int)$points; ?>" placeholder="تعداد امتیاز" required
                style="width:120px; background:#171310; color:white; border:1px solid #3B342A; border-radius:8px; padding:0.5rem; text-align:center;">
            <button type="submit" class="btn btn-success" style="padding:0.5rem 1rem; font-size:0.85rem;">💰 تبدیل به کیف پول</button>
        </form>
    </div>

    <!-- تاریخچه زیرمجموعه‌ها -->
    <h3 style="font-size:0.95rem; margin-bottom:0.75rem; border-bottom:1px dashed var(--border); padding-bottom:0.4rem; color:#EFC968;">📋 تاریخچه زیرمجموعه‌ها</h3>
    <?php if (empty($history)): ?>
        <p style="color:var(--text-muted); text-align:center; padding:1.5rem 0;">هنوز زیرمجموعه‌ای ثبت‌نام نکرده است. لینک خود را به اشتراک بگذارید! 🚀</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>نام</th>
                        <th>ایمیل</th>
                        <th>وضعیت</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history as $h): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($h['referred_name'] ?? '—'); ?></td>
                        <td style="direction:ltr; text-align:right; font-size:0.85rem;"><?php echo htmlspecialchars($h['referred_email'] ?? '—'); ?></td>
                        <td>
                            <?php if ($h['status'] === 'rewarded'): ?>
                                <span style="background:rgba(53,196,126,0.2); color:#3DD68C; padding:0.2rem 0.75rem; border-radius:8px; font-size:0.8rem; font-weight:700;">✅ پاداش داده شده</span>
                            <?php else: ?>
                                <span style="background:rgba(251,175,107,0.2); color:#FBAF6B; padding:0.2rem 0.75rem; border-radius:8px; font-size:0.8rem; font-weight:700;">⏳ در انتظار خرید</span>
                            <?php endif; ?>
                        </td>
                        <td style="font-size:0.85rem;"><?php echo $tf::mysql_to_jalali($h['created_at']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
