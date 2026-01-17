<?php
    session_start();
    $current_user = $_SESSION['username'] ?? 'Guest';
    $faqs = [
        "Booking" => [
            ["q" => "How do I book a new event?", "a" => "Navigate to your Dashboard and click the '+ Book New Tickets' button. Select your event and quantity, then confirm."],
            ["q" => "Can I cancel a booking?", "a" => "Yes, as long as the event status is 'Active'. Use the 'Cancel' button next to the event in your dashboard list."],
            ["q" => "Is there a ticket limit?", "a" => "Limits are set by individual event organizers and are displayed during the booking process."]
        ],
    ];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Help Center - Event Manager</title>
    <link rel="stylesheet">
    <style>
        /* Extra styles for FAQ functionality */
        .faq-section { margin-bottom: 30px; }
        .faq-category { color: #007bff; border-bottom: 1px solid #eee; padding-bottom: 10px; margin-top: 20px; }
        .faq-item { background: #f9f9f9; border: 1px solid #ddd; padding: 15px; border-radius: 6px; margin-bottom: 10px; }
        .faq-question { font-weight: bold; color: #333; display: block; margin-bottom: 5px; cursor: pointer; }
        .faq-answer { color: #666; line-height: 1.5; }
        .contact-card { background: #e7f3ff; border: 1px solid #b3d7ff; padding: 20px; border-radius: 8px; text-align: center; }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="scrollable-content-wrapper">
        <div class="dashboard-container">
            <h1>Help & Support Center</h1>
            <p>Welcome, <strong><?php echo htmlspecialchars($current_user); ?></strong>. Need help? Find answers to common questions below.</p>

            <div id="faq-content">
                <?php foreach ($faqs as $category => $items): ?>
                    <div class="faq-section">
                        <h2 class="faq-category"><?php echo $category; ?> Support</h2>
                        <?php foreach ($items as $faq): ?>
                            <div class="faq-item">
                                <span class="faq-question">Q: <?php echo htmlspecialchars($faq['q']); ?></span>
                                <p class="faq-answer"><?php echo htmlspecialchars($faq['a']); ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>

    <?php include 'footer.php'; ?>

</body>
</html>