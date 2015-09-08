<?php

return array(
		'gtbill_key' => 'GTBILL_KEY',
		'passwd_file' => __DIR__ . '/../passwords/.htpasswd',
		'encryption_key' => 'mysecretkey',
		'use_encryption' => true,
		'log' => true,
		'log_file' => __DIR__ . '/../logs/log.txt',

        // Allow the IP's that can do requests gtbill
        'allowed_gtbill_ips' => array(
            '216.109.158.98', '216.109.158.100', '216.109.158.115', '216.109.158.117', '63.131.159.102', '63.131.159.104', '216.109.158.113', '216.109.158.114'
        )
	);