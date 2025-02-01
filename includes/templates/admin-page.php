<?php
global $wpdb;
$table_name = $wpdb->prefix . 'formbizz_submissions';

// Fetch data
$entries = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC");

?>
<div class="wrap">
    <h1>Form Bizz Submissions</h1>

    <?php if ($entries) : ?>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($entries as $entry) : ?>
                    <tr>
                        <td><?php echo esc_html($entry->id); ?></td>
                        <td><?php echo esc_html($entry->name); ?></td>
                        <td><?php echo esc_html($entry->email); ?></td>
                        <td><?php echo esc_textarea($entry->message); ?></td>
                        <td><?php echo esc_html(gmdate('Y-m-d H:i:s', strtotime($entry->created_at))); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No form submissions found.</p>
    <?php endif; ?>
</div>
