<?php
require_once '../config/database.php';
require_once '../includes/functions.php';
session_start();
requireLogin();

$user_id = $_SESSION['user_id'];
$step = $_GET['step'] ?? 1;
$idea_id = $_GET['id'] ?? null;
$mode = $_GET['mode'] ?? 'forward'; // forward or reverse

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idea_id = $_POST['idea_id'] ?? null;
    
    if (!$idea_id) {
        // Create new idea
        $stmt = $conn->prepare("INSERT INTO ideas (user_id, title, industry, is_reverse_mode) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $_POST['title'], $_POST['industry'], $mode === 'reverse' ? 1 : 0]);
        $idea_id = $conn->lastInsertId();
        
        // Add owner as collaborator
        $stmt = $conn->prepare("INSERT INTO collaborators (idea_id, user_id, role, permissions) VALUES (?, ?, 'owner', 'admin')");
        $stmt->execute([$idea_id, $user_id]);
        
        logActivity($conn, $user_id, 'idea_created', 'Created new idea: ' . $_POST['title'], $idea_id);
        updateCredibilityPoints($conn, $user_id, 10);
    } else {
        // Update existing idea
        $fields = ['description', 'problem_statement', 'solution', 'target_market', 'revenue_model', 'competitive_advantage', 'execution_plan', 'status'];
        $updates = [];
        $values = [];
        
        foreach ($fields as $field) {
            if (isset($_POST[$field])) {
                $updates[] = "$field = ?";
                $values[] = $_POST[$field];
            }
        }
        
        if (!empty($updates)) {
            $values[] = $idea_id;
            $stmt = $conn->prepare("UPDATE ideas SET " . implode(', ', $updates) . " WHERE id = ?");
            $stmt->execute($values);
            
            // Update progress
            $stmt = $conn->prepare("SELECT * FROM ideas WHERE id = ?");
            $stmt->execute([$idea_id]);
            $idea = $stmt->fetch(PDO::FETCH_ASSOC);
            $progress = calculateProgress($idea);
            
            $stmt = $conn->prepare("UPDATE ideas SET progress_percentage = ? WHERE id = ?");
            $stmt->execute([$progress, $idea_id]);
            
            logActivity($conn, $user_id, 'idea_updated', 'Updated idea step ' . $step, $idea_id);
            updateCredibilityPoints($conn, $user_id, 5);
        }
    }
    
    // Move to next step
    $next_step = (int)$step + 1;
    if ($next_step > 7) {
        header("Location: idea_view.php?id=$idea_id");
    } else {
        header("Location: idea_wizard.php?id=$idea_id&step=$next_step&mode=$mode");
    }
    exit;
}

// Load existing idea if editing
$idea = null;
if ($idea_id) {
    $stmt = $conn->prepare("SELECT * FROM ideas WHERE id = ? AND user_id = ?");
    $stmt->execute([$idea_id, $user_id]);
    $idea = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($idea) {
        $mode = $idea['is_reverse_mode'] ? 'reverse' : 'forward';
    }
}

