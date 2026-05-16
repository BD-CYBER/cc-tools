<?php
$output_cards = "";
function getLuhnCheckDigit($number) {
    $sum = 0; $odd = true;
    for ($i = strlen($number) - 1; $i >= 0; $i--) {
        $digit = (int)$number[$i];
        if ($odd = !$odd) { $digit *= 2; if ($digit > 9) $digit -= 9; }
        $sum += $digit;
    }
    return (10 - ($sum % 10)) % 10;
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bin'])) {
    $bin = str_ireplace('x', '', trim($_POST['bin']));
    if (!empty($bin)) {
        $results = [];
        for ($i = 0; $i < 10; $i++) {
            $cc = $bin;
            while (strlen($cc) < 15) { $cc .= rand(0, 9); }
            $cc .= getLuhnCheckDigit($cc);
            $m = !empty($_POST['month']) ? trim($_POST['month']) : str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $y = !empty($_POST['year']) ? trim($_POST['year']) : rand(2026, 2032);
            $c = !empty($_POST['cvv']) ? trim($_POST['cvv']) : rand(100, 999);
            $results[] = "$cc|$m|$y|$c";
        }
        $output_cards = implode("\n", $results);
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8"><title>Card Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #0b132a; }</style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-5 text-white">
    <div class="w-full max-w-md bg-[#0f1b35] border border-[#1e2d4a] p-6 rounded-[22px] shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#ff2a85]">🔄 Card Generator (Protected)</h2>
            <a href="../index.html" class="text-xs text-gray-400 hover:underline">&larr; Back</a>
        </div>
        <form method="POST" action="" class="space-y-4">
            <input type="text" name="bin" placeholder="BIN লিখুন (e.g. 400000)" class="w-full bg-[#0b132a] border border-[#1e2d4a] p-4 rounded-xl text-white outline-none focus:border-[#ff2a85]" required>
            <div class="grid grid-cols-2 gap-2">
                <input type="text" name="month" placeholder="মাস (MM)" class="bg-[#0b132a] border border-[#1e2d4a] p-3 rounded-xl text-white outline-none">
                <input type="text" name="year" placeholder="বছর (YYYY)" class="bg-[#0b132a] border border-[#1e2d4a] p-3 rounded-xl text-white outline-none">
            </div>
            <input type="text" name="cvv" placeholder="CVV" class="w-full bg-[#0b132a] border border-[#1e2d4a] p-3 rounded-xl text-white outline-none">
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#ff2a85] to-[#d81b60] rounded-xl font-bold">GENERATE</button>
        </form>
        <?php if (!empty($output_cards)): ?>
            <textarea rows="6" class="w-full mt-4 bg-[#0b132a] border border-[#1e2d4a] p-3 rounded-xl text-xs font-mono text-green-400 outline-none" readonly><?php echo htmlspecialchars($output_cards); ?></textarea>
        <?php endif; ?>
    </div>
</body>
</html>
