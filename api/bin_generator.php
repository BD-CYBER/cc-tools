<?php
$generated_bin = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cardType'])) {
    $prefix = trim($_POST['cardType']);
    $bin = $prefix;
    for ($i = 0; $i < 5; $i++) { $bin .= rand(0, 9); }
    $generated_bin = "Generated BIN: " . $bin . "xxxxxx";
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8"><title>BIN Generator</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #0b132a; }</style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-5 text-white">
    <div class="w-full max-w-md bg-[#0f1b35] border border-[#1e2d4a] p-6 rounded-[22px] shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#ff5722]">⚙️ BIN Generator (Protected)</h2>
            <a href="../index.html" class="text-xs text-gray-400 hover:underline">&larr; Back</a>
        </div>
        <form method="POST" action="" class="space-y-4">
            <select name="cardType" class="w-full bg-[#0b132a] border border-[#1e2d4a] p-4 rounded-xl text-white outline-none">
                <option value="4">Visa (Starts with 4)</option>
                <option value="5">Mastercard (Starts with 5)</option>
                <option value="3">American Express (Starts with 3)</option>
            </select>
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#ff5722] to-[#e64a19] rounded-xl font-bold">GENERATE BIN</button>
        </form>
        <?php if (!empty($generated_bin)): ?>
            <div class="p-4 mt-4 bg-[#0b132a] border border-[#1e2d4a] rounded-xl text-center font-mono font-bold text-lg text-yellow-400">
                <?php echo $generated_bin; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