$industries = ['technology', 'agriculture', 'services', 'retail', 'healthcare', 'education', 'other'];
$steps_forward = ['Basic Info', 'Problem', 'Solution', 'Market', 'Revenue', 'Advantage', 'Execution'];
$steps_reverse = ['End Goal', 'Execution', 'Advantage', 'Revenue', 'Market', 'Solution', 'Problem'];
$steps = $mode === 'reverse' ? $steps_reverse : $steps_forward;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Idea Wizard - IdeateHub</title>
    <link rel="stylesheet" href="../assets/css/theme.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <?php include '../includes/header.php'; ?>

    <div class="max-w-4xl mx-auto py-10 px-6">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    <?php echo $mode === 'reverse' ? 'Reverse-Mode' : 'Forward-Mode'; ?> Business Idea Wizard
                </h1>
                <p class="text-gray-600">
                    <?php echo $mode === 'reverse' ? 'Start with your end goal and work backward' : 'Build your idea step by step'; ?>
                </p>
            </div>

            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between mb-2">
                    <?php foreach ($steps as $i => $s): ?>
                        <div class="flex-1 text-center">
                            <div class="w-8 h-8 mx-auto rounded-full <?php echo ($i + 1) <= $step ? 'bg-blue-600 text-white' : 'bg-gray-300 text-gray-600'; ?> flex items-center justify-center text-sm font-bold">
                                <?php echo $i + 1; ?>
                            </div>
                            <p class="text-xs mt-1 <?php echo ($i + 1) <= $step ? 'text-blue-600' : 'text-gray-500'; ?>"><?php echo $s; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo ($step / 7) * 100; ?>%"></div>
                </div>
            </div>

            <form method="POST">
                <input type="hidden" name="idea_id" value="<?php echo $idea_id; ?>">
                
                <?php if ($step == 1 && !$idea_id): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">What's your business idea called?</label>
                        <input type="text" name="title" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" required>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">Select Industry</label>
                        <select name="industry" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" required>
                            <?php foreach ($industries as $ind): ?>
                                <option value="<?php echo $ind; ?>"><?php echo ucfirst($ind); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">Brief Description</label>
                        <textarea name="description" rows="4" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Describe your idea in a few sentences..."></textarea>
                    </div>
                
                <?php elseif ($step == 2): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'What is your end goal?' : 'What problem are you solving?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'execution_plan' : 'problem_statement'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Describe in detail..."><?php echo $idea[$mode === 'reverse' ? 'execution_plan' : 'problem_statement'] ?? ''; ?></textarea>
                    </div>
                
                <?php elseif ($step == 3): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'How will you execute?' : 'What is your solution?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'competitive_advantage' : 'solution'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Explain your approach..."><?php echo $idea[$mode === 'reverse' ? 'competitive_advantage' : 'solution'] ?? ''; ?></textarea>
                    </div>
                
                <?php elseif ($step == 4): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'What makes you different?' : 'Who is your target market?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'revenue_model' : 'target_market'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Define your target audience..."><?php echo $idea[$mode === 'reverse' ? 'revenue_model' : 'target_market'] ?? ''; ?></textarea>
                    </div>
                
                <?php elseif ($step == 5): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'Who are your customers?' : 'What is your revenue model?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'target_market' : 'revenue_model'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="How will you make money?"><?php echo $idea[$mode === 'reverse' ? 'target_market' : 'revenue_model'] ?? ''; ?></textarea>
                    </div>
                
                <?php elseif ($step == 6): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'What solution do you offer?' : 'What is your competitive advantage?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'solution' : 'competitive_advantage'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="What makes you unique?"><?php echo $idea[$mode === 'reverse' ? 'solution' : 'competitive_advantage'] ?? ''; ?></textarea>
                    </div>
                
                <?php elseif ($step == 7): ?>
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">
                            <?php echo $mode === 'reverse' ? 'What problem does this solve?' : 'What is your execution plan?'; ?>
                        </label>
                        <textarea name="<?php echo $mode === 'reverse' ? 'problem_statement' : 'execution_plan'; ?>" rows="6" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500" placeholder="Outline your plan..."><?php echo $idea[$mode === 'reverse' ? 'problem_statement' : 'execution_plan'] ?? ''; ?></textarea>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-lg font-semibold mb-2">Current Status</label>
                        <select name="status" class="w-full border-2 border-gray-300 px-4 py-3 rounded-lg focus:border-blue-500">
                            <option value="concept">Concept</option>
                            <option value="validation">Validation</option>
                            <option value="planning">Planning</option>
                            <option value="execution">Execution</option>
                        </select>
                    </div>
                <?php endif; ?>

                <div class="flex justify-between mt-8">
                    <?php if ($step > 1 && $idea_id): ?>
                        <a href="idea_wizard.php?id=<?php echo $idea_id; ?>&step=<?php echo $step - 1; ?>&mode=<?php echo $mode; ?>" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400">
                            <i class="fas fa-arrow-left mr-2"></i>Previous
                        </a>
                    <?php else: ?>
                        <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-400">Cancel</a>
                    <?php endif; ?>
                    
                    <button type="submit" class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700">
                        <?php echo $step == 7 ? 'Complete' : 'Next'; ?> <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
