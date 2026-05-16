<?php
$check_message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cc'])) {
    $cc = preg_replace('/\D/', '', trim($_POST['cc']));
    if (strlen($cc) >= 13) {
        $sum = 0; $shouldDouble = false;
        for ($i = strlen($cc) - 1; $i >= 0; $i--) {
            $digit = (int)$cc[$i];
            if ($shouldDouble) { $digit *= 2; if ($digit > 9) $digit -= 9; }
            $sum += $digit; $shouldDouble = !$shouldDouble;
        }
        if ($sum % 10 === 0) { $check_message = "<span class='text-green-400'>Valid Structure (Luhn Passed)</span>"; }
        else { $check_message = "<span class='text-red-400'>Invalid Structure</span>"; }
    } else { $check_message = "<span class='text-red-400'>অকার্যকর নম্বর দৈর্ঘ্য</span>"; }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8"><title>Card Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #0b132a; }</style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-5 text-white">
    <div class="w-full max-w-md bg-[#0f1b35] border border-[#1e2d4a] p-6 rounded-[22px] shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#00bfa5]">✓ Card Checker (Protected)</h2>
            <a href="../index.html" class="text-xs text-gray-400 hover:underline">&larr; Back</a>
        </div>
        <form method="POST" action="" class="space-y-4">
            <input type="text" name="cc" placeholder="কার্ড নম্বরটি লিখুন" class="w-full bg-[#0b132a] border border-[#1e2d4a] p-4 rounded-xl text-white outline-none focus:border-[#00bfa5]" required>
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#00bfa5] to-[#00897b] rounded-xl font-bold">VALIDATE</button>
        </form>
        <?php if (!empty($check_message)): ?>
            <div class="text-center font-bold text-lg mt-4"><?php echo $check_message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
