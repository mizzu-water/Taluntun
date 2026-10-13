<?php
$mapFile = 'image_map.json';
$map = file_exists($mapFile) ? json_decode(file_get_contents($mapFile), true) : [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['map'])) {
        $newMap = array_filter($_POST['map'], function($v) { return $v !== ''; });
        file_put_contents($mapFile, json_encode($newMap, JSON_PRETTY_PRINT));
        $success = "Image mappings saved successfully!";
        $map = $newMap;
    }
}

require_once 'auth/config.php';
$conn = getDB();
$degrees = [];
$result = $conn->query("SELECT id, title FROM degrees ORDER BY title");
if ($result) {
    while($row = $result->fetch_assoc()){
        $degrees[] = $row;
    }
}
$conn->close();

$images = glob('assets/images/degrees/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Degree Image Mapper</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .img-preview { width: 120px; height: 80px; object-fit: cover; border-radius: 8px; cursor: pointer; border: 2px solid transparent; }
        .img-preview:hover { border-color: #3b82f6; }
        
        .gallery-item { cursor: pointer; transition: transform 0.2s; }
        .gallery-item:hover { transform: scale(1.05); outline: 3px solid #3b82f6; }
    </style>
</head>
<body class="bg-gray-50 p-8">
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-xl shadow-md relative">
        <h1 class="text-3xl font-bold mb-6">Visual Image Mapper</h1>
        <?php if(isset($success)) echo "<div class='bg-green-100 text-green-800 p-4 rounded mb-6'>$success</div>"; ?>
        
        <p class="mb-6 text-gray-600 text-lg">Click the picture next to each degree to open the visual gallery and select the correct image. Click <b>Save Mappings</b> when done.</p>
        
        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php foreach($degrees as $deg): 
                    $currentImage = isset($map[$deg['title']]) ? $map[$deg['title']] : '';
                ?>
                <div class="flex items-center justify-between p-4 border rounded hover:bg-gray-50">
                    <div class="font-bold text-md w-2/3 pr-4"><?= htmlspecialchars($deg['title']) ?></div>
                    
                    <input type="hidden" id="input_<?= $deg['id'] ?>" name="map[<?= htmlspecialchars($deg['title']) ?>]" value="<?= htmlspecialchars($currentImage) ?>">
                    
                    <div class="w-1/3 flex justify-end">
                        <img id="preview_<?= $deg['id'] ?>" src="<?= $currentImage ? '/riasec/' . htmlspecialchars($currentImage) : '/riasec/assets/images/placeholder.jpg' ?>" class="img-preview shadow" onerror="this.src='/riasec/assets/images/placeholder.jpg'" onclick="openModal(<?= $deg['id'] ?>)" title="Click to change image">
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-8 sticky bottom-4 bg-white p-4 border-t shadow-lg flex justify-center rounded-xl z-10">
                <button type="submit" class="bg-blue-600 text-white px-12 py-4 rounded-full text-xl font-bold hover:bg-blue-700 shadow-xl transition">Save Mappings</button>
            </div>
        </form>
    </div>

    <!-- Image Picker Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black/80 hidden z-50 flex flex-col p-8 overflow-y-auto">
        <div class="bg-white p-6 rounded-xl w-full max-w-7xl mx-auto flex-grow relative">
            <div class="flex justify-between items-center mb-6 sticky top-0 bg-white z-10 pb-4 border-b">
                <h2 class="text-2xl font-bold">Select an Image</h2>
                <button onclick="closeModal()" class="bg-gray-200 hover:bg-red-500 hover:text-white px-4 py-2 rounded font-bold transition">Close</button>
            </div>
            
            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                <?php foreach($images as $img): ?>
                <div class="gallery-item relative rounded overflow-hidden shadow-sm aspect-[3/2]" onclick="selectImage('<?= htmlspecialchars($img) ?>')">
                    <img src="/riasec/<?= htmlspecialchars($img) ?>" class="w-full h-full object-cover">
                </div>
                <?php endforeach; ?>
                <div class="gallery-item relative rounded overflow-hidden shadow-sm aspect-[3/2] flex items-center justify-center bg-gray-100 border-2 border-dashed" onclick="selectImage('')">
                    <span class="font-bold text-gray-500">Remove Image</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentTargetId = null;

        function openModal(id) {
            currentTargetId = id;
            document.getElementById('imageModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // prevent scrolling behind modal
        }

        function closeModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
            currentTargetId = null;
        }

        function selectImage(imagePath) {
            if (currentTargetId !== null) {
                // Update hidden input
                document.getElementById('input_' + currentTargetId).value = imagePath;
                
                // Update preview
                let previewUrl = imagePath ? '/riasec/' + imagePath : '/riasec/assets/images/placeholder.jpg';
                document.getElementById('preview_' + currentTargetId).src = previewUrl;
                
                closeModal();
            }
        }
    </script>
</body>
</html>
