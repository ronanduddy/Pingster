<?php

/* Whether this should be in a pingster config or an AWS/S3 config is debatable.
 * However, the current argument is that this is a setting for Pingster, used in
 * Pingster code, not any plugin or third-party add-on for S3. Perhaps, pingster-s3
 * would be more accurate, but overly specific
 */
$config['Pingster']['s3_bucket'] = getenv('AWS_S3_BUCKET');
