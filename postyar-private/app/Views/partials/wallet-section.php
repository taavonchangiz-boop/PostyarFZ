<?php
// $balance, $transactions, $points
// These variables must be set before including this partial.
$tf = \WHCM\Domain\TextFormat::class;
?>
<div class="card">
    <h2>💰 کیف پول و تراکنش‌ها</h2>
    <p style="color:var(--text-muted); font-size:0.85rem; line-height:1.7; margin-bottom:1.5rem;">
        موجودی کیف پول و تاریخچه تراکنش‌های مالی شما در این بخش نمایش داده می‌شود.
    </p>

    <!-- موجودی کیف پول -->
    <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin-bottom:1.5rem;">
        <div style="background:linear-gradient(135deg, rgba(53,196,126,0.25) 0%, rgba(53,196,126,0.05) 100%); border:1px solid rgba(53,196,126,0.4); border-radius:16px; padding:1.25rem; text-align:center;">
            <div style="font-size:0.8rem; color:#7FE6AC; margin-bottom:0.3rem;">💰 موجودی کیف پول</div>
            <div style="font-size:2rem; font-weight:900; color:#3DD68C;"><?php echo $tf::fa_num($balance); ?></div>
            <div style="font-size:0.75rem; color:#B0A695; margin-top:0.15rem;">تومان</div>
        </div>
        <div style="background:linear-gradient(135deg, rgba(251,175,107,0.25) 0%, rgba(251,175,107,0.05) 100%); border:1px solid rgba(251,175,107,0.4); border-radius:16px; padding:1.25rem; text-align:center;">
            <div style="font-size:0.8rem; color:#FCCB9E; margin-bottom:0.3rem;">⭐ امتیازات</div>
            <div style="font-size:2rem; font-weight:900; color:#FBAF6B;"><?php echo $tf::fa_num($points); ?></div>
            <div style="font-size:0.75rem; color:#B0A695; margin-top:0.15rem;">امتیاز</div>
        </div>
        <div style="background:linear-gradient(135deg, rgba(217,160,54,0.25) 0%, rgba(217,160,54,0.05) 100%); border:1px solid rgba(217,160,54,0.4); border-radius:16px; padding:1.25rem; text-align:center;">
            <div style="font-size:0.8rem; color:#EFC968; margin-bottom:0.3rem;">💳 ارزش امتیازات</div>
            <div style="font-size:2rem; font-weight:900; color:#E5B44E;"><?php echo $tf::fa_num($points * 10); ?></div>
            <div style="font-size:0.75rem; color:#B0A695; margin-top:0.15rem;">تومان</div>
        </div>
    </div>

    <!-- تبدیل امتیاز به کیف پول -->
    <div style="background:#241F18; border:1px dashed #35C47E; border-radius:12px; padding:1rem; margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:1rem;">
        <div>
            <span style="color:#B0A695; font-size:0.85rem;">تبدیل امتیاز به موجودی کیف پول:</span>
            <span style="color:#8A7F72; font-size:0.8rem;"> (هر ۱۰ امتیاز = ۱۰ تومان)</span>
        </div>
        <form action="<?php echo \WHCM\Core\Bootstrap::getRouteUrl('/dashboard/convert-points'); ?>" method="POST" style="display:flex; align-items:center; gap:0.5rem;">
            <?php echo \WHCM\Core\Csrf::field(); ?>
            <input type="number" name="points" min="1" max="<?php echo (int)$points; ?>" placeholder="تعداد امتیاز" required
                style="width:120px; background:#171310; color:white; border:1px solid #3B342A; border-radius:8px; padding:0.5rem; text-align:center;">
            <button type="submit" class="btn btn-success" style="padding:0.5rem 1rem; font-size:0.85rem;">💰 تبدیل</button>
        </form>
    </div>

    <!-- تاریخچه تراکنش‌ها -->
    <h3 style="font-size:0.95rem; margin-bottom:0.75rem; border-bottom:1px dashed var(--border); padding-bottom:0.4rem; color:#EFC968;">📊 تاریخچه تراکنش‌ها</h3>
    <?php if (empty($transactions)): ?>
        <p style="color:var(--text-muted); text-align:center; padding:1.5rem 0;">تراکنشی در کیف پول شما ثبت نشده است.</p>
    <?php else: ?>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>نوع</th>
                        <th>مبلغ (تومان)</th>
                        <th>موجودی پس از تراکنش</th>
                        <th>تاریخ</th>
                        <th>توضیحات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($transactions as $t): ?>
                    <tr>
                        <td>
                            <?php 
                                $typeLabels = [
                                    'referral_purchase' => '🎯 پاداش زیرمجموعه',
                                    'cashback' => '💳 کش‌بک',
                                    'points_convert' => '⭐ تبدیل امتیاز',
                                    'debit' => '🔴 برداشت',
                                    'credit' => '🟢 واریز',
                                ];
                                echo $typeLabels[$t['type']] ?? $t['type'];
                            ?>
                        </td>
                        <td style="font-weight:700; <?php echo $t['amount'] >= 0 ? 'color:#3DD68C;' : 'color:#F0645C;'; ?>">
                            <?php echo $t['amount'] >= 0 ? '+' : ''; ?><?php echo $tf::fa_num($t['amount']); ?>
                        </td>
                        <td style="color:#EFC968;"><?php echo $tf::fa_num($t['balance_after']); ?></td>
                        <td style="font-size:0.85rem;"><?php echo $tf::mysql_to_jalali($t['created_at']); ?></td>
                        <td style="font-size:0.8rem; color:#B0A695; max-width:200px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="<?php echo htmlspecialchars($t['description'] ?? ''); ?>"><?php echo htmlspecialchars(mb_substr($t['description'] ?? '', 0, 40)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
