<?php

return [
    'api_key' => getenv('GOOGLE_API_KEY'. ''),
    'daily_quota' => getenv('GOOGLE_DAILY_QUOTA', 0),
];
