<?php // create_idea.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Idea</title>
    <link rel="stylesheet" href="theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 p-6">

    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Create a New Business Idea</h2>

        <form action="" method="POST">
            <label class="block mb-2 font-medium">Idea Name</label>
            <input type="text" name="idea_name"
                   class="w-full border px-3 py-2 rounded mb-4" required>

            <label class="block mb-2 font-medium">Brief Description</label>
            <textarea name="description"
                      class="w-full border px-3 py-2 rounded mb-4" rows="4"></textarea>

            <label class="block mb-2 font-medium">Industry</label>
            <select name="industry" class="w-full border px-3 py-2 rounded mb-4">
                <option>Technology</option>
                <option>Agriculture</option>
                <option>Services</option>
                <option>Retail</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Save Idea
            </button>
        </form>

        <div class="mt-4">
            <a href="index.php" class="text-blue-600 hover:underline">← Back</a>
        </div>
    </div>

</body>
</html>
