<?php
$result_html = "";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bin'])) {
    $bin = trim($_POST['bin']);
    if (strlen($bin) >= 6) {
        $api_url = "https://data.handyapi.com/bin/" . urlencode($bin);
        $response = @file_get_contents($api_url);
        if ($response) {
            $data = json_decode($response, true);
            if (isset($data['Status']) && $data['Status'] === "SUCCESS") {
                $result_html = "
                    <p><span class='text-gray-400'>Brand:</span> ".($data['Scheme'] ?? 'Unknown')."</p>
                    <p><span class='text-gray-400'>Type:</span> ".($data['Type'] ?? 'Unknown')."</p>
                    <p><span class='text-gray-400'>Country:</span> ".($data['Country']['Name'] ?? 'Unknown')."</p>
                    <p><span class='text-gray-400'>Bank:</span> ".($data['Bank'] ?? 'Unknown')."</p>";
            } else { $result_html = "<p class='text-red-400'>কোনো তথ্য পাওয়া যায়নি।</p>"; }
        } else { $result_html = "<p class='text-red-400'>সার্ভার সংযোগে ত্রুটি।</p>"; }
    } else { $result_html = "<p class='text-red-400'>নূন্যতম ৬টি সংখ্যা দিন।</p>"; }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8"><title>BIN Checker</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>body { background-color: #0b132a; font-family: sans-serif; }</style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-5 text-white">
    <div class="w-full max-w-md bg-[#0f1b35] border border-[#1e2d4a] p-6 rounded-[22px] shadow-xl">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-[#ff9f05]">🔍 BIN Checker (Protected)</h2>
            <a href="../index.html" class="text-xs text-gray-400 hover:underline">&larr; Back</a>
        </div>
        <form method="POST" action="" class="flex flex-col gap-4">
            <input type="number" name="bin" placeholder="প্রথম ৬ বা ৮ সংখ্যা লিখুন" class="w-full bg-[#0b132a] border border-[#1e2d4a] p-4 rounded-xl text-white outline-none focus:border-[#ff9f05]" required>
            <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#ff9f05] to-[#f57c00] rounded-xl font-bold">CHECK BIN</button>
        </form>
        <?php if (!empty($result_html)): ?>
            <div class="mt-4 p-4 bg-[#0b132a] border border-[#1e2d4a] rounded-xl text-sm space-y-2"><?php echo $result_html; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
