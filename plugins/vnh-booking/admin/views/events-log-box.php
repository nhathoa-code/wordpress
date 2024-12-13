<ul>
    <?php foreach($log as $item): ?>
        <li>
            <?php echo "{$item["event"]} - {$item["date-time"]}"; ?>
        </li>
    <?php endforeach; ?>
</ul>